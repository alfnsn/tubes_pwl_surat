@extends('layouts.indexMahasiswa')

@section('content')
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section" style="padding-top: 20px; margin-top: -30px;">
            <div class="container">
                <h2 class="mt-4" style="color: #124265;">Riwayat Pengajuan</h2>
                <div class="table-responsive">"
                    <table class="table table-bordered text-start" id="dataTable" width="100%" cellspacing="0"
                        style="text-align: center;">
                        <thead>
                            <tr>
                                <th class="text-start">No</th>
                                <th class="text-start">ID Pengajuan</th>
                                <th class="text-start">Diajukan Oleh</th>
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
                                    <td>{{ $pengajuan->user->name }} ({{ $pengajuan->user->id }})
                                    <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d - m - Y') }}</td>
                                    @if ($pengajuan->status == 'Ditolak Oleh Kaprodi')
                                        <td class="text-start text-danger fw-bold">{{ $pengajuan->status }}</td>
                                    @elseif($pengajuan->status == 'Disetujui Oleh Kaprodi')
                                        <td class="text-start text-success fw-bold">{{ $pengajuan->status }}</td>
                                    @elseif($pengajuan->status == 'Surat Telah Selesai Dibuat')
                                        <td class="text-start text-primary fw-bold">{{ $pengajuan->status }}</td>
                                    @else
                                        <td class="text-start fw-bold">{{ $pengajuan->status }}</td>
                                    @endif
                                    <td class="text-start">{{ $pengajuan->jenisSurat->name }}</td>
                                    <td class="text-nowrap">
                                        <div class="d-flex justify-content-center align-items-center gap-2">
                                            <a href="{{ route('pengajuan-detail', $pengajuan->idpengajuan) }}"
                                                class="d-flex align-items-center justify-content-center rounded-circle"
                                                style="width: 42px; height: 42px; background-color: #1d3557; color: white; text-decoration: none;">
                                                <i class="fas fa-eye" style="font-size: 20px; line-height: 1;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
@endsection
