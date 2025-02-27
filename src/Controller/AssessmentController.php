<?php 

namespace Drupal\assessment\Controller;

use Drupal\Core\Controller\ControllerBase;

class AssessmentController extends ControllerBase {

    public function showResult() {
        $answers = $_SESSION['assessment_answers'] ?? [];
        $output = '<h2>Assessment Results</h2>';
        foreach ($answers as $key => $value) {
            if ($key != 'submit' && $key != 'form_build_id' && $key != 'form_id') {
                $output .= "<p><strong>$key:</strong> $value</p>";
            }
        }
        return ['#markup' => $output];
    }
}
