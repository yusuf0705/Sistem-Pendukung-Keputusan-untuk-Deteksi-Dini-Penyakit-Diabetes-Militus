from MLService import MLService
import json
import argparse

def predict_single_patient():
    """Example: Predict for a single patient"""
    
    # Initialize ML Service
    ml_service = MLService()
    
    # Example patient data
    patient_data = {
        'usia': 58,
        'jenis_kelamin': 'Laki-laki',
        'berat_badan': 92,
        'tinggi_badan': 146,
        'imt': 43.16,
        'keluarga_diabetes': 1,
        'merokok': 0,
        'minum_alkohol': 0,
        'riwayat_hipertensi': 0,
        'riwayat_obesitas': 1,
        'olahraga': 'Rutin',
        'pola_makan': 'Tidak Sehat',
        'sering_buang_air_kecil_malam': 0,
        'sering_lapar': 1,
        'pandangan_kabur': 0
    }
    
    print("=== Diabetes Prediction ===\n")
    print("Patient Data:")
    for key, value in patient_data.items():
        print(f"  {key}: {value}")
    
    # Make prediction
    result = ml_service.predict(patient_data)
    
    print("\n=== Prediction Result ===")
    print(f"Prediction: {result['prediction_label']}")
    print(f"Confidence: {result['confidence']*100:.2f}%")
    print(f"Diabetes Probability: {result['probability']['diabetes']*100:.2f}%")
    print(f"Risk Level: {result['risk_level']}")
    print(f"Description: {result['risk_description']}")
    
    # Get detailed explanation
    explanation = ml_service.explain_prediction(patient_data)
    
    print("\n=== Risk Factors ===")
    if explanation['identified_risk_factors']:
        for factor in explanation['identified_risk_factors']:
            print(f"  • {factor}")
    else:
        print("  No significant risk factors identified")
    
    print("\n=== Recommendation ===")
    print(explanation['recommendation'])

def predict_batch_patients():
    """Example: Predict for multiple patients"""
    
    # Initialize ML Service
    ml_service = MLService()
    
    # Multiple patient data
    patients = [
        {
            'usia': 58,
            'jenis_kelamin': 'Laki-laki',
            'berat_badan': 92,
            'tinggi_badan': 146,
            'imt': 43.16,
            'keluarga_diabetes': 1,
            'merokok': 0,
            'minum_alkohol': 0,
            'riwayat_hipertensi': 0,
            'riwayat_obesitas': 1,
            'olahraga': 'Rutin',
            'pola_makan': 'Tidak Sehat',
            'sering_buang_air_kecil_malam': 0,
            'sering_lapar': 1,
            'pandangan_kabur': 0
        },
        {
            'usia': 25,
            'jenis_kelamin': 'Perempuan',
            'berat_badan': 55,
            'tinggi_badan': 165,
            'imt': 20.2,
            'keluarga_diabetes': 0,
            'merokok': 0,
            'minum_alkohol': 0,
            'riwayat_hipertensi': 0,
            'riwayat_obesitas': 0,
            'olahraga': 'Rutin',
            'pola_makan': 'Sehat',
            'sering_buang_air_kecil_malam': 0,
            'sering_lapar': 0,
            'pandangan_kabur': 0
        }
    ]
    
    print("=== Batch Prediction ===\n")
    
    results = ml_service.predict_batch(patients)
    
    for i, result in enumerate(results, 1):
        print(f"\nPatient {i}:")
        if 'error' in result:
            print(f"  Error: {result['error']}")
        else:
            print(f"  Prediction: {result['prediction_label']}")
            print(f"  Diabetes Probability: {result['probability']['diabetes']*100:.2f}%")
            print(f"  Risk Level: {result['risk_level']}")

