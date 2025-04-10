@extends('layouts.indexMahasiswa')

@section('content')

    <main class="main">
        <div class="container">
            <h1 class="mt-4" style="color: #124265">Daftar Pengajuan</h1>
            <div class="table-responsive" style="min-height: 70vh;">
                @if($pengajuans->isEmpty())
                    <p class="text-center mt-5">No records found.</p>
                @else
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
                            @foreach($pengajuans as $pengajuan)
                                <tr>
                                    <td class="text-start">{{$no++}}</td>
                                    <td class="text-start">{{$pengajuan->idpengajuan}}</td>
                                    <td class="text-start">{{\Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d - m - Y') }}</td>
                                    @if($pengajuan->status == "Rejected")
                                        <td class="text-start text-danger">{{$pengajuan->status}}</td>
                                    @else
                                        <td class="text-start">{{$pengajuan->status}}</td>
                                    @endif
                                    <td class="text-start">{{$pengajuan->jenisSurat->name}}</td>
                                    <td class="text-center">
                                        <a href="{{ route('riwayat-pengajuan-detail', $pengajuan->idpengajuan) }}"
                                            class="d-flex align-items-center justify-content-center rounded-circle mx-auto"
                                            style="width: 42px; height: 42px; background-color: #1d3557; color: white; text-decoration: none;">
                                            <i class="fas fa-eye" style="font-size: 20px;"></i>
                                        </a>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </main>

@endsection