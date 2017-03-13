<?php


namespace Drupal\sending_messages\Form;

/**
 * @file
 * Contains \Drupal\sending_messages\Form\SendingMessagesSettingsForm.
 */

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Announcement form.
 */
class SendingMessagesSettingsForm extends FormBase {

  /**
   * Shapes name.
   *
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'sending_messages_settings';
  }

  /**
   * Creating form.
   *
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['textarea'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
    );

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Send All'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * Submitting forms.
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $value = array(
      'field_body' => $form_state->getValue('textarea'),
    );
    $entity = entity_create('messages_entity', $value);
    $entity->save();
    $message_id = $entity->id();

    $ids = \Drupal::entityQuery('user')
      ->execute();
    $users = \Drupal::entityTypeManager()->getStorage('user')->loadMultiple($ids);
    foreach ($ids as $id){
      if ($id != 0 && $id != 1){

        $valueUser = array(
          'field_email' => $users[$id]->mail->value,
          'field_message_id' => $message_id,
        );
        $entityUser = entity_create('users_entity', $valueUser);
        $entityUser->save();

        $data['uid'] = $entityUser->id();
        $queue = \Drupal::queue('email_queue');
        $queue->createQueue();
        $queue->createItem($data);
      }
    }
  }
  
}
