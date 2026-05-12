@extends('layouts.app')

@section('content')
    <div class="container py-4 py-md-5">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div class="flex-grow-1">
                <h2 class="fw-bold mb-1 text-dark fs-3 fs-md-2">Master Pelanggan</h2>
                <p class="text-muted mb-0 small">Kelola daftar pelanggan tetap untuk tagihan bulanan.</p>
            </div>

            <div class="w-100 w-md-auto text-end">
                <button type="button"
                    class="btn btn-primary shadow-sm px-4 py-2 w-100 w-md-auto d-inline-flex align-items-center justify-content-center"
                    data-bs-toggle="modal" data-bs-target="#modalTambah">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    <span class="fw-semibold">Tambah Pelanggan</span>
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr class="small text-uppercase">
                                <th class="ps-4 py-3 text-muted" width="60">NO</th>
                                <th class="text-muted" style="min-width: 140px;">ID PELANGGAN</th>
                                <th class="text-muted" style="min-width: 200px;">NAMA LENGKAP</th>
                                <th class="text-muted" style="min-width: 120px;">TARIF/DAYA</th>
                                <th class="text-muted" style="min-width: 150px;">STAND METER</th>
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
                                            <button class="btn btn-light btn-sm rounded-circle p-2"
                                                data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3">
                                                <li><a class="dropdown-item text-danger py-2" href="#"><i
                                                            class="bi bi-trash me-2"></i>Hapus</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <img src="https://illustrations.popsy.co/gray/not-found.svg" alt="empty"
                                            style="width: 120px;" class="mb-3">
                                        <p class="text-muted small">Belum ada data pelanggan terdaftar.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-4 d-flex justify-content-center border-0">
                {{ $pelanggan->links() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <form action="{{ route('pelanggan.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
                @csrf
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold text-dark mb-0">Daftarkan Pelanggan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted small d-md-none mb-3"><i class="bi bi-info-circle me-1"></i> Geser ke samping untuk
                        mengisi semua kolom.</p>

                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead class="d-none d-md-table-header-group">
                                <tr class="text-muted small">
                                    <th width="20%">IDPEL</th>
                                    <th width="30%">NAMA</th>
                                    <th width="20%">TARIF/DAYA</th>
                                    <th width="25%">STAND METER</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody id="wrapper-pelanggan">
                                <tr class="row-pelanggan border-bottom-mobile">
                                    <td class="pb-3 pb-md-2">
                                        <label class="small fw-bold text-muted d-md-none mb-1">IDPEL</label>
                                        <input type="text" name="pelanggan[0][idpel]"
                                            class="form-control bg-light border-0 py-2" placeholder="5130..." required>
                                    </td>
                                    <td class="pb-3 pb-md-2">
                                        <label class="small fw-bold text-muted d-md-none mb-1">NAMA</label>
                                        <input type="text" name="pelanggan[0][nama]"
                                            class="form-control bg-light border-0 py-2" placeholder="Nama Lengkap" required>
                                    </td>
                                    <td class="pb-3 pb-md-2">
                                        <label class="small fw-bold text-muted d-md-none mb-1">TARIF/DAYA</label>
                                        <input type="text" name="pelanggan[0][tarif_daya]"
                                            class="form-control bg-light border-0 py-2" placeholder="R1/450 VA" required>
                                    </td>
                                    <td class="pb-3 pb-md-2">
                                        <label class="small fw-bold text-muted d-md-none mb-1">STAND METER</label>
                                        <input type="text" name="pelanggan[0][stand_meter]"
                                            class="form-control bg-light border-0 py-2" placeholder="Awal-Akhir">
                                    </td>
                                    <td class="text-end text-md-center">
                                        <button type="button" class="btn btn-primary btn-add rounded-circle shadow-sm">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0 d-flex flex-column flex-md-row gap-2">
                    <button type="button" class="btn btn-light px-4 w-100 w-md-auto"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-5 shadow-sm w-100 w-md-auto">Simpan
                        Pelanggan</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Perbaikan Header Table agar tidak pecah di mobile */
        .table th {
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .btn-soft-danger {
            background-color: #fee2e2;
            color: #ef4444;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-add {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Responsive Modal Helper */
        @media (max-width: 767.98px) {
            .border-bottom-mobile {
                border-bottom: 2px solid #f1f5f9;
                display: block;
                padding-bottom: 1rem;
                margin-bottom: 1.5rem;
            }

            .modal-body .table-responsive {
                overflow-x: visible;
            }

            .modal-body td {
                display: block;
                width: 100% !important;
                padding: 0.5rem 0;
            }
        }

        .form-control:focus {
            background-color: #fff !important;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.15);
            border: 1px solid var(--bs-primary) !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let i = 1;
            const wrapper = document.getElementById('wrapper-pelanggan');

            wrapper.addEventListener('click', function(e) {
                const addBtn = e.target.closest('.btn-add');
                const removeBtn = e.target.closest('.btn-remove');

                if (addBtn) {
                    let newRow = `
                    <tr class="row-pelanggan border-bottom-mobile">
                        <td class="pb-3 pb-md-2">
                            <label class="small fw-bold text-muted d-md-none mb-1">IDPEL</label>
                            <input type="text" name="pelanggan[${i}][idpel]" class="form-control bg-light border-0 py-2" placeholder="5130..." required>
                        </td>
                        <td class="pb-3 pb-md-2">
                            <label class="small fw-bold text-muted d-md-none mb-1">NAMA</label>
                            <input type="text" name="pelanggan[${i}][nama]" class="form-control bg-light border-0 py-2" placeholder="Nama Lengkap" required>
                        </td>
                        <td class="pb-3 pb-md-2">
                            <label class="small fw-bold text-muted d-md-none mb-1">TARIF/DAYA</label>
                            <input type="text" name="pelanggan[${i}][tarif_daya]" class="form-control bg-light border-0 py-2" placeholder="R1/450 VA" required>
                        </td>
                        <td class="pb-3 pb-md-2">
                            <label class="small fw-bold text-muted d-md-none mb-1">STAND METER</label>
                            <input type="text" name="pelanggan[${i}][stand_meter]" class="form-control bg-light border-0 py-2" placeholder="Awal-Akhir">
                        </td>
                        <td class="text-end text-md-center">
                            <button type="button" class="btn btn-soft-danger btn-remove">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>`;
                    wrapper.insertAdjacentHTML('beforeend', newRow);
                    i++;
                }

                if (removeBtn) {
                    e.target.closest('.row-pelanggan').remove();
                }
            });
        });
    </script>
@endsection
