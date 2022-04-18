<?php

namespace App\Controllers;

use App\Models\MatakuliahModel;

use App\Models\MahasiswaModel;

use App\Models\PresensiModel;

class Home extends BaseController
{
    public $matakuliahModel;

    public $mahasiswaModel;

    public $presensiModel;

    public function __construct()
    {
        $this->mahasiswaModel = new MahasiswaModel();
        $this->matakuliahModel = new MatakuliahModel();
        $this->presensiModel = new PresensiModel();
    }

    public function index()
    {
        session();
        $data = [
            'validation'    => \config\Services::validation(),
            'matakuliah'  => $this->matakuliahModel->asObject()->findAll()
        ];
        return view('welcome_message', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'nim'   => 'required',
            'ip_address'   => 'required',
            'id_matakuliah'   => 'required'
        ])) {
            $validation = \config\Services::validation();
            return redirect()->to('/')->withInput()->with('validation', $validation);
        }

        $nim = $this->request->getVar('nim');
        $id_matakuliah = $this->request->getVar('id_matakuliah');
        $ip_address = $this->request->getVar('ip_address');

        $matakuliah = $this->matakuliahModel->where('id', $id_matakuliah)->asObject()->first();

        $jadwal_absensi = $matakuliah->jadwal_absensi;

        $jadwal_absensi = date('Y-m-d ' . $jadwal_absensi);
        if (date('Y-m-d H:i') <= $jadwal_absensi) {
            return redirect()->to('/')->with('error', "presensi gagal, belum waktu untuk jadwal absensi");
        }

        $mahasiswa = $this->mahasiswaModel->where('nim', $nim)->asObject()->first();
        if (!empty($mahasiswa)) {
            $mahasiswa_id = $mahasiswa->id;
            $presensi = $this->presensiModel->where('id_matakuliah', $id_matakuliah)->where('ip_address', $ip_address)->asObject()->first();
            if (!empty($presensi)) {
                return redirect()->to('/')->with('error', "presensi gagal, ip address sudah digunakan");
            }
            $data = [
                'id_matakuliah' => $id_matakuliah,
                'id_mahasiswa' => $mahasiswa_id,
                'ip_address' => $ip_address,
                'status' => 1,
            ];
            $this->presensiModel->insert($data);
            return redirect()->to('/')->with('success', "presensi telah berhasil");
        } else {
            return redirect()->to('/')->with('error', "Data mahasiswa tidak ditemukan!");
        }
    }
}
