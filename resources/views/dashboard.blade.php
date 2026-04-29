@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-6 col-xl-4">
        <div class="card border-start border-primary border-4 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-primary fw-bold text-xs mb-1">Total Karyawan</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $employeeCount }}</div>
                    </div>
                    <div class="col-auto"><i class="bi bi-people fs-2 text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card border-start border-success border-4 py-2">
            <div class="card-body">
                <div class="row align-items-center no-gutters">
                    <div class="col me-2">
                        <div class="text-uppercase text-success fw-bold text-xs mb-1">Total Kriteria</div>
                        <div class="text-dark fw-bold h5 mb-0">{{ $criteriaCount }}</div>
                    </div>
                    <div class="col-auto"><i class="bi bi-list-check fs-2 text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Alur Kerja Sistem SAW</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <p>Simple Additive Weighting (SAW) sering juga dikenal istilah metode penjumlahan terbobot. Konsep dasar metode SAW adalah mencari penjumlahan terbobot dari rating kinerja pada setiap alternatif pada semua kriteria.</p>
                <div class="list-group">
                    <div class="list-group-item list-group-item-action d-flex gap-3 py-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">1</div>
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div>
                                <h6 class="mb-0 fw-bold">Input Kriteria & Bobot</h6>
                                <p class="mb-0 opacity-75">Tentukan kriteria apa saja yang akan dinilai beserta bobot kepentingannya.</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item list-group-item-action d-flex gap-3 py-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">2</div>
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div>
                                <h6 class="mb-0 fw-bold">Input Data Karyawan</h6>
                                <p class="mb-0 opacity-75">Masukkan data karyawan yang akan mengikuti proses seleksi atau penilaian.</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item list-group-item-action d-flex gap-3 py-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">3</div>
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div>
                                <h6 class="mb-0 fw-bold">Input Nilai</h6>
                                <p class="mb-0 opacity-75">Berikan nilai untuk setiap kriteria pada masing-masing karyawan.</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item list-group-item-action d-flex gap-3 py-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">4</div>
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div>
                                <h6 class="mb-0 fw-bold">Proses Perhitungan SAW</h6>
                                <p class="mb-0 opacity-75">Sistem akan melakukan normalisasi matriks dan perhitungan nilai preferensi.</p>
                            </div>
                        </div>
                    </div>
                    <div class="list-group-item list-group-item-action d-flex gap-3 py-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">5</div>
                        <div class="d-flex gap-2 w-100 justify-content-between">
                            <div>
                                <h6 class="mb-0 fw-bold">Hasil Ranking</h6>
                                <p class="mb-0 opacity-75">Lihat hasil akhir berupa daftar peringkat karyawan dari yang terbaik.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
