<?php

namespace Drupal\currency_converter\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\currency_converter\Entity\CurrencyEntityInterface;

/**
 * Class CurrencyEntityController.
 *
 *  Returns responses for Currency entity routes.
 *
 * @package Drupal\currency_converter\Controller
 */
class CurrencyEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Currency entity  revision.
   *
   * @param int $currency_entity_revision
   *   The Currency entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($currency_entity_revision) {
    $currency_entity = $this->entityManager()->getStorage('currency_entity')->loadRevision($currency_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('currency_entity');

    return $view_builder->view($currency_entity);
  }

  /**
   * Page title callback for a Currency entity  revision.
   *
   * @param int $currency_entity_revision
   *   The Currency entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($currency_entity_revision) {
    $currency_entity = $this->entityManager()->getStorage('currency_entity')->loadRevision($currency_entity_revision);
    return $this->t('Revision of %title from %date', array('%title' => $currency_entity->label(), '%date' => format_date($currency_entity->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a Currency entity .
   *
   * @param \Drupal\currency_converter\Entity\CurrencyEntityInterface $currency_entity
   *   A Currency entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(CurrencyEntityInterface $currency_entity) {
    $account = $this->currentUser();
    $langcode = $currency_entity->language()->getId();
    $langname = $currency_entity->language()->getName();
    $languages = $currency_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $currency_entity_storage = $this->entityManager()->getStorage('currency_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $currency_entity->label()]) : $this->t('Revisions for %title', ['%title' => $currency_entity->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all currency entity revisions") || $account->hasPermission('administer currency entity entities')));
    $delete_permission = (($account->hasPermission("delete all currency entity revisions") || $account->hasPermission('administer currency entity entities')));

    $rows = array();

    $vids = $currency_entity_storage->revisionIds($currency_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\currency_converter\CurrencyEntityInterface $revision */
      $revision = $currency_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $currency_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.currency_entity.revision', ['currency_entity' => $currency_entity->id(), 'currency_entity_revision' => $vid]));
        }
        else {
          $link = $currency_entity->link($date);
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
              Url::fromRoute('entity.currency_entity.translation_revert', ['currency_entity' => $currency_entity->id(), 'currency_entity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.currency_entity.revision_revert', ['currency_entity' => $currency_entity->id(), 'currency_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.currency_entity.revision_delete', ['currency_entity' => $currency_entity->id(), 'currency_entity_revision' => $vid]),
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

    $build['currency_entity_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
