@extends('layouts.indexMahasiswa')

@section('content')
    <main class="main">
        <div class="container">
            <h1 class="mt-4" style="color: #124265">Edit Pengajuan</h1>
            <form method="post" action="{{ route('pengajuan-update', $pengajuan->idpengajuan) }}">
                @csrf
                <input type="hidden" name="idpengajuan" value="{{ $pengajuan->idpengajuan }}">
                <input type="hidden" name="idjenisSurat" value="{{ $pengajuan->jenisSurat->idjenisSurat }}">

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="name" class="col-form-label">Nama Lengkap *</label>
                        <input type="text" class="form-control" name="name" id="name"
                            value="{{ Auth::user()->name }}" readonly required maxlength="120">
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="nrp" class="col-form-label">NRP *</label>
                        <input type="text" class="form-control" name="nrp" id="nrp"
                            value="{{ Auth::user()->id }}" readonly required maxlength="9">
                    </div>
                </div>

                @if ($pengajuan->jenisSurat->idjenisSurat == 1 && $pengajuan->keteranganAktif)
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="form-control" name="semester" id="semester" required>
                            <option value="" disabled {{ $pengajuan->keteranganAktif->semester ? '' : 'selected' }}>
                                Pilih Semester</option>
                            <option value="Semester Genap 24/25"
                                {{ $pengajuan->keteranganAktif->semester == 'Semester Genap 24/25' ? 'selected' : '' }}>
                                Semester Genap 24/25</option>
                            <option value="Semester Ganjil 25/26"
                                {{ $pengajuan->keteranganAktif->semester == 'Semester Ganjil 25/26' ? 'selected' : '' }}>
                                Semester Ganjil 25/26</option>
                            <option value="Semester Genap 25/26"
                                {{ $pengajuan->keteranganAktif->semester == 'Semester Genap 25/26' ? 'selected' : '' }}>
                                Semester Genap 25/26</option>
                            <option value="Semester Ganjil 27/28"
                                {{ $pengajuan->keteranganAktif->semester == 'Semester Ganjil 27/28' ? 'selected' : '' }}>
                                Semester Ganjil 27/28</option>
                            <option value="Semester Genap 27/28"
                                {{ $pengajuan->keteranganAktif->semester == 'Semester Genap 27/28' ? 'selected' : '' }}>
                                Semester Genap 27/28</option>
                            <option value="Semester Ganjil 29/30"
                                {{ $pengajuan->keteranganAktif->semester == 'Semester Ganjil 29/30' ? 'selected' : '' }}>
                                Semester Ganjil 29/30</option>
                            <option value="Semester Genap 29/30"
                                {{ $pengajuan->keteranganAktif->semester == 'Semester Genap 29/30' ? 'selected' : '' }}>
                                Semester Genap 29/30</option>
                        </select>
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
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="form-control" name="semester" id="semester" required>
                            <option value="" disabled
                                {{ $pengajuan->pengantarMataKuliah->semester ? '' : 'selected' }}>Pilih Semester</option>
                            <option value="Semester Genap 24/25"
                                {{ $pengajuan->pengantarMataKuliah->semester == 'Semester Genap 24/25' ? 'selected' : '' }}>
                                Semester Genap 24/25</option>
                            <option value="Semester Ganjil 25/26"
                                {{ $pengajuan->pengantarMataKuliah->semester == 'Semester Ganjil 25/26' ? 'selected' : '' }}>
                                Semester Ganjil 25/26</option>
                            <option value="Semester Genap 25/26"
                                {{ $pengajuan->pengantarMataKuliah->semester == 'Semester Genap 25/26' ? 'selected' : '' }}>
                                Semester Genap 25/26</option>
                            <option value="Semester Ganjil 27/28"
                                {{ $pengajuan->pengantarMataKuliah->semester == 'Semester Ganjil 27/28' ? 'selected' : '' }}>
                                Semester Ganjil 27/28</option>
                            <option value="Semester Genap 27/28"
                                {{ $pengajuan->pengantarMataKuliah->semester == 'Semester Genap 27/28' ? 'selected' : '' }}>
                                Semester Genap 27/28</option>
                            <option value="Semester Ganjil 29/30"
                                {{ $pengajuan->pengantarMataKuliah->semester == 'Semester Ganjil 29/30' ? 'selected' : '' }}>
                                Semester Ganjil 29/30</option>
                            <option value="Semester Genap 29/30"
                                {{ $pengajuan->pengantarMataKuliah->semester == 'Semester Genap 29/30' ? 'selected' : '' }}>
                                Semester Genap 29/30</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dataMahasiswa">Data Mahasiswa</label>
                        <div id="mahasiswaContainer">
                            @foreach ($pengajuan->pengantarMataKuliah->mahasiswa as $mahasiswa)
                                <div class="input-group mb-2">
                                    <input type="text" name="namaMahasiswa[]" class="form-control"
                                        placeholder="Nama Mahasiswa" required maxlength="120"
                                        value="{{ $mahasiswa->nama }}">
                                    <input type="text" name="nrpMahasiswa[]" class="form-control"
                                        placeholder="NRP Mahasiswa" required maxlength="9" value="{{ $mahasiswa->nrp }}">
                                    <button type="button" class="btn-danger removeMahasiswa rounded-circle"
                                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-left: 10px;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="tambahMahasiswa" class="btn-primary rounded-circle"
                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="tujuan">Tujuan</label>
                        <textarea class="form-control" name="tujuan" required>{{ $pengajuan->pengantarMataKuliah->tujuan }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="topik">Topik</label>
                        <textarea class="form-control" name="topik" required>{{ $pengajuan->pengantarMataKuliah->topik }}</textarea>
                    </div>
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

                <button type="submit" class="btn-primary"
                    style="margin-bottom: 20px; padding: 7px; border-radius: 10px;">Simpan</button>
            </form>
        </div>
    </main>
@endsection
