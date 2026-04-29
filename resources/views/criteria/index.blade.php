@extends('layouts.app')

@section('title', 'Data Kriteria')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kriteria</h6>
        <button class="btn btn-primary btn-sm" id="btnAddCriteria" onclick="addCriteria()">
            <i class="bi bi-plus-lg"></i> Tambah Kriteria
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="criteriaTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Kriteria</th>
                        <th>Tipe</th>
                        <th>Bobot</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="criteriaData">
                    <!-- Data loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="criteriaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="criteriaForm">
                <div class="modal-body">
                    <input type="hidden" id="criteriaId">
                    <div class="mb-3">
                        <label class="form-label">Nama Kriteria</label>
                        <input type="text" class="form-control" id="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <select class="form-select" id="tipe" required>
                            <option value="benefit">Benefit</option>
                            <option value="cost">Cost</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Bobot (0 - 1)</label>
                        <input type="number" step="0.01" min="0" max="1" class="form-control" id="bobot" required>
                        <small class="text-muted">Contoh: 0.25</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        loadData();

        $('#criteriaForm').on('submit', function(e) {
            e.preventDefault();
            saveData();
        });
    });

    function loadData() {
        $.get("{{ route('criteria.index') }}", function(response) {
            let data = response.data;
            let totalWeight = response.total_weight;
            let html = '';
            
            data.forEach((item, index) => {
                html += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.nama}</td>
                        <td><span class="badge bg-${item.tipe == 'benefit' ? 'success' : 'warning'}">${item.tipe.toUpperCase()}</span></td>
                        <td>${item.bobot}</td>
                        <td>
                            <button class="btn btn-info btn-sm text-white" onclick="editCriteria(${item.id})"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="deleteCriteria(${item.id})"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                `;
            });
            
            // Append total row
            html += `
                <tr class="table-secondary fw-bold">
                    <td colspan="3" class="text-end">Total Bobot:</td>
                    <td colspan="2">${totalWeight}</td>
                </tr>
            `;
            
            $('#criteriaData').html(html);

            // Disable add button if total weight >= 1
            if (totalWeight >= 1) {
                $('#btnAddCriteria').attr('disabled', true).attr('title', 'Total bobot sudah mencapai 1');
            } else {
                $('#btnAddCriteria').attr('disabled', false).attr('title', '');
            }
        });
    }

    function addCriteria() {
        $('#criteriaId').val('');
        $('#criteriaForm')[0].reset();
        $('#modalTitle').text('Tambah Kriteria');
        $('#criteriaModal').modal('show');
    }

    function editCriteria(id) {
        $.get(`/criteria/${id}`, function(data) {
            $('#criteriaId').val(data.id);
            $('#nama').val(data.nama);
            $('#tipe').val(data.tipe);
            $('#bobot').val(data.bobot);
            $('#modalTitle').text('Edit Kriteria');
            $('#criteriaModal').modal('show');
        });
    }

    function saveData() {
        let id = $('#criteriaId').val();
        let url = id ? `/criteria/${id}` : "{{ route('criteria.store') }}";
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: {
                nama: $('#nama').val(),
                tipe: $('#tipe').val(),
                bobot: $('#bobot').val()
            },
            success: function(response) {
                $('#criteriaModal').modal('hide');
                showToast('success', response.success);
                loadData();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = '';
                for (let key in errors) {
                    errorMessage += errors[key][0] + '<br>';
                }
                Swal.fire('Error', errorMessage, 'error');
            }
        });
    }

    function deleteCriteria(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data kriteria akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/criteria/${id}`,
                    type: 'DELETE',
                    success: function(response) {
                        showToast('success', response.success);
                        loadData();
                    }
                });
            }
        });
    }
</script>
@endsection
