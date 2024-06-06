import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
from openpyxl import Workbook
from openpyxl.drawing.image import Image

# Load hasil akurasinya
knn_result = pd.read_csv('accuracy_knn.csv')
rf_result = pd.read_csv('accuracy_rf.csv')
svm_result = pd.read_csv('accuracy_svm.csv')

# Gabungkan hasilnya
accuracy_result = pd.concat([knn_result, rf_result, svm_result])

# Save combined results to Excel
excel_file_path = 'graph_accuracy.xlsx'
accuracy_result.to_excel(excel_file_path, index=False)

# Plot the results
plt.figure(figsize=(10, 6))
plt.plot(accuracy_result['Model'], accuracy_result['Accuracy'], marker='o', linestyle='-', color='b', linewidth=2, markersize=8)
plt.xlabel('Model Used')
plt.ylabel('Accuracy Values')
plt.title('Comparison of Model Accuracy')
plt.ylim(0.50, 1.0)
plt.grid(True, linestyle='--', alpha=0.7)
plt.savefig('model_accuracy_comparison.png')


# Add the plot to the Excel file
wb = Workbook()
ws = wb.active
ws.title = 'Model Accuracy'

# Add the image to the Excel file
img = Image('model_accuracy_comparison.png')
ws.add_image(img, 'E5')

# Save the Excel file
wb.save(excel_file_path)

print(excel_file_path)