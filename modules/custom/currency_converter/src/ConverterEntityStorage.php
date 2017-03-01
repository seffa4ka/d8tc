<?php

namespace Drupal\currency_converter;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\currency_converter\Entity\ConverterEntityInterface;

/**
 * Defines the storage handler class for Converter entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Converter entity entities.
 *
 * @ingroup currency_converter
 */
class ConverterEntityStorage extends SqlContentEntityStorage implements ConverterEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(ConverterEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {converter_entity_revision} WHERE id=:id ORDER BY vid',
      array(':id' => $entity->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {converter_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      array(':uid' => $account->id())
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(ConverterEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {converter_entity_field_revision} WHERE id = :id AND default_langcode = 1', array(':id' => $entity->id()))
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('converter_entity_revision')
      ->fields(array('langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED))
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
