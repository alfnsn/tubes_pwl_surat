@extends('layouts.indexMahasiswa')

@section('content')
    <main class="main">
        <div class="container">
            <h1 class="mt-4" style="color: #124265">Edit Pengajuan</h1>
            <form method="post" action="{{ route('pengajuan') }}">
                @csrf
                <input type="hidden" name="idpengajuan" value="{{ $pengajuan->idpengajuan }}">
                <input type="hidden" name="idjenisSurat" value="{{ $pengajuan->jenisSurat->idjenisSurat }}">

                @if ($pengajuan->jenisSurat->idjenisSurat == 1 && $pengajuan->keteranganAktif)
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <input type="text" class="form-control" name="semester"
                            value="{{ $pengajuan->keteranganAktif->semester }}" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" name="alamat" required>{{ $pengajuan->keteranganAktif->alamat_bandung }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="keperluan">Keperluan</label>
                        <textarea class="form-control" name="keperluan" required>{{ $pengajuan->keteranganAktif->keperluan_pengajuan }}</textarea>
                    </div>
                @elseif ($pengajuan->jenisSurat->idjenisSurat == 2 && $pengajuan->pengantarMataKuliah)
                    <div class="form-group">
                        <label for="ditujukan">Ditujukan</label>
                        <textarea class="form-control" name="ditujukan" required>{{ $pengajuan->pengantarMataKuliah->ditujukan }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="namaKodeMk">Nama Mata Kuliah - Kode</label>
                        <input type="text" class="form-control" name="namaKodeMk"
                            value="{{ $pengajuan->pengantarMataKuliah->nama_kode_mk }}" required>
                    </div>
                    <!-- Tambahkan field lainnya sesuai kebutuhan -->
                @elseif ($pengajuan->jenisSurat->idjenisSurat == 3 && $pengajuan->keteranganLulus)
                    <div class="form-group">
                        <label for="tanggal">Tanggal Kelulusan</label>
                        <input type="date" class="form-control" name="tanggal"
                            value="{{ $pengajuan->keteranganLulus->tanggal_kelulusan }}" required>
                    </div>
                @elseif ($pengajuan->jenisSurat->idjenisSurat == 4 && $pengajuan->laporanHasilStudi)
                    <div class="form-group">
                        <label for="keperluan">Keperluan</label>
                        <textarea class="form-control" name="keperluan" required>{{ $pengajuan->laporanHasilStudi->keperluan_pembuatan }}</textarea>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </main>
@endsection
