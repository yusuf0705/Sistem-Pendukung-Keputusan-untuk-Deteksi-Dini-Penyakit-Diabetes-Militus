import sys
import json
import pickle
import numpy as np

# Load model
model_path = "app/ML/model_diabetes.pkl"
with open(model_path, "rb") as f:
    model = pickle.load(f)

# Ambil input JSON dari argumen CLI
input_json = sys.argv[1]
data = json.loads(input_json)

# Convert ke urutan numerik
features = np.array([
    data["usia"],
    data["jenis_kelamin"],
    data["riwayat_keluarga"],
    data["merokok"],
    data["alkohol"],
    data["obesitas"],
    data["olahraga"]
]).reshape(1, -1)

# Prediksi
pred = model.predict(features)[0]
proba = model.predict_proba(features)[0][1]

# Output JSON
print(json.dumps({
    "diabetes": int(pred),
    "probabilitas": float(proba)
}))
