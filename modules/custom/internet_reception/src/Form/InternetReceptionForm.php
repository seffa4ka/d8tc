<?php

/**
 * @file
 * Contains \Drupal\helloworld\Form\InternetReceptionForm.
 */

namespace Drupal\internet_reception\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Announcement form.
 */
class InternetReceptionForm extends FormBase {

  /**
   * Shapes name.
   *
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'internet_reception';
  }

  /**
   * Creating form.
   *
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your name'),
      '#required' => TRUE,
    );
    
    $form['email'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Email'),
      '#required' => TRUE,
    );

    $form['age'] = array(
      '#type' => 'number',
      '#title' => $this->t('Age'),
      '#required' => TRUE,
    );

    $form['subject'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Subject'),
      '#required' => TRUE,
    );

    $form['message'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
    );

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    );
    return $form;
  }

  /**
   * Checking data transmitted in the form.
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    if (strlen($form_state->getValue('name')) < 5) {
      $form_state->setErrorByName('name', $this->t('Name is too short.'));
    }

    if (!valid_email_address($form_state->getValue('email'))) {
      $form_state->setErrorByName('email', $this->t('Incorrect email.'));
    }

    if (mb_strlen($form_state->getValue('subject')) > 63) {
      $form_state->setErrorByName('subject', $this->t('Long subject.'));
    }

    if (mb_strlen($form_state->getValue('message')) > 255) {
      $form_state->setErrorByName('message', $this->t('Long message.'));
    }
  }

  /**
   * Submitting forms.
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
$newMail = \Drupal::service('plugin.manager.mail');
    $params['name'] = $form_state->getValue('name');
    $userEmail = $form_state->getValue('email');
    $newMail->mail('internet_reception', 'registerMail', $userEmail, 'en', $params, $reply = NULL, $send = TRUE);
    
    drupal_set_message($this->t('Thank you @name!', array(
      '@name' => $form_state->getValue('name')
    )));

  }

}
