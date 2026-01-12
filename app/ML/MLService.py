import joblib
import json
import numpy as np
import pandas as pd
from typing import Dict, List, Tuple

class MLService:
    """Machine Learning Service for Diabetes Prediction"""
    
    def __init__(self, model_path='model.pkl', scaler_path='scaler.pkl', 
                 encoders_path='label_encoders.pkl', features_path='feature_names.json'):
        """Initialize ML Service with saved model artifacts"""
        try:
            self.model = joblib.load(model_path)
            self.scaler = joblib.load(scaler_path)
            self.label_encoders = joblib.load(encoders_path)
            
            with open(features_path, 'r') as f:
                self.feature_names = json.load(f)
            
            # Remove target variable from feature names
            self.feature_names = [f for f in self.feature_names if f != 'diabetes']
            
            print("Model loaded successfully!")
            print(f"Model type: {type(self.model).__name__}")
            print(f"Number of features: {len(self.feature_names)}")
            
        except Exception as e:
            raise Exception(f"Error loading model artifacts: {str(e)}")
    
    def preprocess_input(self, input_data: Dict) -> pd.DataFrame:
        """Preprocess input data for prediction"""
        # Create DataFrame from input
        df = pd.DataFrame([input_data])
        
        # Encode categorical variables
        for col, encoder in self.label_encoders.items():
            if col in df.columns:
                df[col] = encoder.transform(df[col])
        
        # Ensure all features are present and in correct order
        for feature in self.feature_names:
            if feature not in df.columns:
                df[feature] = 0
        
        df = df[self.feature_names]
        
        # Scale features and keep as DataFrame
        scaled_data = self.scaler.transform(df)
        scaled_df = pd.DataFrame(scaled_data, columns=self.feature_names)
        
        return scaled_df
    
    def predict(self, input_data: Dict) -> Dict:
        """Make prediction for a single patient"""
        try:
            # Preprocess input
            processed_data = self.preprocess_input(input_data)
            
            # Make prediction
            prediction = self.model.predict(processed_data)[0]
            probability = self.model.predict_proba(processed_data)[0]
            
            # Get risk level
            risk_level, risk_description = self._get_risk_level(probability[1])
            
            result = {
                'prediction': int(prediction),
                'prediction_label': 'Diabetes' if prediction == 1 else 'No Diabetes',
                'probability': {
                    'no_diabetes': float(probability[0]),
                    'diabetes': float(probability[1])
                },
                'risk_level': risk_level,
                'risk_description': risk_description,
                'confidence': float(max(probability))
            }
            
            return result
            
        except Exception as e:
            raise Exception(f"Error making prediction: {str(e)}")
    
    def predict_batch(self, input_list: List[Dict]) -> List[Dict]:
        """Make predictions for multiple patients"""
        results = []
        for input_data in input_list:
            try:
                result = self.predict(input_data)
                results.append(result)
            except Exception as e:
                results.append({
                    'error': str(e),
                    'input': input_data
                })
        
        return results
    
    def _get_risk_level(self, probability: float) -> Tuple[str, str]:
        """Determine risk level based on probability"""
        if probability < 0.4:
            return 'Rendah', 'Risiko rendah terkena diabetes'
        elif probability < 0.7:
            return 'Sedang', 'Risiko sedang terkena diabetes. Perhatikan gaya hidup.'
        else:
            return 'Tinggi', 'Risiko tinggi terkena diabetes. Konsultasi dengan dokter dianjurkan.'
    
    def get_feature_importance(self, top_n: int = 10) -> Dict:
        """Get feature importance from the model"""
        if hasattr(self.model, 'feature_importances_'):
            importance = self.model.feature_importances_
            
            feature_importance = pd.DataFrame({
                'feature': self.feature_names,
                'importance': importance
            }).sort_values('importance', ascending=False)
            
            top_features = feature_importance.head(top_n)
            
            return {
                'features': top_features['feature'].tolist(),
                'importance': top_features['importance'].tolist()
            }
        else:
            return {'error': 'Model does not support feature importance'}
    
    def explain_prediction(self, input_data: Dict) -> Dict:
        """Provide explanation for prediction"""
        result = self.predict(input_data)
        
        # Get feature importance
        feature_importance = self.get_feature_importance(top_n=5)
        
        # Identify risk factors
        risk_factors = []
        
        if input_data.get('imt', 0) > 30:
            risk_factors.append('IMT tinggi (obesitas)')
        if input_data.get('usia', 0) > 45:
            risk_factors.append('Usia di atas 45 tahun')
        if input_data.get('keluarga_diabetes', 0) == 1:
            risk_factors.append('Riwayat keluarga diabetes')
        if input_data.get('riwayat_hipertensi', 0) == 1:
            risk_factors.append('Riwayat hipertensi')
        if input_data.get('riwayat_obesitas', 0) == 1:
            risk_factors.append('Riwayat obesitas')
        if input_data.get('pola_makan') == 'Tidak Sehat':
            risk_factors.append('Pola makan tidak sehat')
        if input_data.get('olahraga') == 'Jarang':
            risk_factors.append('Jarang berolahraga')
        
        explanation = {
            'prediction': result,
            'top_contributing_factors': feature_importance,
            'identified_risk_factors': risk_factors,
            'recommendation': self._generate_recommendation(result, risk_factors)
        }
        
        return explanation
    
    def _generate_recommendation(self, result: Dict, risk_factors: List[str]) -> str:
        """Generate health recommendation based on prediction"""
        
        risk_level = result['risk_level']
        
        if risk_level == 'LOW':
            return "Pertahankan gaya hidup sehat Anda dengan olahraga rutin dan pola makan seimbang."
        elif risk_level == 'MEDIUM':
            recommendations = [
                "- Tingkatkan aktivitas fisik menjadi minimal 150 menit per minggu",
                "- Konsumsi makanan sehat dengan mengurangi gula dan karbohidrat olahan",
                "- Jaga berat badan ideal",
                "- Lakukan pemeriksaan gula darah secara berkala"
            ]
            return "\n".join(recommendations)
        elif risk_level == 'HIGH':
            recommendations = [
                "- Segera konsultasi dengan dokter untuk pemeriksaan lebih lanjut",
                "- Ubah pola makan menjadi lebih sehat dan teratur",
                "- Lakukan olahraga rutin minimal 30 menit setiap hari",
                "- Monitor gula darah secara teratur",
                "- Kurangi berat badan jika mengalami obesitas"
            ]
            return "\n".join(recommendations)
        else:  # VERY_HIGH
            recommendations = [
                "- SEGERA konsultasi dengan dokter spesialis",
                "- Lakukan pemeriksaan HbA1c dan gula darah puasa",
                "- Mulai program diet ketat dengan bimbingan ahli gizi",
                "- Olahraga teratur dengan pengawasan",
                "- Pantau kesehatan secara intensif"
            ]
            return "\n".join(recommendations)
    
    def get_model_info(self) -> Dict:
        """Get information about the loaded model"""
        info = {
            'model_type': type(self.model).__name__,
            'number_of_features': len(self.feature_names),
            'features': self.feature_names
        }
        
        if hasattr(self.model, 'n_estimators'):
            info['n_estimators'] = self.model.n_estimators
        if hasattr(self.model, 'max_depth'):
            info['max_depth'] = self.model.max_depth
            
        return info