import joblib
import pandas as pd
from sklearn import preprocessing
from sklearn.preprocessing import StandardScaler
from sklearn.model_selection import RandomizedSearchCV
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import classification_report, accuracy_score
from sklearn.ensemble import RandomForestClassifier
import os

dir_path = os.path.dirname(os.path.realpath(__file__))
dir_path = ''

# Simpan data model klasifikasi terlatih
model_file = dir_path + 'model/heart_classification_model.sav'
global heart_classifier
heart_classifier = joblib.load(model_file)

# Simpan data training yang telah discaling
scaler_file = dir_path + 'model/scaler_heart.sav'
scaler_heart = joblib.load(scaler_file)

# Load dan simpan dataset
data_file = pd.read_csv('dataset/dataset.csv')

# Binary Encoding
data_file['Sex'] = data_file['Sex'].apply(lambda x: 1 if x =='M' else (0 if x =='F' else None))
data_file['ExerciseAngina'] = data_file['ExerciseAngina'].apply(lambda x: 1 if x =='Y' else (0 if x =='N' else None))

le = LabelEncoder()
data_file['ChestPainType'] = le.fit_transform(data_file['ChestPainType'])
data_file['RestingECG'] = le.fit_transform(data_file['RestingECG'])
data_file['ST_Slope'] = le.fit_transform(data_file['ST_Slope'])

# Pemisahan feature dan label
features = data_file.loc[:,'Age':'ST_Slope'].values
label = data_file['HeartDisease']

# Lakukan feature scaling
scaler = StandardScaler()
scaled_feature = scaler.fit_transform(features)

# Model RandomForest sebagai model dengan accuracy terbaik diantara percobaan
# dengan model k-NN dan SVM

# Menentukan range parameter yang digunakan
param_grid = [
    {'n_estimators': [100, 200, 300],
     'max_depth':[10, 20, 30],
     'min_samples_split':[2, 5, 10],
     'min_samples_leaf':[1, 2, 4]}
 ]

classifier = RandomizedSearchCV(RandomForestClassifier(), param_grid, scoring='recall', cv=5, refit = True, verbose = 0)
classifier.fit(scaled_feature, label)

# Cetak hasil prediksi
predictions = classifier.predict(scaled_feature)
report = classification_report(label, predictions, zero_division=1)

# Simpan hasil akurasinya dalam variabel baru
accuracy = accuracy_score(label, predictions)
if accuracy >= 0.90:
    conclusion = "Model ini memberikan hasil akurasi di atas 90%! Sangat baik."
else:
    conclusion = "Hasil akurasi yang dihasilkan sepertinya belum optimal karena di bawah 90%. Silahkan coba model lain!"
print(conclusion)

report += "\n" + conclusion

# Simpan hasil prediksi ke file 
hasil = pd.DataFrame(predictions)
hasil_file_path = 'hasil_heart.csv'
hasil.to_csv(hasil_file_path, index=True)

print("\nClassification Report:")
print(report)
print("\nHasil Prediksi:")
print(hasil)
