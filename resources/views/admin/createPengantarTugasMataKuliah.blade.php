@extends('layouts.indexAdmin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-2 text-gray-800">Create Pengantar Tugas Mata Kuliah</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="post" action="{{ route('admin.storePengantarTugasMataKuliah') }}">
                @csrf
                <div class="form-group">
                    <label for="ditujukan">Surat Ditujukan Kepada *</label>
                    <textarea class="form-control @error('ditujukan') is-invalid @enderror" name="ditujukan" id="ditujukan" cols="30" rows="2"
                        placeholder="Informasikan secara lengkap nama, jabatan, nama perusahaan, dan alamat perusahaan (contoh: Ibu Susi Susanti; Kepala Personalia PT. X; Jln. Cibogo no. 10 Bandung)"
                        required maxlength="300">{{ old('ditujukan') }}</textarea>
                    @error('ditujukan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="namaKodeMk">Nama Mata Kuliah - Kode Mata Kuliah *</label>
                    <input type="text" class="form-control @error('namaKodeMk') is-invalid @enderror" name="namaKodeMk" id="namaKodeMk"
                        placeholder="Contoh : Proses Bisnis - IN255" required maxlength="50"
                        pattern="^[A-Za-z0-9\s]+ - [A-Za-z0-9\s]+$"
                        value="{{ old('namaKodeMk') }}">
                    @error('namaKodeMk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="semester">Semester *</label>
                    <select class="form-control @error('semester') is-invalid @enderror" name="semester" id="semester" required>
                        <option value="" disabled {{ old('semester') ? '' : 'selected' }}>Pilih Semester</option>
                        <option value="Semester Genap 24/25" {{ old('semester') == 'Semester Genap 24/25' ? 'selected' : '' }}>Semester Genap 24/25</option>
                        <option value="Semester Ganjil 25/26" {{ old('semester') == 'Semester Ganjil 25/26' ? 'selected' : '' }}>Semester Ganjil 25/26</option>
                        <option value="Semester Genap 25/26" {{ old('semester') == 'Semester Genap 25/26' ? 'selected' : '' }}>Semester Genap 25/26</option>
                        <option value="Semester Ganjil 27/28" {{ old('semester') == 'Semester Ganjil 27/28' ? 'selected' : '' }}>Semester Ganjil 27/28</option>
                        <option value="Semester Genap 27/28" {{ old('semester') == 'Semester Genap 27/28' ? 'selected' : '' }}>Semester Genap 27/28</option>
                        <option value="Semester Ganjil 29/30" {{ old('semester') == 'Semester Ganjil 29/30' ? 'selected' : '' }}>Semester Ganjil 29/30</option>
                        <option value="Semester Genap 29/30" {{ old('semester') == 'Semester Genap 29/30' ? 'selected' : '' }}>Semester Genap 29/30</option>
                    </select>
                    @error('semester')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="dataMahasiswa">Data Mahasiswa *</label>
                    <div id="mahasiswaContainer">
                        <div class="input-group mb-2">
                            <input type="text" name="namaMahasiswa[]" class="form-control @error('namaMahasiswa.*') is-invalid @enderror"
                                placeholder="Nama Mahasiswa" required maxlength="120">
                            <input type="text" name="nrpMahasiswa[]" class="form-control @error('nrpMahasiswa.*') is-invalid @enderror"
                                placeholder="NRP Mahasiswa" required maxlength="9">
                            <button type="button" class="btn btn-danger removeMahasiswa rounded-circle"
                                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-left: 10px;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" id="tambahMahasiswa" class="btn btn-primary rounded-circle"
                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-plus"></i>
                    </button>
                    @error('namaMahasiswa.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @error('nrpMahasiswa.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tujuan">Tujuan *</label>
                    <textarea class="form-control @error('tujuan') is-invalid @enderror" name="tujuan" id="tujuan" cols="30" rows="1"
                        placeholder="Tujuan" required maxlength="200">{{ old('tujuan') }}</textarea>
                    @error('tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="topik">Topik *</label>
                    <textarea class="form-control @error('topik') is-invalid @enderror" name="topik" id="topik" cols="30" rows="1"
                        placeholder="Topik" required maxlength="100">{{ old('topik') }}</textarea>
                    @error('topik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('tambahMahasiswa').addEventListener('click', function () {
        const container = document.getElementById('mahasiswaContainer');
        const newRow = document.createElement('div');
        newRow.classList.add('input-group', 'mb-2');
        newRow.innerHTML = `
            <input type="text" name="namaMahasiswa[]" class="form-control" placeholder="Nama Mahasiswa" required maxlength="120">
            <input type="text" name="nrpMahasiswa[]" class="form-control" placeholder="NRP Mahasiswa" required maxlength="9">
            <button type="button" class="btn btn-danger removeMahasiswa rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; margin-left: 10px;">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(newRow);
    });

    document.getElementById('mahasiswaContainer').addEventListener('click', function (e) {
        if (e.target.classList.contains('removeMahasiswa') || e.target.closest('.removeMahasiswa')) {
            const row = e.target.closest('.input-group');
            row.remove();
        }
    });
</script>
@endsection
