@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-1">Riwayat Mutasi</h2>
                <p class="text-muted">Kelola data tagihan per periode.</p>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('struk.index') }}" method="GET" class="d-flex gap-2">
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
                <a href="{{ route('struk.create') }}" class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg"></i></a>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm rounded-4">
                    <small class="text-muted fw-bold">TOTAL DATA</small>
                    <h3 class="fw-bold mb-0">{{ $mutasi->total() }}</h3>
                </div>
            </div>

            @if (request('filter_periode'))
                <div class="col-md-4">
                    <div class="card p-4 border-0 shadow-sm rounded-4 bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="opacity-75 fw-bold">CETAK BATCH</small>
                                <h4 class="fw-bold mb-0">{{ request('filter_periode') }}</h4>
                            </div>
                            <form action="{{ route('struk.store') }}" method="POST" target="_blank">
                                @csrf
                                <input type="hidden" name="mode_cetak_saja" value="yes">
                                <input type="hidden" name="periode" value="{{ request('filter_periode') }}">
                                @foreach ($mutasi as $m)
                                    <input type="hidden" name="tags[{{ $m->pelanggan_id }}]" value="{{ $m->tagihan }}">
                                @endforeach
                                <button type="submit" class="btn btn-light rounded-circle p-2"><i
                                        class="bi bi-printer-fill text-primary"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
            <div class="col-md-4">
                <div class="card p-4 border-0 shadow-sm rounded-4 bg-success text-white">
                    <small class="opacity-75 fw-bold">TOTAL TAGIHAN + ADMIN</small>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($total_periode, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">IDPEL & PELANGGAN</th>
                            <th class="text-center">PERIODE</th>
                            <th class="text-end">TOTAL</th>
                            <th class="text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mutasi as $m)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ optional($m->pelanggan)->nama }}</div>
                                    <small class="text-muted">{{ $m->pelanggan_id }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-info">{{ $m->periode }}</span>
                                </td>
                                <td class="text-end fw-bold">Rp
                                    {{ number_format($m->tagihan + $m->biaya_admin, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('struk.store') }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="hidden" name="mode_cetak_saja" value="yes">
                                        <input type="hidden" name="periode" value="{{ $m->periode }}">
                                        <input type="hidden" name="admin_global" value="{{ $m->biaya_admin }}">
                                        <input type="hidden" name="tags[{{ $m->pelanggan_id }}]"
                                            value="{{ $m->tagihan }}">
                                        <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                            <i class="bi bi-printer me-1"></i> Cetak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
