@extends('layouts.app')

@section('title', 'Hasil & Ranking')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h1 class="h3 mb-0 text-gray-800">Perhitungan Metode SAW</h1>
    <a href="{{ route('saw.index') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-calculator me-1"></i> Hitung Ulang
    </a>
</div>

@if(isset($error))
    <div class="alert alert-danger shadow-sm">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $error }}
    </div>
@else
    <!-- Normalization Matrix -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Matriks Normalisasi (R)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Alternatif</th>
                            @foreach($criteria as $c)
                                <th>{{ $c->nama }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $e)
                            <tr>
                                <td class="fw-bold">{{ $e->nama }}</td>
                                @foreach($criteria as $c)
                                    <td class="text-center">{{ number_format($normalization[$e->id][$c->id], 2) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Weighted Normalization Matrix -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Matriks Terbobot (Y)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light text-center">
                        <tr>
                            <th>Alternatif</th>
                            @foreach($criteria as $c)
                                <th>{{ $c->nama }} ({{ $c->bobot }})</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $e)
                            <tr>
                                <td class="fw-bold">{{ $e->nama }}</td>
                                @foreach($criteria as $c)
                                    <td class="text-center">{{ number_format($weightedMatrix[$e->id][$c->id], 2) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                <p class="text-muted small mb-0">
                    * Matriks terbobot diperoleh dari: <strong>Normalisasi * Bobot Kriteria</strong>
                </p>
            </div>
        </div>
    </div>

    <!-- Final Ranking -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Hasil Akhir & Ranking (V)</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th width="100">Ranking</th>
                            <th>Nama Karyawan</th>
                            <th>Jabatan</th>
                            <th>Nilai Preferensi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $index => $res)
                            <tr class="{{ $index == 0 ? 'table-success' : '' }}">
                                <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $res['employee']->nama }}</td>
                                <td>{{ $res['employee']->jabatan }}</td>
                                <td class="text-center fw-bold text-primary">{{ number_format($res['total'], 2) }}</td>
                                <td>
                                    @if($index == 0)
                                        <span class="badge bg-success">Karyawan Terbaik <i class="bi bi-star-fill"></i></span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                <p class="text-muted small">
                    * Perhitungan dilakukan dengan mengalikan matriks normalisasi dengan bobot kriteria: <strong>V<sub>i</sub> = Σ (w<sub>j</sub> * r<sub>ij</sub>)</strong>
                </p>
            </div>
        </div>
    </div>
@endif
@endsection
