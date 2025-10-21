import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LogisticRegression
import pickle

# Contoh dataset sederhana
data = {
    'glucose': [80, 120, 150, 200, 160, 100, 90, 140],
    'bmi': [18, 22, 28, 35, 30, 25, 20, 29],
    'blood_pressure': [70, 80, 85, 90, 88, 75, 72, 86],
    'diabetes': [0, 0, 1, 1, 1, 0, 0, 1]
}

df = pd.DataFrame(data)

# Pisahkan fitur dan label
X = df[['glucose', 'bmi', 'blood_pressure']]
y = df['diabetes']

# Bagi data
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Latih model
model = LogisticRegression()
model.fit(X_train, y_train)

# Simpan model ke file
with open('model.pkl', 'wb') as f:
    pickle.dump(model, f)

print("Model selesai dilatih dan disimpan ke 'model.pkl'")
