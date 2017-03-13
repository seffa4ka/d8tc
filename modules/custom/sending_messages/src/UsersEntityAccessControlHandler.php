<?php

namespace Drupal\sending_messages;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Users entity entity.
 *
 * @see \Drupal\sending_messages\Entity\UsersEntity.
 */
class UsersEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\sending_messages\Entity\UsersEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished users entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published users entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit users entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete users entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add users entity entities');
  }

}
