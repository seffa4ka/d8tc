<?php

namespace Drupal\currency_converter\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\currency_converter\Entity\ConverterEntityInterface;

/**
 * Class ConverterEntityController.
 *
 *  Returns responses for Converter entity routes.
 *
 * @package Drupal\currency_converter\Controller
 */
class ConverterEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Converter entity  revision.
   *
   * @param int $converter_entity_revision
   *   The Converter entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($converter_entity_revision) {
    $converter_entity = $this->entityManager()->getStorage('converter_entity')->loadRevision($converter_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('converter_entity');

    return $view_builder->view($converter_entity);
  }

  /**
   * Page title callback for a Converter entity  revision.
   *
   * @param int $converter_entity_revision
   *   The Converter entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($converter_entity_revision) {
    $converter_entity = $this->entityManager()->getStorage('converter_entity')->loadRevision($converter_entity_revision);
    return $this->t('Revision of %title from %date', array('%title' => $converter_entity->label(), '%date' => format_date($converter_entity->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a Converter entity .
   *
   * @param \Drupal\currency_converter\Entity\ConverterEntityInterface $converter_entity
   *   A Converter entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(ConverterEntityInterface $converter_entity) {
    $account = $this->currentUser();
    $langcode = $converter_entity->language()->getId();
    $langname = $converter_entity->language()->getName();
    $languages = $converter_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $converter_entity_storage = $this->entityManager()->getStorage('converter_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $converter_entity->label()]) : $this->t('Revisions for %title', ['%title' => $converter_entity->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all converter entity revisions") || $account->hasPermission('administer converter entity entities')));
    $delete_permission = (($account->hasPermission("delete all converter entity revisions") || $account->hasPermission('administer converter entity entities')));

    $rows = array();

    $vids = $converter_entity_storage->revisionIds($converter_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\currency_converter\ConverterEntityInterface $revision */
      $revision = $converter_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $converter_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.converter_entity.revision', ['converter_entity' => $converter_entity->id(), 'converter_entity_revision' => $vid]));
        }
        else {
          $link = $converter_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->revision_log_message->value, '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.converter_entity.translation_revert', ['converter_entity' => $converter_entity->id(), 'converter_entity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.converter_entity.revision_revert', ['converter_entity' => $converter_entity->id(), 'converter_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.converter_entity.revision_delete', ['converter_entity' => $converter_entity->id(), 'converter_entity_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['converter_entity_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
