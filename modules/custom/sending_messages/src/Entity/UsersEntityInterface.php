<?php

namespace Drupal\sending_messages\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Users entity entities.
 *
 * @ingroup sending_messages
 */
interface UsersEntityInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Users entity name.
   *
   * @return string
   *   Name of the Users entity.
   */
  public function getName();

  /**
   * Sets the Users entity name.
   *
   * @param string $name
   *   The Users entity name.
   *
   * @return \Drupal\sending_messages\Entity\UsersEntityInterface
   *   The called Users entity entity.
   */
  public function setName($name);

  /**
   * Gets the Users entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Users entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Users entity creation timestamp.
   *
   * @param int $timestamp
   *   The Users entity creation timestamp.
   *
   * @return \Drupal\sending_messages\Entity\UsersEntityInterface
   *   The called Users entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Users entity published status indicator.
   *
   * Unpublished Users entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Users entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Users entity.
   *
   * @param bool $published
   *   TRUE to set this Users entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\sending_messages\Entity\UsersEntityInterface
   *   The called Users entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Users entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Users entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\sending_messages\Entity\UsersEntityInterface
   *   The called Users entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Users entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Users entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\sending_messages\Entity\UsersEntityInterface
   *   The called Users entity entity.
   */
  public function setRevisionUserId($uid);

}
