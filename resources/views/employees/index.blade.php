@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Karyawan</h6>
        <button class="btn btn-primary btn-sm" onclick="addEmployee()">
            <i class="bi bi-plus-lg"></i> Tambah Karyawan
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="employeeTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="employeeData">
                    <!-- Data loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="employeeForm">
                <div class="modal-body">
                    <input type="hidden" id="employeeId">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan" required>
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

        $('#employeeForm').on('submit', function(e) {
            e.preventDefault();
            saveData();
        });
    });

    function loadData() {
        $.get("{{ route('employees.index') }}", function(data) {
            let html = '';
            if(data.length === 0) {
                html = '<tr><td colspan="4" class="text-center">Belum ada data karyawan.</td></tr>';
            } else {
                data.forEach((item, index) => {
                    html += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.nama}</td>
                            <td>${item.jabatan}</td>
                            <td>
                                <button class="btn btn-info btn-sm text-white" onclick="editEmployee(${item.id})"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-danger btn-sm" onclick="deleteEmployee(${item.id})"><i class="bi bi-trash"></i></button>
                            </td>
                        </tr>
                    `;
                });
            }
            $('#employeeData').html(html);
        });
    }

    function addEmployee() {
        $('#employeeId').val('');
        $('#employeeForm')[0].reset();
        $('#modalTitle').text('Tambah Karyawan');
        $('#employeeModal').modal('show');
    }

    function editEmployee(id) {
        $.get(`/employees/${id}`, function(data) {
            $('#employeeId').val(data.id);
            $('#nama').val(data.nama);
            $('#jabatan').val(data.jabatan);
            $('#modalTitle').text('Edit Karyawan');
            $('#employeeModal').modal('show');
        });
    }

    function saveData() {
        let id = $('#employeeId').val();
        let url = id ? `/employees/${id}` : "{{ route('employees.store') }}";
        let method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: {
                nama: $('#nama').val(),
                jabatan: $('#jabatan').val()
            },
            success: function(response) {
                $('#employeeModal').modal('hide');
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

    function deleteEmployee(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Semua nilai terkait karyawan ini juga akan terhapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/employees/${id}`,
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
