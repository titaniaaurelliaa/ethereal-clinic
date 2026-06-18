import os
import requests
import json
from dotenv import load_dotenv

# 1. Muat file .env lokal
load_dotenv()

API_KEY = os.getenv("ROBOFLOW_API_KEY")
WORKSPACE = os.getenv("ROBOFLOW_WORKSPACE")
PROJECT = os.getenv("ROBOFLOW_PROJECT")
VERSION = os.getenv("ROBOFLOW_VERSION")

# 2. Jalur VIP: Tembak langsung REST API Roboflow tanpa perantara SDK
url = f"https://api.roboflow.com/{WORKSPACE}/{PROJECT}/{VERSION}"
query_params = {
    "api_key": API_KEY
}

print("Menembak langsung REST API Roboflow Server...")
response = requests.get(url, params=query_params)

if response.status_code == 200:
    payload_mentah = response.json()
    print("Koneksi Sukses! Berhasil mengunduh data JSON dari server.\n")
    
    # Ekstrak data spesifik dari objek 'version' yang dikirim Roboflow
    data_versi = payload_mentah.get("version", {})
    
    # Roboflow biasanya menyimpan metrik mAP, precision, recall di dalam objek 'train'
    data_training = data_versi.get("train", None)
    
    if data_training:
        print(" --- DATA METRIKS PERFORMA DITEMUKAN ---")
        print(json.dumps(data_training, indent=4))
    else:
        print(" Objek 'train' spesifik tidak ditemukan. Ini isi data lengkap dari server:")
        # Memutahkan isi data versi untuk kita analisis manual key mana yang menyimpan angka mAP
        print(json.dumps(data_versi, indent=4))

else:
    print(f" Gagal mengambil data. Status Code: {response.status_code}")
    print(response.text)