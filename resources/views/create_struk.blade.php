@extends('layouts.app')

@section('content')
    <div class="container py-4 py-md-5">
        <form id="formStruk" action="{{ route('struk.store') }}" method="POST">
            @csrf
            <input type="hidden" name="overwrite" id="overwrite_flag" value="no">
            <input type="hidden" name="mode_cetak_saja" id="mode_cetak_saja" value="no">

            <div
                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-end mb-4 gap-3">
                <div>
                    <h2 class="fw-bold mb-1 fs-3 fs-md-2 text-dark">Input Tagihan Listrik</h2>
                    <p class="text-muted mb-0 small">Periode Tagihan:
                        <span class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $periode }}</span>
                    </p>
                    <input type="hidden" name="periode" value="{{ $periode }}">
                </div>

                <div class="card p-3 bg-white shadow-sm border-0 w-100 w-md-auto"
                    style="min-width: 250px; border-radius: 12px;">
                    <label class="small fw-bold text-muted mb-2">BIAYA ADMIN GLOBAL (RP)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">Rp</span>
                        <input type="text" name="admin_global_display"
                            class="form-control border-start-0 fw-bold text-primary input-currency" placeholder="0"
                            data-target="admin_global_raw"
                            value="{{ $admin > 0 ? number_format($admin, 0, ',', '.') : '' }}" required>
                        <input type="hidden" name="admin_global" id="admin_global_raw" value="{{ $admin }}">
                    </div>
                </div>
            </div>

            <div class="card overflow-hidden border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="d-none d-md-table-header-group">
                            <tr class="table-light">
                                <th class="ps-4 py-3 text-muted small fw-bold">PELANGGAN</th>
                                <th class="text-muted small fw-bold">TARIF / DAYA</th>
                                <th class="pe-4 text-muted small fw-bold" width="300">NOMINAL TAGIHAN (RP)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggan as $p)
                                @php
                                    $dataMutasi = $p->mutasi->where('periode', $periode)->first();
                                    $nominalAwal = $dataMutasi ? $dataMutasi->tagihan : 0;
                                @endphp

                                <tr class="responsive-row">
                                    <td class="ps-4 py-3">
                                        <div class="fw-bold mb-0 text-dark">{{ $p->nama }}</div>
                                        <small class="text-muted">IDPEL: {{ $p->idpel }}</small>
                                        <div class="d-md-none mt-2">
                                            <span
                                                class="badge bg-light text-dark border rounded-pill">{{ $p->tarif_daya }}</span>
                                        </div>
                                    </td>
                                    <td class="d-none d-md-table-cell text-center text-md-start">
                                        <span
                                            class="badge bg-light text-dark border rounded-pill px-3">{{ $p->tarif_daya }}</span>
                                    </td>
                                    <td class="pe-4 py-3">
                                        <label class="small fw-bold text-muted d-md-none mb-1">NOMINAL TAGIHAN</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 text-muted">Rp</span>
                                            <input type="text"
                                                class="form-control border-start-0 bg-white input-currency fw-bold text-primary"
                                                placeholder="0"
                                                value="{{ $nominalAwal > 0 ? number_format($nominalAwal, 0, ',', '.') : '' }}"
                                                data-target="real-{{ $p->idpel }}">

                                            <input type="hidden" name="tags[{{ $p->idpel }}]"
                                                id="real-{{ $p->idpel }}" value="{{ $nominalAwal }}">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row justify-content-center g-3 mt-4">
                <div class="col-12 col-md-6 col-lg-4">
                    <button type="button" onclick="confirmSave()"
                        class="btn btn-primary w-100 py-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 btn-action rounded-3">
                        <i class="bi bi-cloud-arrow-up-fill fs-5"></i> Simpan & Cetak
                    </button>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <button type="button" onclick="submitDirect()"
                        class="btn btn-outline-primary w-100 py-3 fw-semibold d-flex align-items-center justify-content-center gap-2 btn-action rounded-3">
                        <i class="bi bi-printer fs-5"></i> Langsung Cetak
                    </button>
                </div>

                <div class="col-12 text-center mt-3">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-center gap-2 gap-md-3">
                        <a href="{{ route('struk.index') }}"
                            class="btn btn-link text-muted text-decoration-none fw-medium py-2">
                            <i class="bi bi-arrow-left-circle me-1"></i> Kembali ke Daftar
                        </a>
                        <span class="d-none d-md-inline text-light-emphasis opacity-25">|</span>
                        <small class="text-secondary py-2">
                            Total baris: <span class="fw-bold text-dark">{{ count($pelanggan) }} data</span>
                        </small>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // SweetAlert Notifikasi
            const errorMessage = @json(session('error'));
            const successMessage = @json(session('success'));
            if (errorMessage) Swal.fire({
                title: 'Gagal',
                text: errorMessage,
                icon: 'error'
            });
            if (successMessage) Swal.fire({
                title: 'Berhasil',
                text: successMessage,
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });

            // Currency Input Handling
            const currencyInputs = document.querySelectorAll('.input-currency');
            currencyInputs.forEach(input => {
                input.addEventListener('input', function() {
                    let value = this.value.replace(/[^0-9]/g, '');
                    this.value = value ? formatRupiah(value) : "";
                    const targetId = this.getAttribute('data-target');
                    if (targetId) document.getElementById(targetId).value = value;
                });
            });

            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        });

        // Form Submission Logic
        function submitDirect() {
            Swal.fire({
                title: 'Cetak Sekarang?',
                text: "Sistem akan mencetak data yang sudah tersimpan di database.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Cetak!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('mode_cetak_saja').value = 'yes';
                    document.getElementById('formStruk').submit();
                }
            });
        }

        function confirmSave() {
            let hasValue = false;
            document.querySelectorAll('input[name^="tags"]').forEach(input => {
                if (input.value > 0) hasValue = true;
            });

            if (!hasValue) {
                Swal.fire('Perhatian', 'Isi minimal satu nominal tagihan untuk menyimpan.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Simpan & Cetak?',
                text: "Data baru akan disimpan dan menggantikan data lama periode ini.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                confirmButtonText: 'Ya, Simpan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('mode_cetak_saja').value = 'no';
                    document.getElementById('overwrite_flag').value = 'yes';
                    document.getElementById('formStruk').submit();
                }
            });
        }
    </script>
@endsection
