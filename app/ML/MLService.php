<?php

namespace App\ML;

class MLService
{
    private $modelPath; // ← deklarasi DI SINI

    public function __construct()
    {
        $path = base_path("app/ML/model_diabetes.pkl");

        if (!file_exists($path)) {
            throw new \Exception("Model ML tidak ditemukan di: " . $path);
        }

        // simpan lokasi model
        $this->modelPath = $path;
    }

    public function predict(array $input)
    {
        $jsonInput = json_encode($input);

        // Jalankan Python untuk prediksi
        // NOTE: predict.py harus ada di folder yang sama
        $command = "python " . base_path("app/ML/predict.py") 
                 . " " . escapeshellarg($jsonInput);

        $output = shell_exec($command);

        return json_decode($output, true);
    }
    
}
