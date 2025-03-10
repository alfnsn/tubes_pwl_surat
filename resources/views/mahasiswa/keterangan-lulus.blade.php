@extends('layouts.indexMahasiswa')
@section('content')
  <main class="main">
    <div class="content">
    <div class="container">
      <div class="row align-items-stretch no-gutters contact-wrap">
      <div class="col-md-8">
        <div class="form h-100">
        <h3>Pengajuan Surat Keterangan Lulus</h3>
        <form class="mb-5" method="post" id="keterangan-lulus" name="keterangan-lulus"
          action="{{ route('pengajuan') }}">
          @csrf
          <input type="hidden" name="idjenisSurat" value="3">
          <div class="row">
          <div class="col-md-6 form-group mb-5">
            <label for="" class="col-form-label">Nama Lengkap *</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ Auth::user()->name }}"
            readonly style="background-color: white;">
          </div>
          <div class="col-md-6 form-group mb-5">
            <label for="" class="col-form-label">NRP *</label>
            <input type="text" class="form-control" name="nrp" id="nrp" value="{{ Auth::user()->id }}" readonly
            style="background-color: white;">
          </div>
          </div>

          <div class="row">
          <div class="col-md-12 form-group mb-5">
            <label for="tanggal" class="col-form-label">Tanggal *</label>
            <input type="date" class="form-control" name="tanggal" id="tanggal">
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
          <span class="text">Jl. Surya Sumantri No.65, Sukawarna, Kec. Sukajadi, Kota Bandung, Jawa Barat
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