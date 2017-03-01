<?php

namespace Drupal\currency_converter\Entity;

use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Url;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Converter entity entities.
 *
 * @ingroup currency_converter
 */
interface ConverterEntityInterface extends RevisionableInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Converter entity name.
   *
   * @return string
   *   Name of the Converter entity.
   */
  public function getName();

  /**
   * Sets the Converter entity name.
   *
   * @param string $name
   *   The Converter entity name.
   *
   * @return \Drupal\currency_converter\Entity\ConverterEntityInterface
   *   The called Converter entity entity.
   */
  public function setName($name);

  /**
   * Gets the Converter entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Converter entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Converter entity creation timestamp.
   *
   * @param int $timestamp
   *   The Converter entity creation timestamp.
   *
   * @return \Drupal\currency_converter\Entity\ConverterEntityInterface
   *   The called Converter entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Converter entity published status indicator.
   *
   * Unpublished Converter entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Converter entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Converter entity.
   *
   * @param bool $published
   *   TRUE to set this Converter entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\currency_converter\Entity\ConverterEntityInterface
   *   The called Converter entity entity.
   */
  public function setPublished($published);

  /**
   * Gets the Converter entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Converter entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\currency_converter\Entity\ConverterEntityInterface
   *   The called Converter entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Converter entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Converter entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\currency_converter\Entity\ConverterEntityInterface
   *   The called Converter entity entity.
   */
  public function setRevisionUserId($uid);

}
