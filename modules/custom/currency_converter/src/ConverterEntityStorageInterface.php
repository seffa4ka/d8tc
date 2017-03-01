<?php

namespace Drupal\currency_converter;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface ConverterEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Converter entity revision IDs for a specific Converter entity.
   *
   * @param \Drupal\currency_converter\Entity\ConverterEntityInterface $entity
   *   The Converter entity entity.
   *
   * @return int[]
   *   Converter entity revision IDs (in ascending order).
   */
  public function revisionIds(ConverterEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Converter entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Converter entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\currency_converter\Entity\ConverterEntityInterface $entity
   *   The Converter entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(ConverterEntityInterface $entity);

  /**
   * Unsets the language for all Converter entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
