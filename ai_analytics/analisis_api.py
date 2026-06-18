import os
import glob
import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
from dotenv import load_dotenv
from roboflow import Roboflow

# 1. Muat konfigurasi dari .env lokal
load_dotenv()

API_KEY = os.getenv("ROBOFLOW_API_KEY")
WORKSPACE = os.getenv("ROBOFLOW_WORKSPACE")
PROJECT = os.getenv("ROBOFLOW_PROJECT")
VERSION = int(os.getenv("ROBOFLOW_VERSION"))

# 2. Inisialisasi API Roboflow
print(" Menghubungkan ke API Roboflow Server...")
rf = Roboflow(api_key=API_KEY)
project = rf.workspace(WORKSPACE).project(PROJECT)
model = project.version(VERSION).model

# 3. Cari semua gambar di dalam folder eval_images
# Pastikan kamu sudah menaruh beberapa foto wajah (.jpg/.jpeg/.png) di folder tersebut
format_gambar = ["*.jpg", "*.jpeg", "*.png", "*.JPG", "*.JPEG", "*.PNG"]
daftar_gambar = []
for f in format_gambar:
    daftar_gambar.extend(glob.glob(os.path.join("eval_images", f)))

if not daftar_gambar:
    print(" Folder 'eval_images' masih kosong! Taruh beberapa foto wajah pasien di sana dulu, Van.")
    exit()

print(f" Ditemukan {len(daftar_gambar)} gambar untuk diuji via API.")

# 4. Ambil data prediksi mentah secara real-time dari API Cloud
semua_prediksi = []

for path_img in daftar_gambar:
    nama_file = os.path.basename(path_img)
    print(f" Meminta prediksi API untuk file: {nama_file}...")
    
    try:
        # Panggil fungsi predict bawaan SDK Roboflow
        response = model.predict(path_img, confidence=40, overlap=30).json()
        
        # Ekstrak daftar objek yang berhasil ditangkap AI
        predictions = response.get("predictions", [])
        
        for pred in predictions:
            semua_prediksi.append({
                "File": nama_file,
                "Kelas": pred["class"],
                "Confidence": pred["confidence"] * 100 # Ubah ke persen (0-100%)
            })
    except Exception as e:
        print(f" Gagal memproses {nama_file}: {e}")

# 5. Konversi hasil API menjadi Dataframe Pandas untuk Analisis Statistik
if not semua_prediksi:
    print(" API tidak mendeteksi adanya jerawat/kista sama sekali dari gambar yang diberikan.")
    exit()

df = pd.DataFrame(semua_prediksi)

# 6. HITUNG STATISTIK OTOMATIS
print("\n --- HASIL ANALISIS REAL-TIME API ROBOFLOW ---")
summary = df.groupby("Kelas").agg(
    Total_Ditemukan=("Kelas", "count"),
    Rata_Rata_Confidence=("Confidence", "mean")
).reset_index()
print(summary.to_string(index=False))

# 7. VISUALISASI: Gambar Grafik Distribusi & Tingkat Pede AI (SUDAH DI-FIX)
plt.figure(figsize=(10, 5))

# Grafik Kiri: Jumlah Objek yang Ditemukan
plt.subplot(1, 2, 1)
sns.barplot(data=summary, x="Kelas", y="Total_Ditemukan", hue="Kelas", palette="Set2", legend=False)
plt.title("Total Objek yang Dideteksi AI", fontsize=12, fontweight='bold')
plt.ylabel("Jumlah Objek")
plt.xlabel("Kelas Jerawat")

# Grafik Kanan: Tingkat Kepercayaan Rata-rata
plt.subplot(1, 2, 2)
sns.barplot(data=summary, x="Kelas", y="Rata_Rata_Confidence", hue="Kelas", palette="deep", legend=False)
plt.title("Rata-rata Confidence Score (%)", fontsize=12, fontweight='bold')
plt.ylabel("Persentase (%)")
plt.xlabel("Kelas Jerawat")
plt.ylim(0, 100)

plt.tight_layout()
output_chart = "api_distribution_analysis.png"
plt.savefig(output_chart, dpi=300)
print(f"\n Grafik analisis otomatis berhasil disimpan: {output_chart}")