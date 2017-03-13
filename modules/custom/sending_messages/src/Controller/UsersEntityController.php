<?php

namespace Drupal\sending_messages\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\sending_messages\Entity\UsersEntityInterface;

/**
 * Class UsersEntityController.
 *
 *  Returns responses for Users entity routes.
 *
 * @package Drupal\sending_messages\Controller
 */
class UsersEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Users entity  revision.
   *
   * @param int $users_entity_revision
   *   The Users entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($users_entity_revision) {
    $users_entity = $this->entityManager()->getStorage('users_entity')->loadRevision($users_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('users_entity');

    return $view_builder->view($users_entity);
  }

  /**
   * Page title callback for a Users entity  revision.
   *
   * @param int $users_entity_revision
   *   The Users entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($users_entity_revision) {
    $users_entity = $this->entityManager()->getStorage('users_entity')->loadRevision($users_entity_revision);
    return $this->t('Revision of %title from %date', array('%title' => $users_entity->label(), '%date' => format_date($users_entity->getRevisionCreationTime())));
  }

  /**
   * Generates an overview table of older revisions of a Users entity .
   *
   * @param \Drupal\sending_messages\Entity\UsersEntityInterface $users_entity
   *   A Users entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(UsersEntityInterface $users_entity) {
    $account = $this->currentUser();
    $langcode = $users_entity->language()->getId();
    $langname = $users_entity->language()->getName();
    $languages = $users_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $users_entity_storage = $this->entityManager()->getStorage('users_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $users_entity->label()]) : $this->t('Revisions for %title', ['%title' => $users_entity->label()]);
    $header = array($this->t('Revision'), $this->t('Operations'));

    $revert_permission = (($account->hasPermission("revert all users entity revisions") || $account->hasPermission('administer users entity entities')));
    $delete_permission = (($account->hasPermission("delete all users entity revisions") || $account->hasPermission('administer users entity entities')));

    $rows = array();

    $vids = $users_entity_storage->revisionIds($users_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\sending_messages\UsersEntityInterface $revision */
      $revision = $users_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->revision_timestamp->value, 'short');
        if ($vid != $users_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.users_entity.revision', ['users_entity' => $users_entity->id(), 'users_entity_revision' => $vid]));
        }
        else {
          $link = $users_entity->link($date);
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
              Url::fromRoute('entity.users_entity.translation_revert', ['users_entity' => $users_entity->id(), 'users_entity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.users_entity.revision_revert', ['users_entity' => $users_entity->id(), 'users_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.users_entity.revision_delete', ['users_entity' => $users_entity->id(), 'users_entity_revision' => $vid]),
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

    $build['users_entity_revisions_table'] = array(
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    );

    return $build;
  }

}
