<?php
/**
 * @file
 * Contains \Drupal\etazhmodule\Form\ObjectsForm.
 */
namespace Drupal\etazhmodule\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ObjectsForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'etazhmodule_objects_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['object_id'] = array(
      '#type' => 'number',
      '#size' => 10,
      '#maxlength' => 255,
      '#title' => t('ID объекта: # '),
      '#default_value' => $_SESSION['etazhblock-objectid'],
    );

    $form['expertise'] = array(
      '#type' => 'checkbox',
      '#title' => t('с экспертизой'),
      '#description' => '',
      '#default_value' => $_SESSION['etazhblock-expertise'],
    );

    $host = \Drupal::request()->getHost();

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Ok'),
      '#button_type' => 'primary',
    );

    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $_SESSION['etazhblock-objectid'] = $form_state->getValue('object_id');
    $_SESSION['etazhblock-expertise'] = $form_state->getValue('expertise');
  }
}
