import os
import requests
import pandas as pd
import matplotlib.pyplot as plt
import seaborn as sns
from dotenv import load_dotenv

# 1. Muat file .env lokal ai_analytics
load_dotenv()

API_KEY = os.getenv("ROBOFLOW_API_KEY")
WORKSPACE = os.getenv("ROBOFLOW_WORKSPACE")
PROJECT = os.getenv("ROBOFLOW_PROJECT")
VERSION = os.getenv("ROBOFLOW_VERSION")

# 2. Ambil data dari REST API Roboflow
url = f"https://api.roboflow.com/{WORKSPACE}/{PROJECT}/{VERSION}"
print(" Menghubungkan ke API untuk menarik metrik performa...")
response = requests.get(url, params={"api_key": API_KEY})

if response.status_code == 200:
    payload = response.json()
    results = payload.get("version", {}).get("train", {}).get("results", {})
    class_map_test = results.get("class_map", {}).get("test", [])
    
    if not class_map_test:
        print("Data kelas untuk kategori 'test' tidak ditemukan di server.")
        exit()
        
    # 3. Ekstraksi data mentah JSON menjadi struktur data tabel (Pandas)
    df_list = []
    for item in class_map_test:
        # Kita lewati kategori akumulasi 'all' agar grafik per kelas lebih fokus dan bersih
        if item["class"] == "all":
            continue
        df_list.append({
            "Kelas": item["class"],
            "Precision": item["precision"] * 100,
            "Recall": item["recall"] * 100,
            "mAP50": item["map50"] * 100
        })
        
    df = pd.DataFrame(df_list)
    
    # Urutkan bar chart berdasarkan performa mAP50 tertinggi ke terendah agar rapi sesuai standar visualisasi
    df = df.sort_values(by="mAP50", ascending=False)
    
    # Melelehkan (melt) tabel untuk mempermudah pembuatan grouped bar chart di Seaborn
    df_melted = df.melt(id_vars="Kelas", var_name="Metrik", value_name="Persentase")
    
    # 4. Atur konfigurasi ukuran grafik (tanpa plt.figure() sesuai standar aman)
    plt.rcParams["figure.figsize"] = (11, 6)
    sns.set_theme(style="whitegrid")
    
    # 5. Gambar grafik batang berkelompok (Grouped Bar Chart)
    ax = sns.barplot(
        data=df_melted, 
        x="Kelas", 
        y="Persentase", 
        hue="Metrik", 
        palette="Set2"
    )
    
    # Otomatisasi penulisan angka persentase di atas setiap batang grafik
    for p in ax.patches:
        if p.get_height() > 0:
            ax.annotate(f"{p.get_height():.1f}%", 
                        (p.get_x() + p.get_width() / 2., p.get_height()), 
                        ha='center', va='center', 
                        xytext=(0, 8), 
                        textcoords='offset points', 
                        fontsize=9, fontweight='bold')
    
    # 6. Kustomisasi teks dan label agar terbaca dengan jelas dan tidak tumpang tindih
    plt.title("Analisis Komparatif Performa Model v1 per Kelas Akne (Test Set)", fontsize=14, fontweight='bold', pad=20)
    plt.ylabel("Persentase (%)", fontsize=12, fontweight='bold')
    plt.xlabel("Kelas Jerawat / Komedo", fontsize=12, fontweight='bold')
    plt.ylim(0, 110) # Beri ruang vertikal ekstra di atas grafik untuk teks label angka
    plt.xticks(rotation=15, fontsize=10, fontweight='bold')
    plt.tight_layout()
    
    # 7. Simpan grafik resolusi tinggi (300 DPI) siap cetak dokumen
    output_file = "model_performance_by_class.png"
    plt.savefig(output_file, dpi=300)
    print(f"Sukses! Grafik visualisasi performa berhasil disimpan: {output_file}")
    
else:
    print(f" Gagal mengambil data. Status Code: {response.status_code}")