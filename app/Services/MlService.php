<?php

namespace App\Services;

class MLService
{
    public function predict(array $input)
    {
        $modelPath = storage_path('app/ml/model_diabetes.pkl');

        // Panggil Python
        $command = 'python ' . base_path('python/predict.py') . 
                   ' "' . base64_encode(json_encode($input)) . '" "' . $modelPath . '"';

        $result = shell_exec($command);

        return json_decode($result, true);
    }
}
