<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\User;
use App\Models\Notifikasi;
use App\Models\KeteranganAktif;
use Illuminate\Support\Facades\Auth;

class KeteranganAktifController extends Controller
{
    public function index()
    {
        $keteranganAktif = Pengajuan::whereHas('user', function ($query) {
            $query->where('role_id', 1);
        })
        ->where('jenisSurat_idjenisSurat', 1)
        ->with('user', 'jenisSurat')
        ->get();

        return view('admin.keteranganAktif', compact('keteranganAktif'));
    }

    public function create()
    {
        $mahasiswa = User::where('role_id', 1)->get(); // Assuming role_id 1 is for mahasiswa
        return view('admin.createKeteranganAktif', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nrp' => 'required|exists:users,id',
            'semester' => 'required|string|max:21',
            'alamat' => 'required|string|max:300',
            'keperluan' => 'required|string|max:255',
        ]);

        try {
            $pengajuan = Pengajuan::create([
                'tanggal_pengajuan' => now(),
                'status' => 'Menunggu Persetujuan Kaprodi',
                'users_id' => $request->nrp,
                'jenisSurat_idjenisSurat' => 1,
            ]);

            KeteranganAktif::create([
                'semester' => $request->semester,
                'alamat_bandung' => $request->alamat,
                'keperluan_pengajuan' => $request->keperluan,
                'created_at' => now(),
                'updated_at' => now(),
                'pengajuan_idpengajuan' => $pengajuan->getKey(),
            ]);

            $kaprodi = \App\Models\User::where('study_program_id', $pengajuan->user->study_program_id)
                ->where('role_id', 2)
                ->where('status', 'aktif')
                ->first();

            if ($kaprodi) {
                Notifikasi::create([
                    'pesan' => $pengajuan->user->name . ' melakukan pengajuan surat Keterangan Aktif',
                    'status' => 'unread',
                    'users_id' => $pengajuan->users_id,
                    'tujuan' => $kaprodi->id,
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);
            }

            return redirect()->route('keterangan-aktif-admin')->with('success', 'Pengajuan berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
        }
    }
}
