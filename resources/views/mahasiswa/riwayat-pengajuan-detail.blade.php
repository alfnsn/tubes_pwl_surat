@extends('layouts.indexMahasiswa')

@section('content')
    <div class="container" style="min-height: 70vh;">
        <h1 class="mt-4" style="color: #124265;">Detail Pengajuan</h1>

        <table class="table table-bordered table-sm mx-auto mt-5" style="width: 60%;">
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
            </tbody>
        </table>

        <div class="container mt-4">
            <h4>Status Pengajuan</h4>
            <div class="progress" style="height: 30px;">
                <div class="progress-bar 
                    @if($pengajuan->status == 'Pending') bg-warning
                    @elseif($pengajuan->status == 'Diproses') bg-primary
                    @elseif($pengajuan->status == 'Accepted') bg-success
                    @elseif($pengajuan->status == 'Rejected') bg-danger
                    @endif" role="progressbar" style="width: 
                    @if($pengajuan->status == 'Pending') 25%
                    @elseif($pengajuan->status == 'Diproses') 50%
                    @elseif($pengajuan->status == 'Accepted') 100%
                    @elseif($pengajuan->status == 'Rejected') 100%
                    @endif;">
                    {{ $pengajuan->status }}
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3 mb-3">
            <a href="{{ route('riwayat-pengajuan') }}" class="btn btn-primary" style="border-radius: 10px;">Back</a>
        </div>
        @if($pengajuan->surat)
            <div class="text-center mt-4">
                <a href="{{ asset('assets/surat/' . $pengajuan->surat->file_path) }}" class="btn btn-primary" download>
                    Download Surat
                </a>
            </div>
        @endif
    </div>
@endsection