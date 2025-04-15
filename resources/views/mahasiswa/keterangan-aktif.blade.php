@extends('layouts.indexMahasiswa')

@section('content')
    <main class="main">
        <div class="content">
            <div class="container">
                <div class="row align-items-stretch no-gutters contact-wrap">
                    <div class="col-md-8">
                        <div class="form h-100">
                            <h3>Pengajuan Surat Keterangan Mahasiswa Aktif</h3>
                            <form class="mb-5" method="post" id="keterangan-aktif" name="keterangan-aktif"
                                action="{{ route('pengajuan') }}">
                                @csrf
                                <input type="hidden" name="idjenisSurat" value="1">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="" class="col-form-label">Nama Lengkap *</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ Auth::user()->name }}" readonly required maxlength="120">
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="" class="col-form-label">NRP *</label>
                                        <input type="text" class="form-control" name="nrp" id="nrp"
                                            value="{{ Auth::user()->id }}" readonly required maxlength="9">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="semester" class="col-form-label">Semester *</label>
                                        <select class="form-control" name="semester" id="semester">
                                            <option value="" disabled {{ old('semester') ? '' : 'selected' }}>Pilih
                                                Semester</option>
                                            <option value="Semester Genap 24/25"
                                                {{ old('semester') == 'Semester Genap 24/25' ? 'selected' : '' }}>Semester
                                                Genap 24/25</option>
                                            <option value="Semester Ganjil 25/26"
                                                {{ old('semester') == 'Semester Ganjil 25/26' ? 'selected' : '' }}>Semester
                                                Ganjil 25/26</option>
                                            <option value="Semester Genap 25/26"
                                                {{ old('semester') == 'Semester Genap 25/26' ? 'selected' : '' }}>Semester
                                                Genap 25/26</option>
                                            <option value="Semester Ganjil 27/28"
                                                {{ old('semester') == 'Semester Ganjil 27/28' ? 'selected' : '' }}>Semester
                                                Ganjil 27/28</option>
                                            <option value="Semester Genap 27/28"
                                                {{ old('semester') == 'Semester Genap 27/28' ? 'selected' : '' }}>Semester
                                                Genap 27/28</option>
                                            <option value="Semester Ganjil 29/30"
                                                {{ old('semester') == 'Semester Ganjil 29/30' ? 'selected' : '' }}>Semester
                                                Ganjil 29/30</option>
                                            <option value="Semester Genap 29/30"
                                                {{ old('semester') == 'Semester Genap 29/30' ? 'selected' : '' }}>Semester
                                                Genap 29/30</option>
                                        </select>
                                        @if ($errors->has('semester'))
                                            <small class="text-danger">{{ $errors->first('semester') }}</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="alamat" class="col-form-label">Alamat Lengkap Mahasiswa di Bandung
                                            *</label>
                                        <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="1" placeholder="Alamat" required
                                            maxlength="300">{{ old('alamat') }}</textarea>
                                        @if ($errors->has('alamat'))
                                            <small class="text-danger">{{ $errors->first('alamat') }}</small>
                                        @endif
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 form-group mb-5">
                                        <label for="keperluan" class="col-form-label">Keperluan Pengajuan *</label>
                                        <textarea class="form-control" name="keperluan" id="keperluan" cols="30" rows="1"
                                            placeholder="Keperluan Pengajuan" required maxlength="255">{{ old('keperluan') }}</textarea>
                                        @if ($errors->has('keperluan'))
                                            <small class="text-danger">{{ $errors->first('keperluan') }}</small>
                                        @endif
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

                            <div id="preloader"></div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-info h-100">
                            <h3>Contact Information</h3>
                            <p class="mb-5">Divisi Universitas Kristen Maranatha</p>
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
@endsection
