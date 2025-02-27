<?php   


namespace Drupal\assessment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

class RegistrationForm extends FormBase {
    
    public function getFormId() {
        return 'assessment_registration_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => t('Username'),
            '#required' => TRUE,
        ];
        $form['mail'] = [
            '#type' => 'email',
            '#title' => t('Email'),
            '#required' => TRUE,
        ];
        $form['pass'] = [
            '#type' => 'password',
            '#title' => t('Password'),
            '#required' => TRUE,
        ];
        $form['submit'] = [
            '#type' => 'submit',
            '#value' => t('Register'),
        ];

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $username = $form_state->getValue('name');

        // Check if the username already exists.
        $existing_user = \Drupal::entityQuery('user')
        ->condition('name', $username)
        ->accessCheck(FALSE) // Explicitly disabling access check
        ->execute();


        if (!empty($user_exists)) {
            \Drupal::messenger()->addError(t('The username "%name" is already taken. Please choose another.', ['%name' => $username]));
            return;
        }

        // Create a new user.
        $user = User::create([
            'name' => $username,
            'mail' => $form_state->getValue('mail'),
            'pass' => $form_state->getValue('pass'),
            'status' => 1,
        ]);

        $user->save();
        \Drupal::messenger()->addMessage(t('User %name registered successfully!', ['%name' => $username]));
    }
}