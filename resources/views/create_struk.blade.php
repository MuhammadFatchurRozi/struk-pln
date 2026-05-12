@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <form id="formStruk" action="{{ route('struk.store') }}" method="POST">
            @csrf
            <input type="hidden" name="overwrite" id="overwrite_flag" value="no">
            <input type="hidden" name="mode_cetak_saja" id="mode_cetak_saja" value="no">

            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Input Tagihan Listrik</h2>
                    <p class="text-muted mb-0">Periode Tagihan: <span
                            class="badge bg-primary-subtle text-primary rounded-pill px-3">{{ $periode }}</span></p>
                    <input type="hidden" name="periode" value="{{ $periode }}">
                </div>

                <div class="card p-3 bg-white shadow-sm border-0" style="min-width: 250px; border-radius: 12px;">
                    <label class="small fw-bold text-muted mb-2">BIAYA ADMIN GLOBAL (RP)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted">Rp</span>
                        <input type="number" name="admin_global"
                            class="form-control border-start-0 fw-bold text-primary input-currency" placeholder="0"
                            data-target="admin_global_raw" value="{{ $admin }}" required>
                    </div>
                </div>
            </div>

            <div class="card overflow-hidden border-0 shadow-sm" style="border-radius: 16px;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="d-none d-md-table-header-group">
                            <tr class="table-light">
                                <th class="ps-4 py-3">PELANGGAN</th>
                                <th>TARIF / DAYA</th>
                                <th class="pe-4" width="300">NOMINAL TAGIHAN (RP)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pelanggan as $p)
                                @php
                                    $dataMutasi = $p->mutasi->first();
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
                                    <td class="d-none d-md-table-cell"> <span
                                            class="badge bg-light text-dark border rounded-pill">{{ $p->tarif_daya }}</span>
                                    </td>
                                    <td class="pe-4 py-3">
                                        <label class="small fw-bold text-muted d-md-none mb-1">NOMINAL TAGIHAN</label>
                                        <div class="input-group shadow-sm-mobile">
                                            <span class="input-group-text bg-white border-end-0">Rp</span>
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
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorMessage = @json(session('error'));
            const successMessage = @json(session('success'));

            if (errorMessage) {
                Swal.fire({
                    title: 'Gagal',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3b82f6',
                });
            }

            if (successMessage) {
                Swal.fire({
                    title: 'Berhasil',
                    text: successMessage,
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    </script>

    <script>
        // Fungsi 1: Simpan dengan Alert Konfirmasi Overwrite
        function submitDirect() {
            // Beri konfirmasi singkat atau langsung jalankan
            Swal.fire({
                title: 'Cetak Periode Ini?',
                text: "Sistem akan mencetak data yang sudah tersimpan di database untuk periode ini.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Cetak Sekarang'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('mode_cetak_saja').value = 'yes';
                    document.getElementById('overwrite_flag').value = 'no';
                    document.getElementById('formStruk').submit();
                }
            });
        }

        function confirmSave() {
            // Validasi apakah ada nominal yang diisi
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
                text: "Data akan disimpan ke database. Jika sudah ada, data lama akan diganti.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                confirmButtonText: 'Ya, Simpan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('mode_cetak_saja').value = 'no';
                    document.getElementById('overwrite_flag').value = 'yes'; // Set yes agar otomatis overwrite
                    document.getElementById('formStruk').submit();
                }
            });
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currencyInputs = document.querySelectorAll('.input-currency');

            currencyInputs.forEach(input => {
                input.addEventListener('input', function(e) {
                    // 1. Ambil angka murni saja
                    let value = this.value.replace(/[^0-9]/g, '');

                    // 2. Format untuk tampilan (dengan titik)
                    if (value !== "") {
                        this.value = formatRupiah(value);
                    } else {
                        this.value = "";
                    }

                    // 3. Simpan angka murni ke input hidden (untuk Laravel)
                    const targetId = this.getAttribute('data-target');
                    if (targetId) {
                        document.getElementById(targetId).value = value;
                    }
                });
            });

            function formatRupiah(angka) {
                let number_string = angka.toString(),
                    sisa = number_string.length % 3,
                    rupiah = number_string.substr(0, sisa),
                    ribuan = number_string.substr(sisa).match(/\d{3}/g);

                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                return rupiah;
            }
        });
    </script>
@endsection
