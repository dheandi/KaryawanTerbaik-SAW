<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return response()->json(Employee::all());
        }
        return view('employees.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        $employee = Employee::create($validated);
        return response()->json(['success' => 'Karyawan berhasil ditambahkan', 'data' => $employee]);
    }

    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        $employee->update($validated);
        return response()->json(['success' => 'Karyawan berhasil diperbarui', 'data' => $employee]);
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json(['success' => 'Karyawan berhasil dihapus']);
    }
}
