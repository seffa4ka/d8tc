<?php

namespace Drupal\sending_messages\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\sending_messages\Entity\MessagesEntityInterface;

/**
 * Class MessagesEntityController.
 *
 *  Returns responses for Messages entity routes.
 *
 * @package Drupal\sending_messages\Controller
 */
class MessagesEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Messages entity  revision.
   *
   * @param int $messages_entity_revision
   *   The Messages entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($messages_entity_revision) {
    $messages_entity = $this->entityManager()->getStorage('messages_entity')->loadRevision($messages_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('messages_entity');

    return $view_builder->view($messages_entity);
  }

  /**
   * Page title callback for a Messages entity  revision.
   *
   * @param int $messages_entity_revision
   *   The Messages entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($messages_entity_revision) {
    $messages_entity = $this->entityManager()->getStorage('messages_entity')->loadRevision($messages_entity_revision);
    return $this->t('Revision of %title from %date', array('%title' => $messages_entity->label(), '%date' => format_date($messages_entity->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a Messages entity .
   *
   * @param \Drupal\sending_messages\Entity\MessagesEntityInterface $messages_entity
   *   A Messages entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(MessagesEntityInterface $messages_entity) {
    $account = $this->currentUser();
    $langcode = $messages_entity->language()->getId();
    $langname = $messages_entity->language()->getName();
    $languages = $messages_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $messages_entity_storage = $this->entityManager()->getStorage('messages_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $messages_entity->label()]) : $this->t('Revisions for %title', ['%title' => $messages_entity->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all messages entity revisions") || $account->hasPermission('administer messages entity entities')));
    $delete_permission = (($account->hasPermission("delete all messages entity revisions") || $account->hasPermission('administer messages entity entities')));

    $rows = array();

    $vids = $messages_entity_storage->revisionIds($messages_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\sending_messages\MessagesEntityInterface $revision */
      $revision = $messages_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $messages_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.messages_entity.revision', ['messages_entity' => $messages_entity->id(), 'messages_entity_revision' => $vid]));
        }
        else {
          $link = $messages_entity->link($date);
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
              Url::fromRoute('entity.messages_entity.translation_revert', ['messages_entity' => $messages_entity->id(), 'messages_entity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.messages_entity.revision_revert', ['messages_entity' => $messages_entity->id(), 'messages_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.messages_entity.revision_delete', ['messages_entity' => $messages_entity->id(), 'messages_entity_revision' => $vid]),
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

    $build['messages_entity_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
