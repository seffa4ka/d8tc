<?php

/**
 * @file
 * Contains \Drupal\note\Form\NoteSettingsForm.
 */

namespace Drupal\note\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Announcement form.
 */
class NoteSettingsForm extends FormBase {

  /**
   * Shapes name.
   *
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'note_settings';
  }

  /**
   * Creating form.
   *
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['date'] = array(
      '#type' => 'date',
      '#title' => $this->t('Date'),
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
   * Submitting forms.
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $inputDate = strtotime($form_state->getValue('date'));
    
    $ids = \Drupal::entityQuery('node')
      ->execute();
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($ids);

    if ($inputDate) {
      foreach ($ids as $id) {
        //drupal_set_message($nodes[$id]->created->value);
        if ($nodes[$id]->created->value > $inputDate){
          //actual
        }
        else {
          //expired
        }
      }
    }
    else {
      //NA
    }
  }

}


