import sys
import json
import pickle
import numpy as np

# Validasi input
if len(sys.argv) < 2:
    print(json.dumps({"error": "Input JSON tidak ditemukan"}))
    sys.exit(1)

# Load model
model_path = "app/ML/model_diabetes.pkl"
with open(model_path, "rb") as f:
    model = pickle.load(f)

# Ambil input
data = json.loads(sys.argv[1])

# Konversi fitur
features = np.array([
    int(data["usia"]),
    int(data["jenis_kelamin"]),
    int(data["riwayat_keluarga"]),
    int(data["merokok"]),
    int(data["alkohol"]),
    int(data["obesitas"]),
    int(data["olahraga"])
]).reshape(1, -1)

# Prediksi
try:
    pred = model.predict(features)[0]
    proba = model.predict_proba(features)[0][1]
except Exception as e:
    print(json.dumps({"error": str(e)}))
    sys.exit(1)

# Output
print(json.dumps({
    "diabetes": int(pred),
    "probabilitas": round(float(proba), 4)
}))
