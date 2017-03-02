<?php

namespace Drupal\currency_converter\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Currency entity entities.
 *
 * @ingroup currency_converter
 */
interface CurrencyEntityInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Currency entity name.
   *
   * @return string
   *   Name of the Currency entity.
   */
  public function getName();

  /**
   * Sets the Currency entity name.
   *
   * @param string $name
   *   The Currency entity name.
   *
   * @return \Drupal\currency_converter\Entity\CurrencyEntityInterface
   *   The called Currency entity entity.
   */
  public function setName($name);

  /**
   * Gets the Currency entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Currency entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Currency entity creation timestamp.
   *
   * @param int $timestamp
   *   The Currency entity creation timestamp.
   *
   * @return \Drupal\currency_converter\Entity\CurrencyEntityInterface
   *   The called Currency entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Currency entity published status indicator.
   *
   * Unpublished Currency entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Currency entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Currency entity.
   *
   * @param bool $published
   *   TRUE to set this Currency entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\currency_converter\Entity\CurrencyEntityInterface
   *   The called Currency entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Currency entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Currency entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\currency_converter\Entity\CurrencyEntityInterface
   *   The called Currency entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Currency entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Currency entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\currency_converter\Entity\CurrencyEntityInterface
   *   The called Currency entity entity.
   */
  public function setRevisionUserId($uid);

}
