<?php

namespace Drupal\currency_converter;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\currency_converter\Entity\CurrencyEntityInterface;

/**
 * Defines the storage handler class for Currency entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Currency entity entities.
 *
 * @ingroup currency_converter
 */
class CurrencyEntityStorage extends SqlContentEntityStorage implements CurrencyEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(CurrencyEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {currency_entity_revision} WHERE id=:id ORDER BY vid',
      array(':id' => $entity->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {currency_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      array(':uid' => $account->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(CurrencyEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {currency_entity_field_revision} WHERE id = :id AND default_langcode = 1', array(':id' => $entity->id()))
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('currency_entity_revision')
      ->fields(array('langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED))
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
