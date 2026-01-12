import pandas as pd
import numpy as np
from sklearn.model_selection import train_test_split, GridSearchCV
from sklearn.preprocessing import LabelEncoder, StandardScaler
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import classification_report, confusion_matrix, accuracy_score
import joblib
import json

def load_and_prepare_data(csv_file):
    """Load and prepare the dataset"""
    df = pd.read_csv(csv_file)
    
    # Encode categorical variables
    label_encoders = {}
    categorical_columns = ['jenis_kelamin', 'olahraga', 'pola_makan']
    
    for col in categorical_columns:
        le = LabelEncoder()
        df[col] = le.fit_transform(df[col])
        label_encoders[col] = le
    
    # Separate features and target
    X = df.drop('diabetes', axis=1)
    y = df['diabetes']
    
    return X, y, label_encoders, df.columns.tolist()

def train_model(X_train, y_train):
    """Train Random Forest model with hyperparameter tuning"""
    
    # Define parameter grid for GridSearch
    param_grid = {
        'n_estimators': [100, 200, 300],
        'max_depth': [10, 20, 30, None],
        'min_samples_split': [2, 5, 10],
        'min_samples_leaf': [1, 2, 4],
        'max_features': ['sqrt', 'log2']
    }
    
    # Initialize Random Forest
    rf = RandomForestClassifier(random_state=42)
    
    # Grid Search with cross-validation
    print("Melakukan hyperparameter tuning...")
    grid_search = GridSearchCV(
        estimator=rf,
        param_grid=param_grid,
        cv=5,
        n_jobs=-1,
        verbose=2,
        scoring='accuracy'
    )
    
    grid_search.fit(X_train, y_train)
    
    print(f"\nBest parameters: {grid_search.best_params_}")
    print(f"Best cross-validation score: {grid_search.best_score_:.4f}")
    
    return grid_search.best_estimator_

def evaluate_model(model, X_test, y_test):
    """Evaluate the trained model"""
    y_pred = model.predict(X_test)
    
    print("\n=== Model Evaluation ===")
    print(f"Accuracy: {accuracy_score(y_test, y_pred):.4f}")
    print("\nClassification Report:")
    print(classification_report(y_test, y_pred, target_names=['No Diabetes', 'Diabetes']))
    print("\nConfusion Matrix:")
    print(confusion_matrix(y_test, y_pred))
    
    # Feature importance
    feature_importance = pd.DataFrame({
        'feature': X_test.columns,
        'importance': model.feature_importances_
    }).sort_values('importance', ascending=False)
    
    print("\n=== Top 10 Feature Importance ===")
    print(feature_importance.head(10))
    
    return feature_importance

def save_model_artifacts(model, scaler, label_encoders, feature_names, feature_importance):
    """Save model and related artifacts"""
    
    # Save model
    joblib.dump(model, 'model.pkl')
    print("\nModel saved as 'model.pkl'")
    
    # Save scaler
    joblib.dump(scaler, 'scaler.pkl')
    print("Scaler saved as 'scaler.pkl'")
    
    # Save label encoders
    joblib.dump(label_encoders, 'label_encoders.pkl')
    print("Label encoders saved as 'label_encoders.pkl'")
    
    # Save feature names
    with open('feature_names.json', 'w') as f:
        json.dump(feature_names, f)
    print("Feature names saved as 'feature_names.json'")
    
    # Save feature importance
    feature_importance.to_csv('feature_importance.csv', index=False)
    print("Feature importance saved as 'feature_importance.csv'")

def main():
    print("=== Diabetes Prediction Model Training ===\n")
    
    # Load and prepare data
    print("Loading data...")
    X, y, label_encoders, feature_names = load_and_prepare_data('diabetes_data.csv')
    
    print(f"Dataset shape: {X.shape}")
    print(f"Diabetes cases: {y.sum()} ({y.sum()/len(y)*100:.2f}%)")
    print(f"No diabetes cases: {(~y.astype(bool)).sum()} ({(~y.astype(bool)).sum()/len(y)*100:.2f}%)")
    
    # Split data
    X_train, X_test, y_train, y_test = train_test_split(
        X, y, test_size=0.2, random_state=42, stratify=y
    )
    
    # Scale features
    print("\nScaling features...")
    scaler = StandardScaler()
    X_train_scaled = scaler.fit_transform(X_train)
    X_test_scaled = scaler.transform(X_test)
    
    # Convert back to DataFrame for feature names
    X_train_scaled = pd.DataFrame(X_train_scaled, columns=X_train.columns)
    X_test_scaled = pd.DataFrame(X_test_scaled, columns=X_test.columns)
    
    # Train model
    print("\nTraining model...")
    model = train_model(X_train_scaled, y_train)
    
    # Evaluate model
    feature_importance = evaluate_model(model, X_test_scaled, y_test)
    
    # Save artifacts
    save_model_artifacts(model, scaler, label_encoders, feature_names, feature_importance)
    
    print("\n=== Training completed successfully! ===")

if __name__ == "__main__":
    main()