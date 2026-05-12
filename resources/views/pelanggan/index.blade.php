@extends('layouts.app')

@section('content')
    <div class="container py-10">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1 text-dark">Master Pelanggan</h2>
                <p class="text-muted mb-0">Kelola daftar pelanggan tetap untuk tagihan bulanan.</p>
            </div>
            <button type="button" class="btn btn-primary shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-person-plus-fill me-2"></i>Tambah Pelanggan
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        <!-- Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted" width="80">NO</th>
                                <th class="text-muted">ID PELANGGAN</th>
                                <th class="text-muted">NAMA LENGKAP</th>
                                <th class="text-muted">TARIF / DAYA</th>
                                <th class="text-muted">STAND METER</th>
                                <th class="text-center pe-4 text-muted">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelanggan as $key => $p)
                                <tr>
                                    <td class="ps-4 text-muted small">{{ $pelanggan->firstItem() + $key }}</td>
                                    <td><code class="fw-bold text-primary fs-6">{{ $p->idpel }}</code></td>
                                    <td class="fw-semibold text-dark">{{ $p->nama }}</td>
                                    <td>
                                        <span
                                            class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">
                                            {{ $p->tarif_daya }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">{{ $p->stand_meter ?? '-' }}</td>
                                    <td class="text-center pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-light btn-sm rounded-circle" data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                                <li><a class="dropdown-item text-danger" href="#"><i
                                                            class="bi bi-trash me-2"></i>Hapus</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <img src="https://illustrations.popsy.co/gray/not-found.svg" alt="empty"
                                            style="width: 150px;" class="mb-3">
                                        <p class="text-muted">Belum ada data pelanggan terdaftar.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-4 d-flex justify-content-center">
                {{ $pelanggan->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Multi-Input Modern -->
    <!-- Modal Multi-Input Modern -->
    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered"> <!-- Gunakan xl agar lebih luas -->
            <form action="{{ route('pelanggan.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold text-dark pt-3 ps-3">Daftarkan Pelanggan Baru</h5>
                    <button type="button" class="btn-close me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle">
                            <thead>
                                <tr class="text-muted small">
                                    <th width="15%">IDPEL</th>
                                    <th width="25%">NAMA</th>
                                    <th width="20%">TARIF/DAYA</th>
                                    <th width="30%">STAND METER</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                            <tbody id="wrapper-pelanggan">
                                <tr class="row-pelanggan">
                                    <td>
                                        <input type="text" name="pelanggan[0][idpel]"
                                            class="form-control bg-light border-0" placeholder="5130..." required>
                                    </td>
                                    <td>
                                        <input type="text" name="pelanggan[0][nama]"
                                            class="form-control bg-light border-0" placeholder="Nama Lengkap" required>
                                    </td>
                                    <td>
                                        <input type="text" name="pelanggan[0][tarif_daya]"
                                            class="form-control bg-light border-0" placeholder="R1/450 VA" required>
                                    </td>
                                    <td>
                                        <input type="text" name="pelanggan[0][stand_meter]"
                                            class="form-control bg-light border-0" placeholder="00015875-00015965">
                                    </td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-primary btn-add">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 me-2" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-5 shadow-sm">Simpan Pelanggan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let i = 1;
            const wrapper = document.getElementById('wrapper-pelanggan');

            wrapper.addEventListener('click', function(e) {
                if (e.target.closest('.btn-add')) {
                    // Menambahkan baris baru dengan struktur tabel yang sama agar tetap sejajar
                    let newRow = `
                    <tr class="row-pelanggan">
                        <td>
                            <input type="text" name="pelanggan[${i}][idpel]" class="form-control bg-light border-0" placeholder="5130..." required>
                        </td>
                        <td>
                            <input type="text" name="pelanggan[${i}][nama]" class="form-control bg-light border-0" placeholder="Nama Lengkap" required>
                        </td>
                        <td>
                            <input type="text" name="pelanggan[${i}][tarif_daya]" class="form-control bg-light border-0" placeholder="R1/450 VA" required>
                        </td>
                        <td>
                            <input type="text" name="pelanggan[${i}][stand_meter]" class="form-control bg-light border-0" placeholder="00015875-00015965">
                        </td>
                        <td class="text-end">
                            <button type="button" class="btn btn-soft-danger btn-remove">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                    wrapper.insertAdjacentHTML('beforeend', newRow);
                    i++;
                }

                if (e.target.closest('.btn-remove')) {
                    e.target.closest('.row-pelanggan').remove();
                }
            });
        });
    </script>

    <style>
        .btn-soft-danger {
            background-color: #fee2e2;
            color: #ef4444;
            border: none;
        }

        .btn-soft-danger:hover {
            background-color: #fecaca;
            color: #dc2626;
        }

        .modal-content {
            overflow: hidden;
        }

        .form-control:focus {
            background-color: #fff !important;
        }
    </style>
@endsection
