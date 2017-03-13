<?php

namespace Drupal\sending_messages;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Messages entity entity.
 *
 * @see \Drupal\sending_messages\Entity\MessagesEntity.
 */
class MessagesEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\sending_messages\Entity\MessagesEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished messages entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published messages entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit messages entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete messages entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add messages entity entities');
  }

}
