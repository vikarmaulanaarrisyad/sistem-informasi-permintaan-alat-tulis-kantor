<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $satuan = Satuan::all();

        return datatables($satuan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($satuan) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route('satuan.show', $satuan->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                    <button onclick="deleteData(`' . route('satuan.destroy', $satuan->id) . '`, `' . $satuan->name  . ' ' . $satuan->satuan . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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
        return view('satuan.index');
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
            ],
            [
                'name.required' => 'Satuan wajib diisi.'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => ' gagal tersimpan.'], 422);
        }

        $data = [
            'name' => $request->name
        ];

        $satuan = Satuan::create($data);

        return response()->json(['data' => $satuan, 'message' => 'Data ' . $request->name . ' berhasil tersimpan.'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Satuan $satuan)
    {
        return response()->json(['data' => $satuan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Satuan $satuan)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ],
            [
                'name.required' => 'Satuan wajib diisi.'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => ' gagal tersimpan.'], 422);
        }

        $data = [
            'name' => $request->name
        ];

        $satuan->update($data);

        return response()->json(['data' => $satuan, 'message' => 'Data ' . $request->name . ' berhasil tersimpan.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Satuan $satuan)
    {
        $satuan->delete();

        return response()->json(['data' => NULL, 'message' => "Data " . $satuan->name . ' berhasil dihapus.'], 200);
    }
}
