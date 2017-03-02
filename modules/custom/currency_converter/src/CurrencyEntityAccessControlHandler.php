<?php

namespace Drupal\currency_converter;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Currency entity entity.
 *
 * @see \Drupal\currency_converter\Entity\CurrencyEntity.
 */
class CurrencyEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\currency_converter\Entity\CurrencyEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished currency entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published currency entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit currency entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete currency entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add currency entity entities');
  }

}
