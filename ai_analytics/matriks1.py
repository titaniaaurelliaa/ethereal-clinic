import os
import matplotlib.pyplot as plt
import seaborn as sns
import pandas as pd
from dotenv import load_dotenv
from sklearn.metrics import confusion_matrix, classification_report

# 1. Paksa Python membaca file .env di folder ai_analytics
load_dotenv()

# 2. Ambil target kelas dari .env (jika ada) atau tentukan manual
# Kita pakai 2 kelas utama Ethereal Clinic: jerawat dan kista
klasifikasi_kelas = ['jerawat', 'kista']

# 3. Data sampel hasil pengujian visual kamu kemarin, Van!
# Silakan sesuaikan isinya nanti kalau ada perubahan sampel
y_actual    = ['jerawat', 'jerawat', 'kista', 'jerawat', 'kista', 'kista', 'jerawat', 'kista', 'jerawat', 'jerawat', 'kista', 'jerawat']
y_predicted = ['jerawat', 'kista',   'kista', 'jerawat', 'jerawat', 'kista', 'jerawat', 'kista', 'kista',   'jerawat', 'kista', 'jerawat']

# 4. Hitung Confusion Matrix menggunakan scikit-learn
cm = confusion_matrix(y_actual, y_predicted, labels=klasifikasi_kelas)
df_cm = pd.DataFrame(cm, index=klasifikasi_kelas, columns=klasifikasi_kelas)

# 5. Gambar Heatmap yang estetik
sns.heatmap(df_cm, annot=True, cmap='Blues', fmt='d', cbar=False, square=True,
            linewidths=2, annot_kws={"size": 16, "weight": "bold"})

plt.title("Confusion Matrix Mandiri: Ethereal Clinic v1", fontsize=14, fontweight='bold', pad=15)
plt.xlabel("Tebakan Model AI (Predicted)", fontsize=12, labelpad=10)
plt.ylabel("Kenyataan Lapangan (Actual)", fontsize=12, labelpad=10)
plt.tight_layout()

# 6. Simpan grafiknya langsung ke folder lokal kamu
nama_output = "custom_confusion_matrix.png"
plt.savefig(nama_output, dpi=300)
print(f" Sukses! Grafik disimpan dengan nama: {nama_output}")

# 7. Tampilkan laporan teks presisi & recall di terminal
print("\n --- LAPORAN PERFORMA DETEKSI ---")
print(classification_report(y_actual, y_predicted, target_names=klasifikasi_kelas))