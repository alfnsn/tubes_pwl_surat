<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\User;
use App\Models\Notifikasi;
use App\Models\PengantarTugasMataKuliah;
use App\Models\DataMahasiswa;
use App\Models\PengantarMataKuliah;

class PengantarTugasMataKuliahController extends Controller
{
    public function index()
    {
        $pengantarTugasMataKuliah = Pengajuan::whereHas('user', function ($query) {
            $query->where('role_id', 1);
        })
        ->where('jenisSurat_idjenisSurat', 2)
        ->with('user', 'jenisSurat')
        ->get();

        return view('admin.pengantarTugasMataKuliah', compact('pengantarTugasMataKuliah'));
    }

    public function create()
    {
        $mahasiswa = User::where('role_id', 1)->get(); 
        return view('admin.createPengantarTugasMataKuliah', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
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

        try {
            // Get the first NRP from the input
            $firstNrp = $request->nrpMahasiswa[0];

            // Create Pengajuan
            $pengajuan = Pengajuan::create([
                'tanggal_pengajuan' => now(),
                'status' => 'Menunggu Persetujuan Kaprodi',
                'users_id' => $firstNrp, // Set users_id as the first NRP
                'jenisSurat_idjenisSurat' => 2,
            ]);

            // Create PengantarMataKuliah
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

            // Attach Mahasiswa to PengantarMataKuliah
            foreach ($request->namaMahasiswa as $index => $nama) {
                $nrp = $request->nrpMahasiswa[$index];

                $mahasiswa = DataMahasiswa::firstOrCreate(
                    ['nrp' => $nrp],
                    ['nama' => $nama, 'created_at' => now(), 'updated_at' => now()]
                );

                $pengantar->mahasiswa()->attach($mahasiswa->nrp);
            }

            // Send Notification to Kaprodi
            $kaprodi = User::where('study_program_id', $pengajuan->user->study_program_id)
                ->where('role_id', 2)
                ->where('status', 'aktif')
                ->first();

            if ($kaprodi) {
                Notifikasi::create([
                    'pesan' => $pengajuan->user->name . ' melakukan pengajuan surat Pengantar Mata Kuliah',
                    'status' => 'unread',
                    'users_id' => $pengajuan->users_id,
                    'tujuan' => $kaprodi->id,
                    'pengajuan_idpengajuan' => $pengajuan->getKey(),
                ]);
            }

            return redirect()->route('pengantar-tugas-mata-kuliah-admin')->with('success', 'Pengajuan berhasil dikirim!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
        }
    }
}
