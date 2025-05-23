<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\KeteranganAktif;
use App\Models\KeteranganLulus;
use App\Models\LaporanHasilStudi;
use App\Models\PengantarMataKuliah;
use App\Models\DataMahasiswa;
use App\Models\Surat;
use App\template\TemplateSurat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Notifikasi;

class PengajuanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'idjenisSurat' => 'required|integer',
        ]);

        try {
            if ($request->idjenisSurat == 1) {
                $request->validate([
                    'semester' => 'required|string|max:21',
                    'alamat' => 'required|string|max:300',
                    'keperluan' => 'required|string|max:255',
                ]);
            } elseif ($request->idjenisSurat == 2) {
                $request->validate([
                    'namaKodeMk' => [
                        'required',
                        'string',
                        'max:50',
                        'regex:/^[A-Za-z0-9\s]+ - [A-Za-z0-9\s]+$/'
                    ],
                    'ditujukan' => [
                        'required',
                        'string',
                        'max:300',
                        'regex:/^([A-Za-z0-9\s.,;()\-\/]+;\s*){2}[A-Za-z0-9\s.,;()\-\/]+$/'
                    ],
                    'semester' => 'required|string|max:21',
                    'tujuan' => 'required|string|max:200',
                    'topik' => 'required|string|max:100',
                    'namaMahasiswa' => 'required|array',
                    'namaMahasiswa.*' => 'required|string|max:120',
                    'nrpMahasiswa' => 'required|array',
                    'nrpMahasiswa.*' => 'required|string|max:9',
                ], [
                    'namaKodeMk.regex' => 'Format harus: Teks - Teks (contoh: Proses Bisnis - IN234).',
                    'ditujukan.regex' => 'Format harus: Nama; Jabatan; Perusahaan (contoh: Ibu Susi Susanti; Kepala Personalia PT. X; Jln. Cibogo no. 10 Bandung).'
                ]);
            } elseif ($request->idjenisSurat == 3) {
                $request->validate([
                    'tanggal' => ['required', 'date', 'before_or_equal:today'],
                ]);
            } elseif ($request->idjenisSurat == 4) {
                $request->validate([
                    'keperluan' => 'required|string|max:200',
                ]);
            }
        
            $pengajuan = Pengajuan::create([
                'tanggal_pengajuan' => now(),
                'status' => 'Menunggu Persetujuan Kaprodi',
                'users_id' => Auth::id(),
                'jenisSurat_idjenisSurat' => $request->idjenisSurat,
            ]);
        
            if ($request->idjenisSurat == 1) {
                KeteranganAktif::create([
                    'semester' => $request->semester,
                    'alamat_bandung' => $request->alamat,
                    'keperluan_pengajuan' => $request->keperluan,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);

                try {
                    $kaprodi = \App\Models\User::where('study_program_id', $pengajuan->user->study_program_id)
                    ->where('role_id', 2) 
                    ->where('status', 'aktif')
                    ->first();
                    $namaKaprodi = $kaprodi->id;
                    Notifikasi::create([
                        'pesan' => Auth::user()->name . ' melakukan pengajuan surat Keterangan Aktif',
                        'status' => 'unread',
                        'users_id' => Auth::id(),
                        'tujuan' => $namaKaprodi,
                        'pengajuan_idpengajuan' => $pengajuan->getKey(),
                    ]);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            } elseif ($request->idjenisSurat == 2) {
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

                try {
                    $kaprodi = \App\Models\User::where('study_program_id', $pengajuan->user->study_program_id)
                    ->where('role_id', 2) 
                    ->where('status', 'aktif')
                    ->first();
                    $namaKaprodi = $kaprodi->id;
                    Notifikasi::create([
                        'pesan' => Auth::user()->name . ' melakukan pengajuan surat Pengantar Mata Kuliah',
                        'status' => 'unread',
                        'users_id' => Auth::id(),
                        'tujuan' => $namaKaprodi,
                        'pengajuan_idpengajuan' => $pengajuan->getKey(),
                    ]);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            } elseif ($request->idjenisSurat == 3) {
                KeteranganLulus::create([
                    'tanggal_kelulusan' => $request->tanggal,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);
                try {
                    $kaprodi = \App\Models\User::where('study_program_id', $pengajuan->user->study_program_id)
                    ->where('role_id', 2) 
                    ->where('status', 'aktif')
                    ->first();
                    $namaKaprodi = $kaprodi->id;
                    Notifikasi::create([
                        'pesan' => Auth::user()->name . ' melakukan pengajuan surat Keterangan Lulus',
                        'status' => 'unread',
                        'users_id' => Auth::id(),
                        'tujuan' => $namaKaprodi,
                        'pengajuan_idpengajuan' => $pengajuan->getKey(),
                    ]);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            } elseif ($request->idjenisSurat == 4) {
                LaporanHasilStudi::create([
                    'keperluan_pembuatan' => $request->keperluan,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);
                try {
                    $kaprodi = \App\Models\User::where('study_program_id', $pengajuan->user->study_program_id)
                    ->where('role_id', 2) 
                    ->where('status', 'aktif')
                    ->first();
                    $namaKaprodi = $kaprodi->id;
                    Notifikasi::create([
                        'pesan' => Auth::user()->name . ' melakukan pengajuan surat Laporan Hasil Studi',
                        'status' => 'unread',
                        'users_id' => Auth::id(),
                        'tujuan' => $namaKaprodi,
                        'pengajuan_idpengajuan' => $pengajuan->getKey(),
                    ]);
                } catch (\Exception $e) {
                    dd($e->getMessage());
                }
            }
            return redirect()->back()->with('success', 'Pengajuan berhasil dikirim!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
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
        $idpengajuan = Pengajuan::find($id);

        if (!$idpengajuan) {
            return redirect()->back()->with('error', 'Pengajuan with the specified ID does not exist.');
        }
        
        $pengajuan = Pengajuan::where('idpengajuan', $id)
            ->with(['jenisSurat', 'keteranganAktif', 'keteranganLulus', 'laporanHasilStudi', 'surat'])
            ->firstOrFail();


        return view('mahasiswa.riwayat-pengajuan-detail', compact('pengajuan'));
    }

    public function showPengajuanKaprodi()
    {
        $kaprodi = Auth::user();

        $pengajuans = Pengajuan::whereHas('user', function ($query) use ($kaprodi) {
            $query->where('study_program_id', $kaprodi->study_program_id);
        })
            ->where('status', 'Menunggu Persetujuan Kaprodi')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        return view('kaprodi.dashboard', compact('pengajuans'));
    }


    public function showPengajuanDetailKaprodi($id)
    {
        $idpengajuan = Pengajuan::find($id);

        if (!$idpengajuan) {
            return redirect()->back()->with('error', 'Pengajuan with the specified ID does not exist.');
        }

        $pengajuan = Pengajuan::where('idpengajuan', $id)
            ->with(['jenisSurat', 'keteranganAktif', 'keteranganLulus', 'laporanHasilStudi', 'surat'])
            ->firstOrFail();


        return view('kaprodi.pengajuan-detail', compact('pengajuan'));
    }

    public function showPengajuanDetailRiwayatMo($id)
    {
        $idpengajuan = Pengajuan::find($id);

        if (!$idpengajuan) {
            return redirect()->back()->with('error', 'Pengajuan with the specified ID does not exist.');
        }

        $pengajuan = Pengajuan::where('idpengajuan', $id)
            ->with(['jenisSurat', 'keteranganAktif', 'keteranganLulus', 'laporanHasilStudi', 'surat'])
            ->firstOrFail();


        return view('kaprodi.pengajuan-detail', compact('pengajuan'));
    }

    public function update($id, Request $request)
    {
        $pengajuan = Pengajuan::where('idpengajuan', $id)->first();

        if ($pengajuan) {
            if ($request->route()->getName() == 'pengajuan-accept') {
                $pengajuan->status = 'Disetujui Oleh Kaprodi';
                $pengajuan->disetujui_oleh = Auth::id() . ' (' . Auth::user()->name . ')';
                Notifikasi::create([
                    'pesan' => 'Kaprodi menyetujui permintaan '. $pengajuan->jenisSurat->name,
                    'status' => 'unread',
                    'users_id' => Auth::id(),
                    'tujuan' => $pengajuan->users_id,
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);

                $kaprodi = \App\Models\User::where('study_program_id', $pengajuan->user->study_program_id)
                    ->where('role_id', 3) 
                    ->where('status', 'aktif')
                    ->first();
                    $namaKaprodi = $kaprodi->id;
                    Notifikasi::create([
                        'pesan' => Auth::user()->name . ' melakukan persetujuan '. $pengajuan->jenisSurat->name,
                        'status' => 'unread',
                        'users_id' => Auth::id(),
                        'tujuan' => $namaKaprodi,
                        'pengajuan_idpengajuan' => $pengajuan->getKey(),
                    ]);

                // buat
                $namaPath = TemplateSurat::generate($pengajuan);
                $pengajuan->path_template = $namaPath;
            } elseif ($request->route()->getName() == 'pengajuan-reject') {
                $pengajuan->status = 'Ditolak Oleh Kaprodi';
                $pengajuan->alasan_penolakan = $request->alasan_penolakan;
                $idjenisSurat = $pengajuan->jenisSurat_idjenisSurat;

                if ($idjenisSurat == 1) {
                    KeteranganAktif::where('pengajuan_idpengajuan', $pengajuan->idpengajuan)->delete();
                } elseif ($idjenisSurat == 2) {
                    $pengantar = PengantarMataKuliah::where('pengajuan_idpengajuan', $id)->first();
                    if ($pengantar) {
                        $pengantar->mahasiswa()->detach(); 
                        $pengantar->delete();
                    }
                    PengantarMataKuliah::where('pengajuan_idpengajuan', $pengajuan->idpengajuan)->delete();
                } elseif ($idjenisSurat == 3) {
                    KeteranganLulus::where('pengajuan_idpengajuan', $pengajuan->idpengajuan)->delete();
                } elseif ($idjenisSurat == 4) {
                    LaporanHasilStudi::where('pengajuan_idpengajuan', $pengajuan->idpengajuan)->delete();
                }

                Notifikasi::create([
                    'pesan' => 'Kaprodi menolak permintaan Anda',
                    'status' => 'unread',
                    'users_id' => Auth::id(),
                    'tujuan' => $pengajuan->users_id,
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);

                $pengajuan->save();
                return redirect()->back()->with('success', 'Pengajuan Berhasil Ditolak.');
            }
            $pengajuan->save();
            return redirect()->back()->with('success', 'Pengajuan Berhasil Diterima.');
        }
        return redirect()->back()->with('error', 'Pengajuan Tidak Ditemukan.');
    }

    public function showRiwayatPengajuanKaprodi()
    {
        $kaprodi = Auth::user();

        $pengajuans = Pengajuan::whereHas('user', function ($query) use ($kaprodi) {
            $query->where('study_program_id', $kaprodi->study_program_id);
        })
            ->where('status', '!=', 'Menunggu Persetujuan Kaprodi')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        return view('kaprodi.pengajuan-riwayat', compact('pengajuans'));
    }

    public function upload($id, Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:5120',
        ]);

        $pengajuan = Pengajuan::with('user', 'jenisSurat')->findOrFail($id);

        if ($request->file('file')) {
            $nama = str_replace(' ', '_', $pengajuan->user->name);
            $surat = str_replace(' ', '_', $pengajuan->jenisSurat->name);
            $tanggal = \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d_m_Y');
            $dot = $request->file('file')->getClientOriginalExtension();
            $namaFile = "{$nama}-{$surat}-{$tanggal}.{$dot}";

            if (Surat::where('pengajuan_idpengajuan', $pengajuan->idpengajuan)->exists()) {
                $suratt = Surat::where('pengajuan_idpengajuan', $pengajuan->idpengajuan)->first();
                $fileLama = $suratt->file_path;
                $tempatFileLama = public_path('assets/surat/' . $fileLama);
                if (file_exists($tempatFileLama)) {
                    unlink($tempatFileLama);
                }
                $suratt->update([
                    'file_path' => $namaFile,
                    'updated_at' => now(),
                ]);
            } else {
                Surat::create([
                    'file_path' => $namaFile,
                    'uploaded_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                    'pengajuan_idpengajuan' => $pengajuan->idpengajuan,
                ]);
            }
            $request->file('file')->move(public_path('assets/surat'), $namaFile);

            Notifikasi::create([
                'pesan' => Auth::user()->name . ' telah membuatkan '. $pengajuan->jenisSurat->name,
                'status' => 'unread',
                'users_id' => Auth::id(),
                'tujuan' => $pengajuan->users_id,
                'pengajuan_idpengajuan' => $pengajuan->getKey(),
            ]);

            $pengajuan->update([
                'status' => 'Surat Telah Selesai Dibuat',
                'updated_at' => now(),
            ]);

            return redirect()->back()->with('success', 'File berhasil diupload');
        }

        return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload file. Silakan coba lagi.');
    }

    public function showPengajuanMo()
    {
        $mo = Auth::user();

        $pengajuans = Pengajuan::whereHas('user', function ($query) use ($mo) {
            $query->where('study_program_id', $mo->study_program_id);
        })
            ->where('status', 'Disetujui Oleh Kaprodi')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        return view('mo.dashboard', compact('pengajuans'));
    }

    public function showRiwayatPengajuanMO()
    {
        $mo = Auth::user();

        $pengajuans = Pengajuan::whereHas('user', function ($query) use ($mo) {
            $query->where('study_program_id', $mo->study_program_id);
        })
            ->where('status', '!=', 'Menunggu Persetujuan Kaprodi')
            ->where('status', '!=', 'Disetujui Oleh Kaprodi')
            ->where('status', '!=', 'Ditolak Oleh Kaprodi')
            ->orderBy('tanggal_pengajuan', 'desc')
            ->get();

        return view('mo.pengajuan-riwayat', compact('pengajuans'));
    }

    public function showPengajuanDetailMO($id)
    {
        $idpengajuan = Pengajuan::find($id);

        if (!$idpengajuan) {
            return redirect()->back()->with('error', 'Pengajuan with the specified ID does not exist.');
        }

        $pengajuan = Pengajuan::where('idpengajuan', $id)
            ->with(['jenisSurat', 'keteranganAktif', 'keteranganLulus', 'laporanHasilStudi', 'surat'])
            ->firstOrFail();


        return view('MO.pengajuan-detail', compact('pengajuan'));
    }

    public function edit($id)
    {
        $pengajuan = Pengajuan::with([
            'jenisSurat',
            'keteranganAktif',
            'keteranganLulus',
            'laporanHasilStudi',
            'pengantarMataKuliah'
        ])->findOrFail($id);

        if ($pengajuan->status !== 'Menunggu Persetujuan Kaprodi') {
            return redirect()->back()->with('error', 'Pengajuan tidak dapat diedit.');
        }

        return view('mahasiswa.edit-pengajuan', compact('pengajuan'));
    }

    public function updatePengajuan(Request $request, $id)
    {
        $pengajuan = Pengajuan::findOrFail($id);

        if ($pengajuan->status !== 'Menunggu Persetujuan Kaprodi') {
            return redirect()->back()->with('error', 'Pengajuan tidak dapat diedit.');
        }

        $request->validate([
            'idjenisSurat' => 'required|integer',
        ]);

        try {
            if ($request->idjenisSurat == 1) {
                $request->validate([
                    'semester' => 'required|string|max:21',
                    'alamat' => 'required|string|max:300',
                    'keperluan' => 'required|string|max:255',
                ]);

                $pengajuan->keteranganAktif->update([
                    'semester' => $request->semester,
                    'alamat_bandung' => $request->alamat,
                    'keperluan_pengajuan' => $request->keperluan,
                ]);
            } elseif ($request->idjenisSurat == 2) {
                $request->validate([
                    'namaKodeMk' => [
                        'required',
                        'string',
                        'max:50',
                        'regex:/^[A-Za-z0-9\s]+ - [A-Za-z0-9\s]+$/'
                    ],
                    'ditujukan' => [
                        'required',
                        'string',
                        'max:300',
                        'regex:/^([A-Za-z0-9\s.,;()\-\/]+;\s*){2}[A-Za-z0-9\s.,;()\-\/]+$/'
                    ],
                    'semester' => 'required|string|max:21',
                    'tujuan' => 'required|string|max:200',
                    'topik' => 'required|string|max:100',
                    'namaMahasiswa' => 'required|array',
                    'namaMahasiswa.*' => 'required|string|max:120',
                    'nrpMahasiswa' => 'required|array',
                    'nrpMahasiswa.*' => 'required|string|max:9',
                ]);

                $pengajuan->pengantarMataKuliah->update([
                    'ditujukan' => $request->ditujukan,
                    'nama_kode_mk' => $request->namaKodeMk,
                    'semester' => $request->semester,
                    'tujuan' => $request->tujuan,
                    'topik' => $request->topik,
                ]);

                // Update mahasiswa data
                $pengajuan->pengantarMataKuliah->mahasiswa()->detach();
                foreach ($request->namaMahasiswa as $index => $nama) {
                    $nrp = $request->nrpMahasiswa[$index];

                    $mahasiswa = DataMahasiswa::updateOrCreate(
                        ['nrp' => $nrp],
                        ['nama' => $nama]
                    );

                    $pengajuan->pengantarMataKuliah->mahasiswa()->attach($mahasiswa->nrp);
                }
            } elseif ($request->idjenisSurat == 3) {
                $request->validate([
                    'tanggal' => ['required', 'date', 'before_or_equal:today'],
                ]);

                $pengajuan->keteranganLulus->update([
                    'tanggal_kelulusan' => $request->tanggal,
                ]);
            } elseif ($request->idjenisSurat == 4) {
                $request->validate([
                    'keperluan' => 'required|string|max:200',
                ]);

                $pengajuan->laporanHasilStudi->update([
                    'keperluan_pembuatan' => $request->keperluan,
                ]);
            }

            return redirect()->back()->with('success', 'Pengajuan berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data. Silakan coba lagi.');
        }
    }
    public function destroy($id)
{
    try {
        $pengajuan = Pengajuan::findOrFail($id);
        $idjenisSurat = $pengajuan->jenisSurat_idjenisSurat;

        // Hapus detail sesuai jenis surat
        if ($idjenisSurat == 1) {
            KeteranganAktif::where('pengajuan_idpengajuan', $id)->delete();
        } elseif ($idjenisSurat == 2) {
            $pengantar = PengantarMataKuliah::where('pengajuan_idpengajuan', $id)->first();
            if ($pengantar) {
                $pengantar->mahasiswa()->detach(); 
                $pengantar->delete();
            }
        } elseif ($idjenisSurat == 3) {
            KeteranganLulus::where('pengajuan_idpengajuan', $id)->delete();
        } elseif ($idjenisSurat == 4) {
            LaporanHasilStudi::where('pengajuan_idpengajuan', $id)->delete();
        }

        // (Opsional) Hapus notifikasi yang berkaitan
        Notifikasi::where('pengajuan_idpengajuan', $id)->delete();

        // Hapus pengajuan utama
        $pengajuan->delete();

        return redirect()->back()->with('success', 'Pengajuan berhasil dihapus.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Gagal menghapus pengajuan: ' . $e->getMessage());
    }
}

}
