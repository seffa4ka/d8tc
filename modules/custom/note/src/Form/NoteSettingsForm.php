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

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Update'),
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
    $naids = array();
    $aids = array();
    $eids = array();

    $ids = \Drupal::entityQuery('node')
      ->condition('type', 'note')
      ->execute();
    $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadMultiple($ids);

    if ($inputDate) {
      foreach ($ids as $id) {
        if ($nodes[$id]->created->value > $inputDate){
          //actual
          array_push($aids, $id);
        }
        else {
          //expired
          array_push($eids, $id);
        }
      }
    }
    else {
      //NA
      $naids = $ids;
    }
    
    //batch
    $batch = array(
      'title' => t('Do...'),
      'operations' => array(
        array(
          '\Drupal\note\NoteStatusUpdate::updateNoteStatusActual',
          array($aids)
        ),
        array(
          '\Drupal\note\NoteStatusUpdate::updateNoteStatusExpired',
          array($eids)
        ),
        array(
          '\Drupal\note\NoteStatusUpdate::updateNoteStatusNA',
          array($naids)
        ),
      ),
      'finished' => '\Drupal\note\NoteStatusUpdate::finishedCallback',
    );
    
    batch_set($batch);
  }

}


