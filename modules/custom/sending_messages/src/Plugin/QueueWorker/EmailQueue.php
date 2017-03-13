<?php

/**
 * @file
 * Contains \Drupal\sending_messages\Plugin\QueueWorker\EmailQueue.
 */
namespace Drupal\sending_messages\Plugin\QueueWorker;
use Drupal\Core\Queue\QueueWorkerBase;
/**
 * Processes Tasks for Learning.
 *
 * @QueueWorker(
 *   id = "email_queue",
 *   title = @Translation("Read NOW!"),
 *   cron = {"time" = 60}
 * )
 */
class EmailQueue extends QueueWorkerBase {
  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $mailManager = \Drupal::service('plugin.manager.mail');
    $user = \Drupal::entityTypeManager()->getStorage('users_entity')->load($data['uid']);
    $message = \Drupal::entityTypeManager()->getStorage('messages_entity')->load($user->field_message_id->value);

    $params['message'] = $message->field_body->value;
    $mailManager->mail('sending_messages', 'email_queue', $user->field_email->value, 'en', $params , $send = TRUE);

    $user->field_status->value = 1;
    $user->save();
  }
}