def predict_from_input():
    """Interactive prediction from user input"""
    
    print("=== Interactive Diabetes Prediction ===\n")
    
    # Initialize ML Service
    ml_service = MLService()
    
    # Get user input
    print("Please enter patient information:")
    
    patient_data = {}
    
    # Numeric inputs
    patient_data['usia'] = int(input("Age (tahun): "))
    patient_data['berat_badan'] = float(input("Weight (kg): "))
    patient_data['tinggi_badan'] = float(input("Height (cm): "))
    
    # Calculate BMI
    height_m = patient_data['tinggi_badan'] / 100
    patient_data['imt'] = patient_data['berat_badan'] / (height_m ** 2)
    
    # Categorical inputs
    patient_data['jenis_kelamin'] = input("Gender (Laki-laki/Perempuan): ")
    patient_data['olahraga'] = input("Exercise frequency (Rutin/Kadang/Jarang): ")
    patient_data['pola_makan'] = input("Diet pattern (Sehat/Cukup Sehat/Tidak Sehat): ")
    
    # Binary inputs
    patient_data['keluarga_diabetes'] = int(input("Family history of diabetes (1=Yes, 0=No): "))
    patient_data['merokok'] = int(input("Smoking (1=Yes, 0=No): "))
    patient_data['minum_alkohol'] = int(input("Alcohol consumption (1=Yes, 0=No): "))
    patient_data['riwayat_hipertensi'] = int(input("History of hypertension (1=Yes, 0=No): "))
    patient_data['riwayat_obesitas'] = int(input("History of obesity (1=Yes, 0=No): "))
    patient_data['sering_buang_air_kecil_malam'] = int(input("Frequent urination at night (1=Yes, 0=No): "))
    patient_data['sering_lapar'] = int(input("Frequent hunger (1=Yes, 0=No): "))
    patient_data['pandangan_kabur'] = int(input("Blurred vision (1=Yes, 0=No): "))
    
    # Make prediction
    print("\n" + "="*50)
    result = ml_service.predict(patient_data)
    
    print("\n=== Prediction Result ===")
    print(f"BMI: {patient_data['imt']:.2f}")
    print(f"Prediction: {result['prediction_label']}")
    print(f"Confidence: {result['confidence']*100:.2f}%")
    print(f"Diabetes Probability: {result['probability']['diabetes']*100:.2f}%")
    print(f"Risk Level: {result['risk_level']}")
    print(f"Description: {result['risk_description']}")
    
    # Get explanation
    explanation = ml_service.explain_prediction(patient_data)
    
    print("\n=== Risk Factors ===")
    if explanation['identified_risk_factors']:
        for factor in explanation['identified_risk_factors']:
            print(f"  • {factor}")
    else:
        print("  No significant risk factors identified")
    
    print("\n=== Recommendation ===")
    print(explanation['recommendation'])

def show_model_info():
    """Display model information"""
    
    ml_service = MLService()
    
    print("=== Model Information ===\n")
    
    info = ml_service.get_model_info()
    
    for key, value in info.items():
        if key == 'features':
            print(f"\n{key}:")
            for feature in value:
                print(f"  • {feature}")
        else:
            print(f"{key}: {value}")
    
    # Show feature importance
    print("\n=== Top 10 Feature Importance ===")
    importance = ml_service.get_feature_importance(top_n=10)
    
    for feature, imp in zip(importance['features'], importance['importance']):
        print(f"  {feature}: {imp:.4f}")

def main():
    parser = argparse.ArgumentParser(description='Diabetes Prediction System')
    parser.add_argument('--mode', type=str, default='single',
                       choices=['single', 'batch', 'interactive', 'info'],
                       help='Prediction mode: single, batch, interactive, or info')
    
    args = parser.parse_args()
    
    try:
        if args.mode == 'single':
            predict_single_patient()
        elif args.mode == 'batch':
            predict_batch_patients()
        elif args.mode == 'interactive':
            predict_from_input()
        elif args.mode == 'info':
            show_model_info()
    
    except Exception as e:
        print(f"\nError: {str(e)}")
        print("\nPlease make sure you have trained the model first by running 'python train_model.py'")

if __name__ == "__main__":
    main()