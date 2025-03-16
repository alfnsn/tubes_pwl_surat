@extends('layouts.indexMahasiswa')

@section('content')

<main class="main">
    <div class="container">
        <h1 class="mt-4" style = "color: #124265">Daftar Pengajuan</h1> 
        <div class="table-responsive" style="min-height: 70vh;"> 
            @if($pengajuans->isEmpty())
                <p class="text-center mt-5">No records found.</p>
            @else
                <table class="table table-bordered text-start" id="dataTable" width="100%" cellspacing="0" style="text-align: center;">
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
                                <td>{{\Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d - m - Y') }}</td>
                                @if($pengajuan->status == "Rejected")
                                <td class="text-danger">{{$pengajuan->status}}</td>
                                @else
                                <td>{{$pengajuan->status}}</td>
                                @endif
                                <td>{{$pengajuan->jenisSurat->name}}</td>
                                <td>
                                    <a href="{{ route('riwayat-pengajuan-detail', $pengajuan->idpengajuan) }}" class="btn btn-primary" style = "border-radius: 10px" >View</a>
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
