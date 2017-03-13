<?php

namespace Drupal\sending_messages;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface MessagesEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Messages entity revision IDs for a specific Messages entity.
   *
   * @param \Drupal\sending_messages\Entity\MessagesEntityInterface $entity
   *   The Messages entity entity.
   *
   * @return int[]
   *   Messages entity revision IDs (in ascending order).
   */
  public function revisionIds(MessagesEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Messages entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Messages entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\sending_messages\Entity\MessagesEntityInterface $entity
   *   The Messages entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(MessagesEntityInterface $entity);

  /**
   * Unsets the language for all Messages entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
