<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Criterion;
use App\Models\Score;
use Illuminate\Http\Request;

class SawController extends Controller
{
    public function index()
    {
        $employees = Employee::with('scores')->get();
        $criteria = Criterion::all();
        
        if ($employees->isEmpty() || $criteria->isEmpty()) {
            return view('saw.index', ['error' => 'Data karyawan atau kriteria masih kosong.']);
        }

        // Check if scores are complete
        $totalScoresNeeded = $employees->count() * $criteria->count();
        $currentScoresCount = Score::count();
        
        if ($currentScoresCount < $totalScoresNeeded) {
            return view('saw.index', ['error' => 'Harap lengkapi semua nilai karyawan terlebih dahulu.']);
        }

        // 1. Get Min/Max for each criterion
        $minMax = [];
        foreach ($criteria as $c) {
            $scores = Score::where('criteria_id', $c->id)->pluck('nilai');
            if ($scores->isEmpty()) continue;
            
            if ($c->tipe == 'benefit') {
                $minMax[$c->id] = $scores->max();
            } else {
                $minMax[$c->id] = $scores->min();
            }
        }

        // 2. Normalization Matrix
        $normalization = [];
        foreach ($employees as $e) {
            foreach ($criteria as $c) {
                $scoreObj = $e->scores->where('criteria_id', $c->id)->first();
                $score = $scoreObj ? $scoreObj->nilai : 0;
                
                if ($minMax[$c->id] == 0) {
                    $normalization[$e->id][$c->id] = 0;
                } else {
                    if ($c->tipe == 'benefit') {
                        $normalization[$e->id][$c->id] = round($score / $minMax[$c->id], 2);
                    } else {
                        $normalization[$e->id][$c->id] = $score == 0 ? 0 : round($minMax[$c->id] / $score, 2);
                    }
                }
            }
        }

        // 3. Calculation Weighted Normalization Matrix
        $weightedMatrix = [];
        foreach ($employees as $e) {
            foreach ($criteria as $c) {
                $weightedMatrix[$e->id][$c->id] = round($normalization[$e->id][$c->id] * $c->bobot, 2);
            }
        }

        // 4. Calculation Preference
        $results = [];
        foreach ($employees as $e) {
            $total = 0;
            foreach ($criteria as $c) {
                $total += $weightedMatrix[$e->id][$c->id];
            }
            $results[] = [
                'employee' => $e,
                'total' => $total,
                'normalization' => $normalization[$e->id]
            ];
        }

        // 5. Ranking
        usort($results, function($a, $b) {
            return $b['total'] <=> $a['total'];
        });

        return view('saw.index', compact('employees', 'criteria', 'normalization', 'weightedMatrix', 'results'));
    }
}
