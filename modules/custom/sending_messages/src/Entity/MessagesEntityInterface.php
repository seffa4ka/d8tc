<?php

namespace Drupal\sending_messages\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Messages entity entities.
 *
 * @ingroup sending_messages
 */
interface MessagesEntityInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Messages entity name.
   *
   * @return string
   *   Name of the Messages entity.
   */
  public function getName();

  /**
   * Sets the Messages entity name.
   *
   * @param string $name
   *   The Messages entity name.
   *
   * @return \Drupal\sending_messages\Entity\MessagesEntityInterface
   *   The called Messages entity entity.
   */
  public function setName($name);

  /**
   * Gets the Messages entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Messages entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Messages entity creation timestamp.
   *
   * @param int $timestamp
   *   The Messages entity creation timestamp.
   *
   * @return \Drupal\sending_messages\Entity\MessagesEntityInterface
   *   The called Messages entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Messages entity published status indicator.
   *
   * Unpublished Messages entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Messages entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Messages entity.
   *
   * @param bool $published
   *   TRUE to set this Messages entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\sending_messages\Entity\MessagesEntityInterface
   *   The called Messages entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Messages entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Messages entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\sending_messages\Entity\MessagesEntityInterface
   *   The called Messages entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Messages entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Messages entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\sending_messages\Entity\MessagesEntityInterface
   *   The called Messages entity entity.
   */
  public function setRevisionUserId($uid);

}
