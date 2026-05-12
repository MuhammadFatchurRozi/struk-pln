@extends('layouts.app')

@section('content')
    <div class="container py-4 py-md-5">
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold mb-1 fs-3 fs-md-2">Riwayat Mutasi</h2>
                <p class="text-muted mb-0 small">Kelola data tagihan per periode.</p>
            </div>

            <div class="d-flex gap-2 w-100 w-md-auto">
                <form action="{{ route('struk.index') }}" method="GET" class="flex-grow-1">
                    <select name="filter_periode" class="form-select border-0 shadow-sm" onchange="this.form.submit()">
                        <option value="">Semua Periode</option>
                        @foreach ($list_periode as $lp)
                            <option value="{{ $lp->periode }}"
                                {{ request('filter_periode') == $lp->periode ? 'selected' : '' }}>
                                {{ $lp->periode }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('struk.create') }}" class="btn btn-primary shadow-sm px-3">
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>

        <div class="row g-3 g-md-4 mb-4">
            <div class="col-12 col-md-4">
                <div class="card p-3 p-md-4 border-0 shadow-sm rounded-4 h-100">
                    <small class="text-muted fw-bold">TOTAL DATA</small>
                    <h3 class="fw-bold mb-0 text-primary">{{ $mutasi->total() }}</h3>
                </div>
            </div>

            @if (request('filter_periode'))
                <div class="col-12 col-md-4">
                    <div class="card p-3 p-md-4 border-0 shadow-sm rounded-4 bg-primary text-white h-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75 fw-bold text-uppercase">Cetak Batch</small>
                                <h4 class="fw-bold mb-0">{{ request('filter_periode') }}</h4>
                            </div>
                            <form action="{{ route('struk.store') }}" method="POST" target="_blank">
                                @csrf
                                <input type="hidden" name="mode_cetak_saja" value="yes">
                                <input type="hidden" name="periode" value="{{ request('filter_periode') }}">
                                @foreach ($mutasi as $m)
                                    <input type="hidden" name="tags[{{ $m->pelanggan_id }}]" value="{{ $m->tagihan }}">
                                @endforeach
                                <button type="submit"
                                    class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                    style="width: 45px; height: 45px;">
                                    <i class="bi bi-printer-fill text-primary"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12 col-md-4">
                <div class="card p-3 p-md-4 border-0 shadow-sm rounded-4 bg-success text-white h-100">
                    <small class="opacity-75 fw-bold text-uppercase">
                        Total Tagihan
                    </small>
                    <h3 class="fw-bold mb-0 fs-4 fs-md-3">
                        Rp {{ number_format($total_periode, 0, ',', '.') }}
                    </h3>
                    <small class="opacity-75 d-block mt-1" style="font-size: 0.7rem;">
                        {{ request('filter_periode') ? 'PERIODE ' . request('filter_periode') : 'DARI SEMUA DATA' }}
                    </small>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0 py-3" style="min-width: 200px;">PELANGGAN</th>
                            <th class="text-center border-0 py-3">PERIODE</th>
                            <th class="text-end border-0 py-3">TOTAL</th>
                            <th class="text-center border-0 py-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mutasi as $m)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="fw-bold text-dark">{{ optional($m->pelanggan)->nama }}</div>
                                    <div class="text-muted" style="font-size: 0.8rem;">ID: {{ $m->pelanggan_id }}</div>
                                </td>
                                <td class="text-center">
                                    <span
                                        class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">
                                        {{ $m->periode }}
                                    </span>
                                </td>
                                <td class="text-end fw-bold text-dark">
                                    Rp{{ number_format($m->tagihan + $m->biaya_admin, 0, ',', '.') }}
                                </td>
                                <td class="text-center px-3">
                                    <form action="{{ route('struk.store') }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="hidden" name="mode_cetak_saja" value="yes">
                                        <input type="hidden" name="periode" value="{{ $m->periode }}">
                                        <input type="hidden" name="admin_global" value="{{ $m->biaya_admin }}">
                                        <input type="hidden" name="tags[{{ $m->pelanggan_id }}]"
                                            value="{{ $m->tagihan }}">
                                        <button type="submit"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1">
                                            <i class="bi bi-printer"></i> <span class="d-none d-md-inline ms-1">Cetak</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted italic">Data mutasi tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $mutasi->links() }}
        </div>
    </div>
@endsection
