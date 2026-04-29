@extends('layouts.app')

@section('title', 'Input Nilai')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card border-start border-info border-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-info-circle-fill text-info fs-3"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1 fw-bold text-info">Informasi Penginputan Nilai</h6>
                        <p class="mb-0 text-muted small">
                            Masukkan nilai untuk setiap kriteria dengan rentang <strong>1 - 100</strong>. 
                            Nilai desimal diperbolehkan (contoh: 85.5). Pastikan semua kolom terisi sebelum menekan tombol simpan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Matriks Penilaian Karyawan</h6>
        <button class="btn btn-success btn-sm" id="btnSaveScores">
            <i class="bi bi-save"></i> Simpan Semua Nilai
        </button>
    </div>
    <div class="card-body">
        @if($employees->isEmpty() || $criteria->isEmpty())
            <div class="alert alert-warning">
                Harap isi <strong>Data Kriteria</strong> dan <strong>Data Karyawan</strong> terlebih dahulu.
            </div>
        @else
            <form id="scoreForm">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th rowspan="2" class="align-middle">Nama Karyawan</th>
                                <th colspan="{{ $criteria->count() }}">Kriteria</th>
                            </tr>
                            <tr>
                                @foreach($criteria as $c)
                                    <th>
                                        {{ $c->nama }}<br>
                                        <small class="badge bg-secondary">{{ strtoupper($c->tipe) }}</small>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employees as $e)
                                <tr>
                                    <td class="fw-bold">{{ $e->nama }}</td>
                                    @foreach($criteria as $c)
                                        <td>
                                            <input type="number" step="0.01" min="1" max="100"
                                                   name="scores[{{ $e->id }}][{{ $c->id }}]" 
                                                   class="form-control text-center" 
                                                   value="{{ $existingScores[$e->id][$c->id] ?? '' }}" 
                                                   placeholder="0" required>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#btnSaveScores').on('click', function() {
            const form = document.getElementById('scoreForm');
            
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let formData = $('#scoreForm').serialize();
            
            $.ajax({
                url: "{{ route('scores.store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    showToast('success', response.success);
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Terjadi kesalahan saat menyimpan nilai.', 'error');
                }
            });
        });
    });
</script>
@endsection
