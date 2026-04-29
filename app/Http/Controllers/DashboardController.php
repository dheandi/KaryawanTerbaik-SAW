<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Criterion;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $employeeCount = Employee::count();
        $criteriaCount = Criterion::count();
        return view('dashboard', compact('employeeCount', 'criteriaCount'));
    }
}
