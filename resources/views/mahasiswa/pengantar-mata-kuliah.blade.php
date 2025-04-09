@extends('layouts.indexMahasiswa')
@section('content')
    <main>
        <div class="content">
            <div class="container">
                <div class="row align-items-stretch no-gutters contact-wrap">
                    <div class="col-md-8">
                        <div class="form h-100">
                            <h3>Pengajuan Surat Pegantar Tugas Mata Kuliah</h3>
                            <form class="mb-5" method="post" id="pengantarMK" name="pengantarMK"
                                action="{{ route('pengajuan') }}">
                                @csrf
                                <input type="hidden" name="idjenisSurat" value="2">
                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="ditujukan" class="col-form-label">Surat Ditujukan Kepada *</label>
                                        <textarea class="form-control" name="ditujukan" id="ditujukan" cols="30" rows="2"
                                            placeholder="Informasikan secara lengkap nama, jabatan, nama perusahaan, dan alamat perusahaan (contoh: Ibu Susi Susanti; Kepala Personalia PT. X; Jln. Cibogo no. 10 Bandung)"
                                            required maxlength="300">{{ old('ditujukan') }}</textarea>
                                        @if ($errors->has('ditujukan'))
                                            <small class="text-danger">{{ $errors->first('ditujukan') }}</small>
                                        @endif
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="namaKodeMk" class="col-form-label">Nama Mata Kuliah - Kode Mata Kuliah
                                            *</label>
                                        <input type="text" class="form-control" name="namaKodeMk" id="namaKodeMk"
                                            placeholder="Contoh : Proses Bisnis - IN255" required maxlength="50"
                                            pattern="^[A-Za-z0-9\s]+ - [A-Za-z0-9\s]+$"
                                            value="{{ old('namaKodeMk') }}">
                                        @if ($errors->has('namaKodeMk'))
                                            <small class="text-danger">{{ $errors->first('namaKodeMk') }}</small>
                                        @endif
                                        <small id="error-msg" class="text-danger" style="display: none;">Tidak boleh CAPS LOCK semua!</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="semester" class="col-form-label">Semester *</label>
                                        <select class="form-control" name="semester" id="semester">
                                            <option value="" disabled selected>Pilih Semester</option>
                                            <option value="Semester Genap 24/25">Semester Genap 24/25</option>
                                            <option value="Semester Ganjil 25/26">Semester Ganjil 25/26</option>
                                            <option value="Semester Genap 25/26">Semester Genap 25/26</option>
                                            <option value="Semester Ganjil 27/28">Semester Ganjil 27/28</option>
                                            <option value="Semester Genap 27/28">Semester Genap 27/28</option>
                                            <option value="Semester Ganjil 29/30">Semester Ganjil 29/30</option>
                                            <option value="Semester Genap 29/30">Semester Genap 29/30</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="dataMahasiswa" class="col-form-label">Data Mahasiswa *</label>
                                        <div id="mahasiswaContainer">
                                            <div class="input-group mb-2">
                                                <input type="text" name="namaMahasiswa[]" class="form-control"
                                                    placeholder="Nama Mahasiswa" required maxlength="120"
                                                    value="{{ old('namaMahasiswa.0') }}">
                                                @if ($errors->has('namaMahasiswa.0'))
                                                    <small class="text-danger">{{ $errors->first('namaMahasiswa.0') }}</small>
                                                @endif
                                                <input type="text" name="nrpMahasiswa[]" class="form-control"
                                                    placeholder="NRP Mahasiswa" required maxlength="9">
                                                <button type="button" class=" btn-danger removeMahasiswa rounded-circle"
                                                    style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-left: 10px;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <button type="button" id="tambahMahasiswa" class=" btn-primary rounded-circle"
                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="tujuan" class="col-form-label">Tujuan *</label>
                                        <textarea class="form-control" name="tujuan" id="tujuan" cols="30" rows="1"
                                            placeholder="Tujuan" required maxlength="200"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="topik" class="col-form-label">Topik *</label>
                                        <textarea class="form-control" name="topik" id="topik" cols="30" rows="1"
                                            placeholder="Topik" required maxlength="100"></textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <input type="submit" value="Kirim" class="btn btn-primary rounded-0 py-2 px-4">
                                        <span class="submitting"></span>
                                    </div>
                                </div>
                            </form>

                            <div id="form-message-warning mt-4"></div>
                            <div id="form-message-success">
                                Your message was sent, thank you!
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-info h-100">
                            <h3>Contact Information</h3>
                            <p class="mb-5">Divisi ..... Universitas Kristen Maranatha</p>
                            <ul class="list-unstyled">
                                <li class="d-flex">
                                    <span class="wrap-icon icon-room mr-3"></span>
                                    <span class="text">Jl. Surya Sumantri No.65, Sukawarna, Kec. Sukajadi, Kota Bandung,
                                        Jawa Barat
                                        40164.</span>
                                </li>
                                <li class="d-flex">
                                    <span class="wrap-icon icon-phone mr-3"></span>
                                    <span class="text">+62 22 - 2012186</span>
                                </li>
                                <li class="d-flex">
                                    <span class="wrap-icon icon-envelope mr-3"></span>
                                    <span class="text">cs@maranatha.edu</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div id="preloader"></div>

@endsection