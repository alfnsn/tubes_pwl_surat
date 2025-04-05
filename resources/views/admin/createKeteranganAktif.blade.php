@extends('layouts.indexAdmin')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Tambah Keterangan Aktif</h1>
    </div>

    <!-- Form -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="{{ route('admin.storeKeteranganAktif') }}">
                @csrf
                <input type="hidden" name="jenisSurat_idjenisSurat" value="1">

                <div class="form-group">
                    <label for="nrp">NRP *</label>
                    <select class="form-control" name="nrp" id="nrp" required>
                        <option value="" disabled selected>Pilih NRP</option>
                        @foreach($mahasiswa as $mhs)
                            <option value="{{ $mhs->id }}" data-name="{{ $mhs->name }}">{{ $mhs->id }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('nrp'))
                        <small class="text-danger">{{ $errors->first('nrp') }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">Nama Lengkap *</label>
                    <input type="text" class="form-control" name="name" id="name" readonly>
                </div>

                <div class="form-group">
                    <label for="semester">Semester *</label>
                    <select class="form-control" name="semester" id="semester" required>
                        <option value="" disabled selected>Pilih Semester</option>
                        <option value="Semester Genap 24/25">Semester Genap 24/25</option>
                        <option value="Semester Ganjil 25/26">Semester Ganjil 25/26</option>
                        <option value="Semester Genap 25/26">Semester Genap 25/26</option>
                        <option value="Semester Ganjil 27/28">Semester Ganjil 27/28</option>
                        <option value="Semester Genap 27/28">Semester Genap 27/28</option>
                        <option value="Semester Ganjil 29/30">Semester Ganjil 29/30</option>
                        <option value="Semester Genap 29/30">Semester Genap 29/30</option>
                    </select>
                    @if ($errors->has('semester'))
                        <small class="text-danger">{{ $errors->first('semester') }}</small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat Lengkap Mahasiswa di Bandung *</label>
                    <textarea class="form-control" name="alamat" id="alamat" rows="2" required></textarea>
                </div>

                <div class="form-group">
                    <label for="keperluan">Keperluan Pengajuan *</label>
                    <textarea class="form-control" name="keperluan" id="keperluan" rows="2" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('nrp').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const mahasiswaName = selectedOption.getAttribute('data-name');
        document.getElementById('name').value = mahasiswaName || '';
    });
</script>
@endsection