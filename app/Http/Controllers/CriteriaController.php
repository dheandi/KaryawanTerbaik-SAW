<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return response()->json([
                'data' => Criterion::all(),
                'total_weight' => round(Criterion::sum('bobot'), 2)
            ]);
        }
        return view('criteria.index');
    }

    public function store(Request $request)
    {
        $currentTotal = Criterion::sum('bobot');
        if ($currentTotal >= 1) {
            return response()->json([
                'errors' => ['bobot' => ['Total bobot sudah mencapai 1. Anda tidak dapat menambah kriteria lagi kecuali ada bobot yang dikurangi atau kriteria dihapus.']]
            ], 422);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:1',
        ]);

        if ($currentTotal + $request->bobot > 1) {
            return response()->json([
                'errors' => ['bobot' => ['Total bobot tidak boleh melebihi 1. Sisa kuota: ' . round(1 - $currentTotal, 2)]]
            ], 422);
        }

        $criterion = Criterion::create($validated);
        return response()->json(['success' => 'Kriteria berhasil ditambahkan', 'data' => $criterion]);
    }

    public function show(Criterion $criterion)
    {
        return response()->json($criterion);
    }

    public function update(Request $request, Criterion $criterion)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:benefit,cost',
            'bobot' => 'required|numeric|min:0|max:1',
        ]);

        $otherTotal = Criterion::where('id', '!=', $criterion->id)->sum('bobot');
        if ($otherTotal + $request->bobot > 1) {
            return response()->json([
                'errors' => ['bobot' => ['Total bobot tidak boleh melebihi 1. Sisa kuota bobot: ' . round(1 - $otherTotal, 2)]]
            ], 422);
        }

        $criterion->update($validated);
        return response()->json(['success' => 'Kriteria berhasil diperbarui', 'data' => $criterion]);
    }

    public function destroy(Criterion $criterion)
    {
        $criterion->delete();
        return response()->json(['success' => 'Kriteria berhasil dihapus']);
    }
}
