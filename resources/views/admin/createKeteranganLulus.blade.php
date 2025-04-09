@extends('layouts.indexAdmin')
@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Tambah Keterangan Lulus</h1>
        <div class="row">
            <div class="col-lg-12"> <!-- Adjusted width to match createPengguna -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" id="keterangan-lulus" name="keterangan-lulus" action="{{ route('admin.storeKeteranganLulus') }}">
                            @csrf
                            <div class="form-group">
                                <label for="nrp">NRP *</label>
                                <select class="form-control @error('nrp') is-invalid @enderror" name="nrp" id="nrp" required>
                                    <option value="" disabled selected>Pilih NRP Mahasiswa</option>
                                    @foreach($mahasiswa as $user)
                                        <option value="{{ $user->id }}" data-name="{{ $user->name }}" {{ old('nrp') == $user->id ? 'selected' : '' }}>{{ $user->id }}</option>
                                    @endforeach
                                </select>
                                @error('nrp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">Nama Lengkap *</label>
                                <input type="text" class="form-control" name="name" id="name" readonly required>
                            </div>
                            <div class="form-group">
                                <label for="tanggal">Tanggal *</label>
                                <input type="date" class="form-control @error('tanggal') is-invalid @enderror" name="tanggal" id="tanggal" required
                                    max="{{ date('Y-m-d') }}" value="{{ old('tanggal') }}">
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('nrp').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const name = selectedOption.getAttribute('data-name');
            document.getElementById('name').value = name;
        });
    </script>
@endsection
