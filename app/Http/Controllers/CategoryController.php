<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $category = Category::all();

        return datatables($category)
            ->addIndexColumn()
            ->addColumn('aksi', function ($category) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`' . route('jenis-barang.show', $category->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                    <button onclick="deleteData(`' . route('jenis-barang.destroy', $category->id) . '`, `' . $category->name  . ' ' . $category->satuan . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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
        return view('category.index');
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
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Jenis barang wajib diisi.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal tersimpan.'], 422);
        }

        $data = [
            'name' => $request->name
        ];

        $category = Category::create($data);

        return response()->json(['data' => $category, 'message' => 'Data ' . $request->name . ' berhasil tersimpan.'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::findOrfail($id);

        return response()->json(['data' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Jenis barang wajib diisi.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal tersimpan.'], 422);
        }

        $data = [
            'name' => $request->name
        ];

        $category = Category::findOrfail($id);
        $category->update($data);

        return response()->json(['data' => $category, 'message' => 'Data ' . $request->name . ' berhasil tersimpan.'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrfail($id);

        $category->delete();

        return response()->json(['data' => NULL, 'message' => 'Data ' . $category->name . ' berhasil dihapus.'], 200);
    }
}
