<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\User;
use App\Models\Notifikasi;
use App\Models\KeteranganLulus;

class KeteranganLulusController extends Controller
{
    public function index()
    {
        $keteranganLulus = Pengajuan::whereHas('user', function ($query) {
            $query->where('role_id', 1);
        })
        // ->where('status', 'Surat Telah Selesai Dibuat')
        ->where('jenisSurat_idjenisSurat', 3) 
        ->with('user', 'jenisSurat')
        ->get();

        return view('admin.keteranganLulus', compact('keteranganLulus'));
    }

    public function create()
    {
        $mahasiswa = User::where('role_id', 1)->get(); // Assuming role_id 1 is for mahasiswa
        return view('admin.createKeteranganLulus', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nrp' => 'required|exists:users,id',
            'tanggal' => ['required', 'date', 'before_or_equal:today'],
        ]);

        try {
            $pengajuan = Pengajuan::create([
                'tanggal_pengajuan' => now(),
                'status' => 'Menunggu Persetujuan Kaprodi',
                'users_id' => $request->nrp,
                'jenisSurat_idjenisSurat' => 3,
            ]);

            KeteranganLulus::create([
                'tanggal_kelulusan' => $request->tanggal,
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
                    'pesan' => $pengajuan->user->name . ' melakukan pengajuan surat Keterangan Lulus',
                    'status' => 'unread',
                    'users_id' => $pengajuan->users_id,
                    'tujuan' => $kaprodi->id,
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);
            }

            return redirect()->route('keterangan-lulus-admin')->with('success', 'Pengajuan berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
        }
    }
}
