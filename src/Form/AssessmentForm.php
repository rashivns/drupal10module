<?php

namespace Drupal\assessment\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class AssessmentForm extends FormBase {

    public function getFormId() {
        return 'assessment_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state) {
        $form['#attached']['library'][] = 'assessment/assessment_styles';
        $form['question_39'] = [
            '#type' => 'radios',
            '#title' => t('Are there official AI skill certification programs endorsed by the government to promote awareness in AI?'),
            '#options' => [
                'no_official' => t('No official AI skill certification programs endorsed by the government on AI'),
                'early_stages' => t('Early stages of initiating an official AI skill certification program by the government'),
                'limited_offering' => t('Limited offering of AI skill certification programs by the government have been implemented across limited sectors to bring awareness about AI'),
                'comprehensive' => t('Comprehensive AI skill certification programs by the government have been implemented across multiple sectors'),
                'official_all_sectors' => t('Official AI skill certification programs have been implemented across all sectors and monitored for regular updates based on emerging trends'),
            ],
            '#required' => TRUE,
        ];

        $form['actions'] = [
            '#type' => 'actions',
        ];

        $form['actions']['submit'] = [
            '#type' => 'submit',
            '#value' => t('Submit'),
        ];

        $form['actions']['reset'] = [
            '#type' => 'button',
            '#value' => t('Reset'),
            '#attributes' => [
                'onclick' => 'this.form.reset(); return false;', // JavaScript reset
            ],
        ];

        return $form;
    }

    public function submitForm(array &$form, FormStateInterface $form_state) {
        $selected_option = $form_state->getValue('question_39');
        \Drupal::messenger()->addMessage(t('You selected: @answer', ['@answer' => $form['question_39']['#options'][$selected_option]]));
    }
}
