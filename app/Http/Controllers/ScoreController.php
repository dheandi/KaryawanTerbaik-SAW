<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Criterion;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        $criteria = Criterion::all();
        
        // Get existing scores and map them to [employee_id][criteria_id]
        $existingScores = Score::all()->groupBy('employee_id')->map(function ($row) {
            return $row->keyBy('criteria_id')->map(function ($score) {
                return $score->nilai;
            });
        });
        
        return view('scores.index', compact('employees', 'criteria', 'existingScores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'scores' => 'required|array',
        ]);

        foreach ($request->scores as $employeeId => $criteriaValues) {
            foreach ($criteriaValues as $criteriaId => $nilai) {
                if ($nilai !== null && $nilai !== '') {
                    Score::updateOrCreate(
                        [
                            'employee_id' => $employeeId,
                            'criteria_id' => $criteriaId,
                        ],
                        [
                            'nilai' => $nilai,
                        ]
                    );
                }
            }
        }

        return response()->json(['success' => 'Semua nilai berhasil disimpan!']);
    }
}
