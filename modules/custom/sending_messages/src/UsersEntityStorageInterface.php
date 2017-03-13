<?php

namespace Drupal\sending_messages;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\sending_messages\Entity\UsersEntityInterface;

/**
 * Defines the storage handler class for Users entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Users entity entities.
 *
 * @ingroup sending_messages
 */
interface UsersEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Users entity revision IDs for a specific Users entity.
   *
   * @param \Drupal\sending_messages\Entity\UsersEntityInterface $entity
   *   The Users entity entity.
   *
   * @return int[]
   *   Users entity revision IDs (in ascending order).
   */
  public function revisionIds(UsersEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Users entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Users entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\sending_messages\Entity\UsersEntityInterface $entity
   *   The Users entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(UsersEntityInterface $entity);

  /**
   * Unsets the language for all Users entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
