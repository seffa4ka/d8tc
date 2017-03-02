<?php

namespace Drupal\currency_converter;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface CurrencyEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Currency entity revision IDs for a specific Currency entity.
   *
   * @param \Drupal\currency_converter\Entity\CurrencyEntityInterface $entity
   *   The Currency entity entity.
   *
   * @return int[]
   *   Currency entity revision IDs (in ascending order).
   */
  public function revisionIds(CurrencyEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Currency entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Currency entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\currency_converter\Entity\CurrencyEntityInterface $entity
   *   The Currency entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(CurrencyEntityInterface $entity);

  /**
   * Unsets the language for all Currency entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
