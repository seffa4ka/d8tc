<?php

namespace Drupal\note;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Drupal\node\Entity\Node;

/**
 * Description of NoteStatusUpdate.
 *
 * @author seffka
 */
class NoteStatusUpdate {

  /**
   * Set status NA.
   */
  public static function updateNoteStatusNa($nids, &$context) {
    $message = 'Updating Note status...';
    $results = array();
    foreach ($nids as $nid) {
      $node = Node::load($nid);
      $node->field_note_status->value = 'NA';
      $results[] = $node->save();
    }
    $context['message'] = $message;
    $context['results'] = $results;
  }

  /**
   * Set status Actuadl.
   */
  public static function updateNoteStatusActual($nids, &$context) {
    $message = 'Updating Note status...';
    $results = array();
    foreach ($nids as $nid) {
      $node = Node::load($nid);
      $node->field_note_status->value = 'Actual';
      $results[] = $node->save();
    }
    $context['message'] = $message;
    $context['results'] = $results;
  }

  /**
   * Set status Expired.
   */
  public static function updateNoteStatusExpired($nids, &$context) {
    $message = 'Updating Note status...';
    $results = array();
    foreach ($nids as $nid) {
      $node = Node::load($nid);
      $node->field_note_status->value = 'Expired';
      $results[] = $node->save();
    }
    $context['message'] = $message;
    $context['results'] = $results;
  }

  /**
   * Callback function.
   */
  public function finishedCallback($success, $results, $operations) {

    if ($success) {
      $message = t('Status updated.');
    }
    else {
      $message = t('Finished with an error.');
    }

    drupal_set_message($message);
  }

}
