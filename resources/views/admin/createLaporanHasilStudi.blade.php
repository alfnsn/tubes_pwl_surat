@extends('layouts.indexAdmin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Add Laporan Hasil Studi</h1>
    <form action="{{ route('admin.storeLaporanHasilStudi') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nrp">NRP</label>
            <select name="nrp" id="nrp" class="form-control" required>
                <option value="" disabled selected>Pilih NRP</option>
                @foreach($mahasiswa as $mhs)
                    <option value="{{ $mhs->id }}">{{ $mhs->id }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="name">Nama Mahasiswa</label>
            <input type="text" name="name" id="name" class="form-control" readonly required>
        </div>
        <div class="form-group">
            <label for="keperluan">Keperluan Pembuatan LHS</label>
            <textarea name="keperluan" id="keperluan" class="form-control" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    document.getElementById('nrp').addEventListener('change', function () {
        const selectedNRP = this.value;
        const mahasiswa = @json($mahasiswa);
        const selectedMahasiswa = mahasiswa.find(mhs => mhs.id == selectedNRP);
        document.getElementById('name').value = selectedMahasiswa ? selectedMahasiswa.name : '';
    });
</script>
@endsection
