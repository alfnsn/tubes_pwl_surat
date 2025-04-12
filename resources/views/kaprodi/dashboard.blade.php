@extends('layouts.indexMahasiswa')

@section('content')
    <main class="main">
        <style>
            .modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 1050;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .modal.show {
                display: block;
                opacity: 1;
            }

            .modal-dialog {
                position: relative;
                margin: 10% auto;
                max-width: 500px;
                background: white;
                border-radius: 5px;
                overflow: hidden;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }
        </style>

        <!-- Hero Section -->
        <section id="hero" class="hero section" style="padding-top: 20px; margin-top: -30px;">
            <div class="container">
                <h2 class="mt-4">Permohonan Pengajuan Surat Keterangan Mahasiswa</h2>
                <table class="table table-bordered text-start" id="dataTable" width="100%" cellspacing="0"
                    style="text-align: center;">
                    <thead>
                        <tr>
                            <th class="text-start">No</th>
                            <th class="text-start">ID Pengajuan</th>
                            <th class="text-start">Diajukan Oleh</th>
                            <th>Tanggal Pengajuan</th>
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
                                </td>
                                <td>{{ \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->format('d - m - Y') }}</td>
                                <td>{{ $pengajuan->jenisSurat->name }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex justify-content-center align-items-center gap-2">
                                        <form id="acceptForm"
                                            action="{{ route('pengajuan-accept', $pengajuan->idpengajuan) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="button"
                                                class="d-flex align-items-center justify-content-center rounded-circle"
                                                style="width: 42px; height: 42px; background-color: #28a745; color: white; border: none;"
                                                onclick="openAcceptModal({{ $pengajuan->idpengajuan }})">
                                                <i class="fas fa-check" style="font-size: 20px; line-height: 1;"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('pengajuan-reject', $pengajuan->idpengajuan) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="button"
                                                class="d-flex align-items-center justify-content-center rounded-circle"
                                                style="width: 42px; height: 42px; background-color: #dc3545; color: white; border: none;"
                                                onclick="openRejectModal({{ $pengajuan->idpengajuan }})">
                                                <i class="fas fa-times" style="font-size: 20px; line-height: 1;"></i>
                                            </button>
                                        </form>
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
        </section>

        <!-- Modal Alasan Penolakan -->
        <div class="modal" id="rejectModal" onclick="closeModalOnOutsideClick(event, 'rejectModal')">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectModalLabel">Alasan Penolakan</h5>
                        <button type="button" class="btn-close" onclick="closeModal('rejectModal')"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="rejectForm" method="POST" action="{{ route('Kaprodi.dashboard') }}">
                            @csrf
                            <input type="hidden" name="id_pengajuan" id="rejectPengajuanId">
                            <div class="mb-3">
                                <label for="alasan_penolakan" class="form-label">Alasan Penolakan</label>
                                <textarea class="form-control" name="alasan_penolakan" id="alasan_penolakan" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger">Tolak Pengajuan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Konfirmasi Penerimaan -->
        <div class="modal" id="acceptModal" onclick="closeModalOnOutsideClick(event, 'acceptModal')">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="acceptModalLabel">Konfirmasi Penerimaan</h5>
                        <button type="button" class="btn-close" onclick="closeModal('acceptModal')"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menerima pengajuan ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('acceptModal')">Batal</button>
                        <button type="submit" form="acceptForm" class="btn btn-success">Terima</button>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <script>
        function openRejectModal(id) {
            const modal = document.getElementById('rejectModal');
            document.getElementById('rejectPengajuanId').value = id;
            document.getElementById('rejectForm').action = "/kaprodi/dashboard/pengajuan-reject/" + id;
            resetModal(modal);
            modal.classList.add('show');
        }

        function openAcceptModal(id) {
            const modal = document.getElementById('acceptModal');
            document.getElementById('acceptForm').action = "/kaprodi/dashboard/pengajuan-accept/" + id;
            resetModal(modal);
            modal.classList.add('show');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300); 
        }

        function closeModalOnOutsideClick(event, modalId) {
            const modal = document.getElementById(modalId);
            if (event.target === modal) {
                closeModal(modalId);
            }
        }

        function resetModal(modal) {
            modal.style.display = 'block'; 
            modal.offsetHeight; 
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
