@extends('layouts.indexMahasiswa')

@section('content')
    <div class="container" style="min-height: 70vh;">
        <h1 class="mt-4" style="color: #124265;">Detail Pengajuan</h1>

        <div class="container mt-4">
            <h4 style="margin-top: 80px !important;">Status</h4>
            <div class="progress-section">
                <ul class="timeline">
                    <li class="@if($pengajuan->status == 'Menunggu Persetujuan Kaprodi') active @else not-active @endif" style="--accent-color:#FBCA3E">
                        <div class="date">Pending</div>
                        @if($pengajuan->status == 'Menunggu Persetujuan Kaprodi')
                            <div class="status-text">Menunggu Persetujuan Kaprodi</div>
                        @endif
                    </li>
                    <li class="@if($pengajuan->status == 'Disetujui Oleh Kaprodi') active @elseif($pengajuan->status == 'Surat Telah Selesai Dibuat') not-active @elseif($pengajuan->status == 'Menunggu Persetujuan Kaprodi' || $pengajuan->status == 'Ditolak Oleh Kaprodi') pending @endif" style="--accent-color:#4CADAD">
                        <div class="date">Accepted</div>
                        @if($pengajuan->status == 'Disetujui Oleh Kaprodi')
                            <div class="status-text">Disetujui Oleh Kaprodi, Surat Sedang Dibuat oleh MO</div>
                        @endif
                    </li>
                    <li class="@if($pengajuan->status == 'Ditolak Oleh Kaprodi') active @else pending @endif" style="--accent-color:#E24A68">
                        <div class="date">Rejected</div>
                        @if($pengajuan->status == 'Ditolak Oleh Kaprodi')
                            <div class="status-text">Ditolak Oleh Kaprodi</div>
                        @endif
                    </li>
                    <li class="@if($pengajuan->status == 'Surat Telah Selesai Dibuat') active @else pending @endif" style="--accent-color:#1B5F8C">
                        <div class="date">Surat Telah Selesai Dibuat</div>
                        @if($pengajuan->status == 'Surat Telah Selesai Dibuat')
                            <div class="status-text">Silahkan Download Surat Di Bawah</div>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        <table class="table table-bordered table-sm mx-auto mt-5" style="width: 80%; margin-top: 120px !important;">
            <tbody>
                <tr>
                    <th width="40%">ID Pengajuan</th>
                    <td>{{$pengajuan->idpengajuan}}</td>
                </tr>
                <tr>
                    <th>Tanggal Pengajuan</th>
                    <td>{{\Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d - m - Y')}}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{$pengajuan->status}}</td>
                </tr>
                @if($pengajuan->alasan_penolakan)
                    <tr>
                        <th class="text-danger">Alasan Penolakan</th>
                        <td class="text-danger">{{$pengajuan->alasan_penolakan}}</td>
                    </tr>
                @endif
                <tr>
                    <th>Jenis Surat</th>
                    <td>{{$pengajuan->jenisSurat->name}}</td>
                </tr>

                @if($pengajuan->pengantarMataKuliah)
                    <tr>
                        <th>Ditujukan Kepada</th>
                        <td>{{$pengajuan->pengantarMataKuliah->ditujukan}}</td>
                    </tr>
                    <tr>
                        <th>Nama Kode MMata Kuliah</th>
                        <td>{{$pengajuan->pengantarMataKuliah->nama_kode_mk}}</td>
                    </tr>
                    <tr>
                        <th>Semester</th>
                        <td>{{$pengajuan->pengantarMataKuliah->semester}}</td>
                    </tr>
                    @if($pengajuan->pengantarMataKuliah->mahasiswa->isNotEmpty())
                        <tr>
                            <th rowspan="{{$pengajuan->pengantarMataKuliah->mahasiswa->count()}}">Data Mahasiswa</th>
                            @foreach($pengajuan->pengantarMataKuliah->mahasiswa as $data => $mahasiswa)
                                    @if($data > 0)
                                        <tr>
                                    @endif
                                    <td>{{$mahasiswa->nama}} - {{$mahasiswa->nrp}}</td>
                                </tr>
                            @endforeach
                        </tr>
                    @endif
                    <tr>
                        <th>Tujuan</th>
                        <td>{{$pengajuan->pengantarMataKuliah->tujuan}}</td>
                    </tr>
                    <tr>
                        <th>Topik</th>
                        <td>{{$pengajuan->pengantarMataKuliah->topik}}</td>
                    </tr>
                @endif

                @if($pengajuan->keteranganAktif)
                    <tr>
                        <th>Semester</th>
                        <td>{{$pengajuan->keteranganAktif->semester}}</td>
                    </tr>
                    <tr>
                        <th>Alamat Bandung</th>
                        <td>{{$pengajuan->keteranganAktif->alamat_bandung}}</td>
                    </tr>
                    <tr>
                        <th>Keperluan</th>
                        <td>{{$pengajuan->keteranganAktif->keperluan_pengajuan}}</td>
                    </tr>
                @endif

                @if($pengajuan->keteranganLulus)
                    <tr>
                        <th>Tanggal Kelulusan</th>
                        <td>{{\Carbon\Carbon::parse($pengajuan->keteranganLulus->tanggal_kelulusan)->format('d-m-Y')}}</td>
                    </tr>
                @endif

                @if($pengajuan->laporanHasilStudi)
                    <tr>
                        <th>Keperluan Laporan Studi</th>
                        <td>{{$pengajuan->laporanHasilStudi->keperluan_pembuatan}}</td>
                    </tr>
                @endif
                @if($pengajuan->surat)
                    <tr>
                        <th>Download Surat</th>
                        {{-- <td>
                            <a href="{{ asset('assets/surat/' . $pengajuan->surat->file_path) }}" download 
                                class="d-flex align-items-center justify-content-center rounded-circle"
                                style="width: 42px; height: 42px; background-color: #28a745; color: white; border: none;">
                                <i class="fas fa-download" style="font-size: 20px; line-height: 1;"></i>
                            </a>
                        </td> --}}
                        <td>
                            <a onclick="downloadFile('{{ asset('assets/surat/' . $pengajuan->surat->file_path) }}')" 
                               class="d-flex align-items-center justify-content-center rounded-circle"
                               style="width: 42px; height: 42px; background-color: #28a745; color: white; border: none; cursor: pointer;">
                                <i class="fas fa-download" style="font-size: 20px; line-height: 1;"></i>
                            </a>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
@endsection