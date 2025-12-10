import sys
import json
import pickle
import numpy as np

# Ambil input dari PHP
data = json.loads(sys.argv[1])

# Load model
with open("model_diabetes.pkl", "rb") as f:
    saved = pickle.load(f)

model = saved["model"]
scaler = saved["scaler"]
label_encoders = saved["label_encoders"]

# Encode nilai string
for key in data:
    if key in label_encoders:
        data[key] = label_encoders[key].transform([data[key]])[0]

# Konversi jadi array
X = np.array(list(data.values())).reshape(1, -1)

# Scaling
X_scaled = scaler.transform(X)

# Prediksi
result = model.predict(X_scaled)[0]
prob = model.predict_proba(X_scaled)[0][1]

# Kirim hasil ke PHP
print(json.dumps({
    "diabetes": int(result),
    "probabilitas": float(prob)
}))
