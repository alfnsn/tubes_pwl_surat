@extends('layouts.indexMahasiswa')

@section('content')
    <main class="main">
        <div class="container">
            <h1 class="mt-4" style="color: #124265">Daftar Pengajuan</h1>
            <div class="table-responsive" style="min-height: 70vh;">
                @if ($pengajuans->isEmpty())
                    <p class="text-center mt-5">No records found.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"
                            style="text-align: center;">
                            <thead>
                                <tr>
                                    <th class="text-start">No</th>
                                    <th class="text-start">ID Pengajuan</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Jenis Surat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($pengajuans as $pengajuan)
                                    <tr>
                                        <td class="text-start">{{ $no++ }}</td>
                                        <td class="text-start">{{ $pengajuan->idpengajuan }}</td>
                                        <td class="text-start">
                                            {{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d - m - Y') }}
                                        </td>
                                        @if ($pengajuan->status == 'Ditolak Oleh Kaprodi')
                                            <td class="text-start text-danger fw-bold">{{ $pengajuan->status }}</td>
                                        @elseif($pengajuan->status == 'Disetujui Oleh Kaprodi')
                                            <td class="text-start text-success fw-bold">{{ $pengajuan->status }}</td>
                                        @elseif($pengajuan->status == 'Surat Telah Selesai Dibuat')
                                            <td class="text-start text-primary fw-bold">{{ $pengajuan->status }}</td>
                                        @else
                                            <td class="text-start text-warning fw-bold">{{ $pengajuan->status }}</td>
                                        @endif
                                        <td class="text-start">{{ $pengajuan->jenisSurat->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('riwayat-pengajuan-detail', $pengajuan->idpengajuan) }}"
                                                class="d-flex align-items-center justify-content-center rounded-circle mx-auto"
                                                style="width: 42px; margin-bottom: 10px; height: 42px; background-color: #1d3557; color: white; text-decoration: none;">
                                                <i class="fas fa-eye" style="font-size: 20px;"></i>
                                            </a>
                                            @if ($pengajuan->status == 'Menunggu Persetujuan Kaprodi')
                                                <a href="{{ route('pengajuan-edit', $pengajuan->idpengajuan) }}"
                                                    class="d-flex align-items-center justify-content-center rounded-circle mx-auto"
                                                    style="width: 42px; height: 42px; background-color: #f4a261; color: white; text-decoration: none;">
                                                    <i class="fas fa-edit" style="font-size: 20px;"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
