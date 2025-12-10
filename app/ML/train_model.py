import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import StandardScaler
from sklearn.linear_model import LogisticRegression
from sklearn.preprocessing import LabelEncoder
import pickle

# Load dataset
df = pd.read_csv("dataset_diabetes_dini.csv")

# Encode otomatis semua kolom yang bertipe object/string
label_encoders = {}
for col in df.columns:
    if df[col].dtype == 'object':
        le = LabelEncoder()
        df[col] = le.fit_transform(df[col])
        label_encoders[col] = le

# Pisahkan fitur dan label
X = df.drop("diabetes", axis=1)
y = df["diabetes"]

# Scaling
scaler = StandardScaler()
X_scaled = scaler.fit_transform(X)

# Train model
model = LogisticRegression()
model.fit(X_scaled, y)

# Simpan model + scaler + encoder
with open("model_diabetes.pkl", "wb") as f:
    pickle.dump({
        "model": model,
        "scaler": scaler,
        "label_encoders": label_encoders
    }, f)

print("Model berhasil dibuat → model_diabetes.pkl")
