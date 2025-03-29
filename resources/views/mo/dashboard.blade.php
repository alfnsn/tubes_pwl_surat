@extends('layouts.indexMahasiswa')

@section('content')
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section" style="padding-top: 70px; margin-top: -30px;">
            <div class="container">
                <h2>Permohonan Pengajuan Surat Keterangan Mahasiswa</h2>
                <table class="table table-bordered text-start" id="dataTable" width="100%" cellspacing="0"
                    style="text-align: center;">
                    <thead>
                        <tr>
                            <th class="text-start">No</th>
                            <th class="text-start">ID Pengajuan</th>
                            <th class="text-start">Diajukan Oleh</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Disetujui</th>
                            <th>Disetujui Oleh</th>
                            <th>Jenis Surat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach($pengajuans as $pengajuan)
                            <tr>
                                <td class="text-start">{{$no++}}</td>
                                <td class="text-start">{{$pengajuan->idpengajuan}}</td>
                                <td>{{$pengajuan->user->name}} ({{ $pengajuan->user->id }})
                                </td>
                                <td>{{\Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d - m - Y') }}</td>
                                <td>{{\Carbon\Carbon::parse($pengajuan->updated_at)->format('d - m - Y') }}</td>
                                <td class="text-start">{{$pengajuan->disetujui_oleh}}</td>
                                <td>{{$pengajuan->jenisSurat->name}}</td>
                                <td>
                                    <div class="d-flex flex-column justify-content-center align-items-center gap-2">
                                        <a href="{{ route('pengajuan-detail-mo', $pengajuan->idpengajuan) }}"
                                            class="d-flex align-items-center justify-content-center rounded-circle mt-2"
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
        </section>
    </main>
@endsection