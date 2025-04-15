@extends('layouts.indexMahasiswa')

@section('content')
    <div class="container" style="min-height: 70vh;">
        <h1 class="mt-4" style="color: #124265;">Detail Pengajuan</h1>
        <table class="table table-bordered table-sm mx-auto mt-5" style="width: 80%;">
            <tbody>
                <tr>
                    <th width="40%">ID Pengajuan</th>
                    <td>{{ $pengajuan->idpengajuan }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pengajuan</th>
                    <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d - m - Y') }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $pengajuan->status }}</td>
                </tr>
                <tr>
                    <th>Jenis Surat</th>
                    <td>{{ $pengajuan->jenisSurat->name }}</td>
                </tr>

                @if ($pengajuan->pengantarMataKuliah)
                    <tr>
                        <th>Ditujukan Kepada</th>
                        <td>{{ $pengajuan->pengantarMataKuliah->ditujukan }}</td>
                    </tr>
                    <tr>
                        <th>Nama Kode MMata Kuliah</th>
                        <td>{{ $pengajuan->pengantarMataKuliah->nama_kode_mk }}</td>
                    </tr>
                    <tr>
                        <th>Semester</th>
                        <td>{{ $pengajuan->pengantarMataKuliah->semester }}</td>
                    </tr>
                    @if ($pengajuan->pengantarMataKuliah->mahasiswa->isNotEmpty())
                        <tr>
                            <th rowspan="{{ $pengajuan->pengantarMataKuliah->mahasiswa->count() }}">Data Mahasiswa</th>
                            @foreach ($pengajuan->pengantarMataKuliah->mahasiswa as $data => $mahasiswa)
                                @if ($data > 0)
                        <tr>
                    @endif
                    <td>{{ $mahasiswa->nama }} - {{ $mahasiswa->nrp }}</td>
                    </tr>
                @endforeach
                </tr>
                @endif
                <tr>
                    <th>Tujuan</th>
                    <td>{{ $pengajuan->pengantarMataKuliah->tujuan }}</td>
                </tr>
                <tr>
                    <th>Topik</th>
                    <td>{{ $pengajuan->pengantarMataKuliah->topik }}</td>
                </tr>
                @endif

                @if ($pengajuan->keteranganAktif)
                    <tr>
                        <th>Semester</th>
                        <td>{{ $pengajuan->keteranganAktif->semester }}</td>
                    </tr>
                    <tr>
                        <th>Alamat Bandung</th>
                        <td>{{ $pengajuan->keteranganAktif->alamat_bandung }}</td>
                    </tr>
                    <tr>
                        <th>Keperluan</th>
                        <td>{{ $pengajuan->keteranganAktif->keperluan_pengajuan }}</td>
                    </tr>
                @endif

                @if ($pengajuan->keteranganLulus)
                    <tr>
                        <th>Tanggal Kelulusan</th>
                        <td>{{ \Carbon\Carbon::parse($pengajuan->keteranganLulus->tanggal_kelulusan)->format('d-m-Y') }}
                        </td>
                    </tr>
                @endif

                @if ($pengajuan->laporanHasilStudi)
                    <tr>
                        <th>Keperluan Laporan Studi</th>
                        <td>{{ $pengajuan->laporanHasilStudi->keperluan_pembuatan }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Download Template Surat</th>
                    <td>
                        <a onclick="downloadFile('{{ asset('assets/TemplateJadi/' . $pengajuan->path_template) }}')"
                            class="d-flex align-items-center justify-content-center rounded-circle"
                            style="width: 42px; height: 42px; background-color: #28a745; color: white; border: none; cursor: pointer;">
                            <i class="fas fa-download" style="font-size: 20px; line-height: 1;"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>Upload Surat</th>
                    <td>
                        <form action="{{ route('pengajuan-upload', $pengajuan->idpengajuan) }}" method="POST"
                            class="d-inline" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="file" id="fileInput" class="d-none" required
                                onchange="updateFileName(this)" />

                            <label for="fileInput"
                                class="btn btn-secondary rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px; cursor: pointer;">
                                <i class="fas fa-paperclip" style="font-size: 20px; line-height: 1;"></i>
                            </label>

                            <span id="fileName" class="text-muted" style="display: none; font-size: 14px;"></span>

                            <button type="submit" class="d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 42px; height: 42px; background-color: #0d6efd; color: white; border: none;">
                                <i class="fas fa-upload" style="font-size: 20px; line-height: 1;"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>

        <h3 class="mt-4" style="color: #124265;">Data Mahasiswa Pemohon</h3>
        <table class="table table-bordered table-sm mx-auto mt-5" style="width: 80%;">
            <tbody>
                <tr>
                    <th width="40%">Nama</th>
                    <td>{{ $pengajuan->user->name }}</td>
                </tr>
                <tr>
                    <th width="40%">NRP</th>
                    <td>{{ $pengajuan->user->id }}</td>
                </tr>
                <tr>
                    <th width="40%">Alamat</th>
                    <td>{{ $pengajuan->user->address }}</td>
                </tr>
                <tr>
                    <th width="40%">No Telepon</th>
                    <td>{{ $pengajuan->user->phone }}</td>
                </tr>
                <tr>
                    <th width="40%">Email</th>
                    <td>{{ $pengajuan->user->email }}</td>
                </tr>
                <tr>
                    <th width="40%">Status</th>
                    <td>{{ $pengajuan->user->status }}</td>
                </tr>
                <tr>
                    <th width="40%">Program Studi</th>
                    <td>{{ $pengajuan->user->studyProgram->nama }}</td>
                </tr>

            </tbody>
        </table>
        {{-- <div class="d-flex justify-content-end mt-3 mb-3">
            <a href="{{ route('Kaprodi.dashboard') }}" class="btn btn-primary" style="border-radius: 10px;">Back</a>
        </div> --}}
    </div>
@endsection
