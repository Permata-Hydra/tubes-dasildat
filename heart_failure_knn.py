import joblib
import pandas as pd
from sklearn import preprocessing
from sklearn.preprocessing import StandardScaler
from sklearn.model_selection import GridSearchCV
from sklearn.preprocessing import LabelEncoder
from sklearn.metrics import classification_report, accuracy_score, precision_score
from sklearn.neighbors import KNeighborsClassifier

# Simpan data model klasifikasi terlatih
heart_classifier = joblib.load('model/heart_classification_model.sav')

# Simpan data training yang telah discaling
scaler_heart = joblib.load('model/scaler_heart.sav')

# Load dan simpan dataset
data_file = pd.read_csv('dataset/dataset.csv')

# Binary Encoding
data_file['Sex'] = data_file['Sex'].apply(lambda x: 1 if x =='M' else (0 if x =='F' else None))
data_file['ExerciseAngina'] = data_file['ExerciseAngina'].apply(lambda x: 1 if x =='Y' else (0 if x =='N' else None))

# Nominal Encoding
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

# Model k-Nearest Neighbors

# Menentukan range parameter yang digunakan
param_grid = [
    {'n_neighbors':[3,5,7,9,11],
     'metric':['euclidean','manhattan','chebyshev','minkowski','hamming']}
 ]

classifier = GridSearchCV(KNeighborsClassifier(), param_grid, scoring='recall', cv=10, refit = True, verbose = 0)
classifier.fit(scaled_feature, label)

# Cetak hasil prediksi
predictions = classifier.predict(scaled_feature)
report = classification_report(label, predictions, zero_division=1)

# Simpan hasil akurasi dan presisi dalam variabel baru
accuracy = accuracy_score(label, predictions)
precision = precision_score(label, predictions)

# Buatkan kesimpulan untuk hasil akurasinya
if accuracy >= 0.85:
    conclusion = "Model ini memberikan hasil akurasi di atas 85%! Sangat baik."
else:
    conclusion = "Hasil akurasi yang dihasilkan sepertinya belum optimal karena di bawah 85%. Silahkan coba model lain!"

report += "\n" + conclusion

# Simpan hasil akurasi dan presisi dalam file excel
pd.DataFrame({'Model': ['kNN'], 'Accuracy': [accuracy]}).to_csv('accuracy_knn.csv', index=False)
pd.DataFrame({'Model': ['kNN'], 'Precision': [precision]}).to_csv('precision_knn.csv', index=False)

# Simpan hasil prediksi ke file 
hasil = pd.DataFrame(predictions)
hasil_file_path = 'hasil_heart.csv'
hasil.to_csv(hasil_file_path, index=True)

print("\nClassification Report:")
print(report)
print("\nHasil Prediksi:")
print(hasil)

