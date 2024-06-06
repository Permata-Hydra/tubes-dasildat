import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
from openpyxl import Workbook
from openpyxl.drawing.image import Image

# Load hasil precisionnya
knn_precision = pd.read_csv('precision_knn.csv')
rf_precision = pd.read_csv('precision_rf.csv')
svm_precision = pd.read_csv('precision_svm.csv')


# Gabungkan hasil precision
precision_result = pd.concat([knn_precision, rf_precision, svm_precision])

# Save combined results to Excel
excel_file_path = 'graph_precision.xlsx'
precision_result.to_excel(excel_file_path, index=False)

# Plot the results
plt.figure(figsize=(10, 6))
plt.plot(precision_result['Model'], precision_result['Precision'], marker='o', linestyle='-', color='b', linewidth=2, markersize=8)
plt.xlabel('Model Used')
plt.ylabel('Precision Values')
plt.title('Comparison of Model Precision')
plt.ylim(0.50, 1.0)
plt.grid(True, linestyle='--', alpha=0.7)
plt.savefig('model_precision_comparison.png')

# Add precision graph to Excel
wb = Workbook()
ws = wb.active
ws.title = 'Model Precision'

# Add the image to the Excel file
img = Image('model_precision_comparison.png')
ws.add_image(img, 'E5')

# Save the Excel file
wb.save(excel_file_path)

print(excel_file_path)