<?php

namespace Drupal\sending_messages;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\sending_messages\Entity\MessagesEntityInterface;

/**
 * Defines the storage handler class for Messages entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Messages entity entities.
 *
 * @ingroup sending_messages
 */
class MessagesEntityStorage extends SqlContentEntityStorage implements MessagesEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(MessagesEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {messages_entity_revision} WHERE id=:id ORDER BY vid',
      array(':id' => $entity->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {messages_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      array(':uid' => $account->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(MessagesEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {messages_entity_field_revision} WHERE id = :id AND default_langcode = 1', array(':id' => $entity->id()))
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('messages_entity_revision')
      ->fields(array('langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED))
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
