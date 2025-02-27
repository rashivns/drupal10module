<?php

namespace Drupal\assessment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoginForm extends FormBase {

  public function getFormId() {
    return 'assessment_login_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => 'Username',
      '#required' => TRUE,
    ];
    $form['password'] = [
      '#type' => 'password',
      '#title' => 'Password',
      '#required' => TRUE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Login',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $username = $form_state->getValue('name');
    $password = $form_state->getValue('password');

    $user = user_load_by_name($username);
    if ($user && \Drupal::service('password')->check($password, $user->getPassword())) {
      user_login_finalize($user);
      \Drupal::messenger()->addMessage('Login successful.');
      $form_state->setRedirect('assessment.assessment_form');
    } else {
      \Drupal::messenger()->addError('Invalid username or password.');
    }
  }
}