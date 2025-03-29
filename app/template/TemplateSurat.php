<?php
namespace App\Template;

use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TemplateSurat
{
    public static function generate(Pengajuan $pengajuan)
    {
        $templates = [
            1 => 'Surat_Keterangan_Aktif.docx',
            2 => 'Surat_Pengantar_Mata_Kuliah.docx',
            3 => 'Surat_Keterangan_Lulus.docx',
            4 => 'Surat_Laporan_Hasil_Studi.docx',
        ];

        if (!isset($templates[$pengajuan->jenisSurat_idjenisSurat])) {
            throw new \Exception("Jenis surat tidak dikenali.");
        }

        $templateFile = app_path("template/TemplateAwal/{$templates[$pengajuan->jenisSurat_idjenisSurat]}");

        if (!file_exists($templateFile)) {
            throw new \Exception("Template tidak ditemukan: {$templateFile}");
        }

        $templateProcessor = new TemplateProcessor($templateFile);
        $templateProcessor->setValue('nama', $pengajuan->user->name);
        $templateProcessor->setValue('nrp', $pengajuan->user->id);

        $namaProdi = $pengajuan->user->studyProgram->nama;
        $pisah = explode(' ', $namaProdi);

        $singkatanProdi = array_shift($pisah); 
        foreach ($pisah as $kata) {
            $singkatanProdi .= strtoupper(substr($kata, 0, 1));
        }

        $no = $pengajuan->idpengajuan . '/' . 'KAPROG/' . $singkatanProdi . '/' . date('Y');
        $kaprodi = \App\Models\User::where('study_program_id', $pengajuan->user->study_program_id)
        ->where('role_id', 2) 
        ->where('status', 'aktif')
        ->first();
        $namaKaprodi = $kaprodi->name; 

        if ($pengajuan->jenisSurat_idjenisSurat == 1) {
            $templateProcessor->setValue('no', $no);
            $templateProcessor->setValue('prodi', $namaProdi);
            $templateProcessor->setValue('nama', $pengajuan->user->name);
            $templateProcessor->setValue('nrpid', $pengajuan->user->id);
            $templateProcessor->setValue('alamat', $pengajuan->keteranganAktif->alamat_bandung);
            $templateProcessor->setValue('periode', $pengajuan->keteranganAktif->semester);
            $templateProcessor->setValue('keperluan', $pengajuan->keteranganAktif->keperluan_pengajuan);
            $templateProcessor->setValue('namaKaprodi', $namaKaprodi);
        } elseif ($pengajuan->jenisSurat_idjenisSurat == 2) {
            Carbon::setLocale('id');
            $tanggalPengajuan = Carbon::parse($pengajuan->tanggal_pengajuan)->format('d F Y');
            $pisah = explode(' - ', $pengajuan->pengantarMataKuliah->nama_kode_mk);
            $namaMK = $pisah[0];
            $kodeMK = $pisah[1];
            $perihal = 'Surat Pengantar Tugas Mata Kuliah ' . $namaMK . ' (' . $kodeMK . ')';
            $pisah2 = explode('; ', $pengajuan->pengantarMataKuliah->ditujukan);
            $namatujuan = $pisah2[0];
            $sebagai = $pisah2[1];
            $dimana = $pisah2[2];

            $templateProcessor->setValue('tanggal', $tanggalPengajuan);
            $templateProcessor->setValue('no', $no);
            $templateProcessor->setValue('perihal', $perihal);
            $templateProcessor->setValue('namatujuan', $namatujuan);
            $templateProcessor->setValue('sebagai', $sebagai);
            $templateProcessor->setValue('dimana', $dimana);
            $templateProcessor->setValue('namamk', $namaMK);
            $templateProcessor->setValue('kodemk', $kodeMK);
            $templateProcessor->setValue('periode', $pengajuan->pengantarMataKuliah->semester);
            $templateProcessor->setValue('prodi', $namaProdi);
            $mahasiswaList = $pengajuan->pengantarMataKuliah->mahasiswa;
            if ($mahasiswaList->isNotEmpty()) {
                $jumlahMahasiswa = $mahasiswaList->count();
                $templateProcessor->cloneRow('row_no', $jumlahMahasiswa);

                
                foreach ($mahasiswaList as $index => $mahasiswa) {
                    $indexRow = $index + 1; 
                    $templateProcessor->setValue("row_no#{$indexRow}", $indexRow);
                    $templateProcessor->setValue("namaMHS#{$indexRow}", $mahasiswa->nama);
                    $templateProcessor->setValue("nrpNO#{$indexRow}", $mahasiswa->nrp);
                }
            } else {
                $templateProcessor->setValue('no', '-');
                $templateProcessor->setValue('namam', 'Tidak ada data');
                $templateProcessor->setValue('nrpNO', '-');
            }
            
            $templateProcessor->setValue('tujuan', $pengajuan->pengantarMataKuliah->tujuan );
            $templateProcessor->setValue('topik', $pengajuan->pengantarMataKuliah->topik );
            $templateProcessor->setValue('namaKaprodi', $namaKaprodi);
        } elseif ($pengajuan->jenisSurat_idjenisSurat == 3) {
            $templateProcessor->setValue('no', $no);
            $templateProcessor->setValue('prodi', $namaProdi);
            $templateProcessor->setValue('nama', $pengajuan->user->name);
            $templateProcessor->setValue('nrpid', $pengajuan->user->id);
            $templateProcessor->setValue('tanggalLulus', Carbon::parse($pengajuan->keteranganLulus->tanggal_kelulusan)->format('d-m-Y'));
            $templateProcessor->setValue('namaKaprodi', $namaKaprodi); 
        } elseif ($pengajuan->jenisSurat_idjenisSurat == 4) {
            $templateProcessor->setValue('no', $no);
            $templateProcessor->setValue('prodi', $namaProdi);
            $templateProcessor->setValue('nama', $pengajuan->user->name);
            $templateProcessor->setValue('nrpid', $pengajuan->user->id);
            $templateProcessor->setValue('namaKaprodi', $namaKaprodi);
            $templateProcessor->setValue('keperluan', $pengajuan->laporanHasilStudi->keperluan_pembuatan);
        }

        $formattedDate = \Carbon\Carbon::parse($pengajuan->created_at)->format('d-m-Y');

        $filename = "{$pengajuan->jenisSurat->name}_{$pengajuan->user->name}_{$formattedDate}_{$pengajuan->idpengajuan}.docx";
        $templateProcessor->saveAs(public_path("assets/TemplateJadi/{$filename}"));

        return $filename;
    }
}
