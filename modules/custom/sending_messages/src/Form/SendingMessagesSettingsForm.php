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

    $count_value = \Drupal::config('sending_messages.settings')->get('count_value');

    $form['textarea'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
    );

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Send All'),
      '#button_type' => 'primary',
    );

    $form['count_value'] = array(
      '#title' => $this->t('Sent by'),
      '#type' => 'radios',
      '#default_value' => $count_value ? $count_value : 2,
      '#options' => array(
        1 => $this->t('1 message'),
        2 => $this->t('2 messages'),
        5 => $this->t('5 messages'),
      ),
    );

    $form['count'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Update'),
      '#submit' => array('::newSubmissionCount'),
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
    foreach ($ids as $id) {
      if ($id != 0 && $id != 1) {

        $valueUser = array(
          'field_email' => $users[$id]->mail->value,
          'field_message_id' => $message_id,
        );
        $entityUser = entity_create('users_entity', $valueUser);
        $entityUser->save();
      }
    }
  }

  /**
   * Submitting forms.
   *
   * @{@inheritdoc}
   */
  public function newSubmissionCount(array &$form, FormStateInterface $form_state) {
    drupal_set_message('Settings updated');
    $config = \Drupal::service('config.factory')->getEditable('sending_messages.settings');
    $config->set('count_value', $form_state->getValue('count_value'))
      ->save();
  }

}
