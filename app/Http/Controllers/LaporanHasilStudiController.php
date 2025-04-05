<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\User;
use App\Models\Notifikasi;
use App\Models\LaporanHasilStudi;

class LaporanHasilStudiController extends Controller
{
    public function index()
    {
        $laporanHasilStudi = Pengajuan::whereHas('user', function ($query) {
            $query->where('role_id', 1);
        })
        ->where('jenisSurat_idjenisSurat', 4)
        ->with('user', 'jenisSurat')
        ->get();

        return view('admin.laporanHasilStudi', compact('laporanHasilStudi'));
    }

    public function create()
    {
        $mahasiswa = User::where('role_id', 1)->get(); 
        return view('admin.createLaporanHasilStudi', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nrp' => 'required|exists:users,id',
            'keperluan' => 'required|string|max:200',
        ]);

        try {
            // Create Pengajuan
            $pengajuan = Pengajuan::create([
                'tanggal_pengajuan' => now(),
                'status' => 'Menunggu Persetujuan Kaprodi',
                'users_id' => $request->nrp,
                'jenisSurat_idjenisSurat' => 4,
            ]);

            // Create LaporanHasilStudi
            LaporanHasilStudi::create([
                'keperluan_pembuatan' => $request->keperluan,
                'created_at' => now(),
                'updated_at' => now(),
                'pengajuan_idpengajuan' => $pengajuan->getKey(),
            ]);

            // Send Notification to Kaprodi
            $kaprodi = User::where('study_program_id', $pengajuan->user->study_program_id)
                ->where('role_id', 2)
                ->where('status', 'aktif')
                ->first();

            if ($kaprodi) {
                Notifikasi::create([
                    'pesan' => $pengajuan->user->name . ' melakukan pengajuan surat Laporan Hasil Studi',
                    'status' => 'unread',
                    'users_id' => $pengajuan->users_id,
                    'tujuan' => $kaprodi->id,
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);
            }

            return redirect()->route('laporan-hasil-studi-admin')->with('success', 'Pengajuan berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
        }
    }
}
