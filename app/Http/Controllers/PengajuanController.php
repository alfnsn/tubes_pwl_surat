<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\KeteranganAktif;
use App\Models\KeteranganLulus;
use App\Models\LaporanHasilStudi;
use App\Models\PengantarMataKuliah;
use App\Models\DataMahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    public function store(Request $request)
    {

        $request->validate([
            'idjenisSurat' => 'required|integer',
        ]);

        try {
            $pengajuan = Pengajuan::create([
                'tanggal_pengajuan' => now(),
                'status' => 'Pending',
                'users_id' => Auth::id(),
                'jenisSurat_idjenisSurat' => $request->idjenisSurat,
            ]);

            if ($request->idjenisSurat == 1) {
                $request->validate([
                    'semester' => 'required|string|max:21',
                    'alamat' => 'required|string|max:300',
                    'keperluan' => 'required|string|max:255',
                ]);

                KeteranganAktif::create([
                    'semester' => $request->semester,
                    'alamat_bandung' => $request->alamat,
                    'keperluan_pengajuan' => $request->keperluan,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);
            } elseif ($request->idjenisSurat == 2) {
                $request->validate([
                    'ditujukan' => 'required|string|max:300',
                    'namaKodeMk' => 'required|string|max:50',
                    'semester' => 'required|string|max:21',
                    'tujuan' => 'required|string|max:200',
                    'topik' => 'required|string|max:100',
                    'namaMahasiswa' => 'required|array',
                    'namaMahasiswa.*' => 'required|string|max:120',
                    'nrpMahasiswa' => 'required|array',
                    'nrpMahasiswa.*' => 'required|string|max:9',
                ]);

                $pengantar = PengantarMataKuliah::create([
                    'ditujukan' => $request->ditujukan,
                    'nama_kode_mk' => $request->namaKodeMk,
                    'semester' => $request->semester,
                    'tujuan' => $request->tujuan,
                    'topik' => $request->topik,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);

                foreach ($request->namaMahasiswa as $index => $nama) {
                    $nrp = $request->nrpMahasiswa[$index];

                    $mahasiswa = DataMahasiswa::where('nrp', $nrp)->first();

                    if (!$mahasiswa) {
                        $mahasiswa = DataMahasiswa::create([
                            'nrp' => $nrp,
                            'nama' => $nama,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                    $pengantar->mahasiswa()->attach($mahasiswa->nrp);
                }
            } elseif ($request->idjenisSurat == 3) {
                $request->validate([
                    'tanggal' => ['required', 'date', 'before_or_equal:today'],
                ]);

                KeteranganLulus::create([
                    'tanggal_kelulusan' => $request->tanggal,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);
            } elseif ($request->idjenisSurat == 4) {
                $request->validate([
                    'keperluan' => 'required|string|max:200',
                ]);

                LaporanHasilStudi::create([
                    'keperluan_pembuatan' => $request->keperluan,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);
            }

            return redirect()->back()->with('success', 'Pengajuan berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }

    public function showPengajuan(Request $request)
    {
        $userId = Auth::id();

        $pengajuans = Pengajuan::where('users_id', $userId)
            ->with(['jenisSurat:idjenisSurat,name'])
            ->orderBy('tanggal_pengajuan', 'desc') 
            ->get(['idpengajuan', 'tanggal_pengajuan', 'status', 'jenisSurat_idjenisSurat']);

        return view('mahasiswa.riwayat-pengajuan', compact('pengajuans'));
    }

    public function showPengajuanDetail($id)
    {
        $pengajuan = Pengajuan::where('idpengajuan', $id)
            ->with(['jenisSurat', 'keteranganAktif', 'keteranganLulus', 'laporanHasilStudi', 'surat'])
            ->firstOrFail();


        return view('mahasiswa.riwayat-pengajuan-detail', compact('pengajuan'));
    }
}
