<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MLService
{
    /**
     * Base URL untuk Python ML API
     */
    protected $apiUrl;

    /**
     * Timeout untuk request (detik)
     */
    protected $timeout;

    public function __construct()
    {
        // Ambil dari config atau .env
        $this->apiUrl = config('services.ml_api.url', 'http://localhost:5000');
        $this->timeout = config('services.ml_api.timeout', 30);
    }

    /**
     * Health check API
     */
    public function healthCheck()
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get("{$this->apiUrl}/health");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'error' => 'API not responding'
            ];
        } catch (\Exception $e) {
            Log::error('ML API Health Check Failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Prediksi diabetes untuk single patient
     * 
     * @param array $patientData Data pasien
     * @return array
     */
    public function predict(array $patientData)
    {
        try {
            // Validasi data
            $validatedData = $this->validatePatientData($patientData);

            // Kirim request ke Python API
            $response = Http::timeout($this->timeout)
                ->post("{$this->apiUrl}/predict", $validatedData);

            if ($response->successful()) {
                $result = $response->json();
                
                return [
                    'success' => true,
                    'data' => $result['data']
                ];
            }

            return [
                'success' => false,
                'error' => 'Prediction failed',
                'details' => $response->json()
            ];

        } catch (\Exception $e) {
            Log::error('ML Prediction Failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Prediksi batch (multiple patients)
     * 
     * @param array $patients Array of patient data
     * @return array
     */
    public function predictBatch(array $patients)
    {
        try {
            $response = Http::timeout($this->timeout)
                ->post("{$this->apiUrl}/predict/batch", [
                    'patients' => $patients
                ]);

            if ($response->successful()) {
                $result = $response->json();
                
                return [
                    'success' => true,
                    'data' => $result['data'],
                    'total' => $result['total']
                ];
            }

            return [
                'success' => false,
                'error' => 'Batch prediction failed'
            ];

        } catch (\Exception $e) {
            Log::error('ML Batch Prediction Failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get detailed explanation for prediction
     * 
     * @param array $patientData
     * @return array
     */
    public function explain(array $patientData)
    {
        try {
            $validatedData = $this->validatePatientData($patientData);

            $response = Http::timeout($this->timeout)
                ->post("{$this->apiUrl}/explain", $validatedData);

            if ($response->successful()) {
                $result = $response->json();
                
                return [
                    'success' => true,
                    'data' => $result['data']
                ];
            }

            return [
                'success' => false,
                'error' => 'Explanation failed'
            ];

        } catch (\Exception $e) {
            Log::error('ML Explanation Failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get model information
     * 
     * @return array
     */
    public function getModelInfo()
    {
        try {
            $response = Http::timeout($this->timeout)
                ->get("{$this->apiUrl}/model/info");

            if ($response->successful()) {
                $result = $response->json();
                
                return [
                    'success' => true,
                    'data' => $result['data']
                ];
            }

            return [
                'success' => false,
                'error' => 'Failed to get model info'
            ];

        } catch (\Exception $e) {
            Log::error('ML Model Info Failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Validasi dan format data pasien
     * 
     * @param array $data
     * @return array
     */
    protected function validatePatientData(array $data)
    {
        // Hitung IMT jika belum ada
        if (!isset($data['imt']) && isset($data['berat_badan']) && isset($data['tinggi_badan'])) {
            $tinggiMeter = $data['tinggi_badan'] / 100;
            $data['imt'] = round($data['berat_badan'] / ($tinggiMeter * $tinggiMeter), 2);
        }

        // Pastikan semua field required ada
        $requiredFields = [
            'usia', 'jenis_kelamin', 'berat_badan', 'tinggi_badan', 'imt',
            'keluarga_diabetes', 'merokok', 'minum_alkohol', 
            'riwayat_hipertensi', 'riwayat_obesitas',
            'olahraga', 'pola_makan',
            'sering_buang_air_kecil_malam', 'sering_lapar', 'pandangan_kabur'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                throw new \Exception("Field '{$field}' is required");
            }
        }

        // Convert boolean to integer jika perlu
        $binaryFields = [
            'keluarga_diabetes', 'merokok', 'minum_alkohol',
            'riwayat_hipertensi', 'riwayat_obesitas',
            'sering_buang_air_kecil_malam', 'sering_lapar', 'pandangan_kabur'
        ];

        foreach ($binaryFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = (int) $data[$field];
            }
        }

        return $data;
    }

    /**
     * Format response untuk view
     * 
     * @param array $prediction
     * @return array
     */
    public function formatForView(array $prediction)
    {
        if (!isset($prediction['data'])) {
            return $prediction;
        }

        $data = $prediction['data'];

        return [
            'prediction' => $data['prediction_label'] ?? 'Unknown',
            'probability' => [
                'diabetes' => round(($data['probability']['diabetes'] ?? 0) * 100, 2),
                'no_diabetes' => round(($data['probability']['no_diabetes'] ?? 0) * 100, 2),
            ],
            'risk_level' => $data['risk_level'] ?? 'UNKNOWN',
            'risk_description' => $data['risk_description'] ?? '',
            'confidence' => round(($data['confidence'] ?? 0) * 100, 2),
            'badge_class' => $this->getRiskBadgeClass($data['risk_level'] ?? 'UNKNOWN'),
            'badge_text' => $this->getRiskBadgeText($data['risk_level'] ?? 'UNKNOWN')
        ];
    }

    /**
     * Get Bootstrap badge class based on risk level
     */
    protected function getRiskBadgeClass($riskLevel)
    {
        return match($riskLevel) {
            'Rendah' => 'success',
            'Sedang' => 'warning',
            'Tinggi' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get risk badge text in Indonesian
     */
    protected function getRiskBadgeText($riskLevel)
    {
        return match($riskLevel) {
            'Rendah' => 'Risiko Rendah',
            'Sedang' => 'Risiko Sedang',
            'Tinggi' => 'Risiko Tinggi',
            default => 'Tidak Diketahui'
        };
    }
}