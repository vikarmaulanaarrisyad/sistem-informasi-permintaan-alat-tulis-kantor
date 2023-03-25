<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SemesterController extends Controller
{
    /**
     * Datatables
     */
    public function data()
    {
        $semester = Semester::all();

        return datatables($semester)
            ->addIndexColumn()
            ->editColumn('status', function ($semester) {
                return '
                    <span class="badge bg-' . $semester->statusColor() . '">' . $semester->status . '</span>
                ';
            })
            ->addColumn('aksi_status', function ($semester) {
                if ($semester->status == 'Tidak Aktif') {
                    return '
                        <button onclick="updateStatus(`' . route('semester.update_status', $semester->id) . '`, `' . $semester->name  . ' ' . $semester->semester . '`)" class="btn btn-sm btn-success"><i class="fas fa-check-circle"></i> Aktifkan!</button>
                    ';
                } else {
                    return '
                        <button disabled onclick="updateStatus(`' . route('semester.update_status', $semester->id) . '`, `' . $semester->name  . ' ' . $semester->semester . '`)" class="btn btn-sm btn-danger"><i class="fas fa-check-circle"></i> Non Aktifkan!</button>
                    ';
                }
            })
            ->addColumn('aksi', function ($semester) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route('semester.show', $semester->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                    <button onclick="deleteData(`' . route('semester.destroy', $semester->id) . '`, `' . $semester->name  . ' ' . $semester->semester . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                </div>
                ';
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('semester.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'semester' => 'required|in:Ganjil,Genap'
            ],
            [
                'name.required' => 'Tahun akademik wajib diisi.',
                'semester.required' => 'Semester wajib diisi.'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal tersimpan.'], 422);
        }

        $semester = new Semester();
        $semester->name = $request->name;
        $semester->semester = $request->semester;
        $semester->save();

        return response()->json(['data' => $semester, 'message' => 'Data ' . $request->name . ' ' . $request->semester . ' berhasil tersimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Semester $semester)
    {
        return response()->json(['data' => $semester]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Semester $semester)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Semester $semester)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'semester' => 'required|in:Ganjil,Genap'
            ],
            [
                'name.required' => 'Tahun akademik wajib diisi.',
                'semester.required' => 'Semester wajib diisi.'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal tersimpan.'], 422);
        }

        $data = [
            'name' => $request->name,
            'semester' => $request->semester,
        ];

        $semester->update($data);

        return response()->json(['data' => $semester, 'message' => 'Tahun akademik ' . $request->name . ' ' . $request->semester . ' berhasil tersimpan.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester)
    {
        // cek status semester aktif
        if ($semester->status == 'Aktif') {
            return response()->json(['data' => $semester, 'message' => 'Tahun akademik ' . $semester->name . ' ' . $semester->semester . ' tidak dapat dihapus.'], 422);
        } else {
            $semester->delete();

            return response()->json(['data' => NULL, 'message' => 'Tahun akademik ' . $semester->name . ' ' . $semester->semester . ' berhasil dihapus.'], 200);
        }
    }

    /**
     * Update status semester.
     */
    public function updateStatus($id)
    {
        $semesters = Semester::all();

        $semester = Semester::findOrfail($id);
        // cek status
        if ($semester->status != 'Tidak Aktif') {
            return response()->json(['data' => $semester, 'message' => 'Tahun akademik ' . $semester->name . ' ' . $semester->semester . ' status aktif.'], 401);
        } else {
            foreach ($semesters as $item) {
                $item->update(['status' => 'Tidak Aktif']);
            }
            $semester->update(['status' => 'Aktif']);
            return response()->json(['data' => $semester, 'message' => 'Tahun akademik ' . $semester->name . ' ' . $semester->semester . ' berhasil disimpan.'], 200);
        }
    }
}
