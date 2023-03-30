<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier.index');
    }

    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $supplier = Supplier::all();

        return datatables($supplier)
            ->addIndexColumn()
            ->editColumn('phone', function ($supplier) {
                return '
                    <a target="blank" href="' . url('https://wa.me/' . $supplier->phone) . '">' . $supplier->phone . ' </a>
                ';
            })
            ->addColumn('aksi', function ($supplier) {
                return '
                    <div class="btn-group">
                        <button onclick="editForm(`' . route('supplier.show', $supplier->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button onclick="deleteData(`' . route('supplier.destroy', $supplier->id) . '`, `' . $supplier->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                    </div>
                ';
            })
            ->escapeColumns([])
            ->make(true);
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
                'email' => 'required',
                'phone' => 'required|numeric',
                'address' => 'required',
            ],
            [
                'name.required' => 'Nama supplier wajib diisi.',
                'email.required' => 'Email supplier wajib diisi.',
                'phone.required' => 'Nomor handphone supplier wajib diisi.',
                'address.required' => 'Alamat supplier wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal tersimpan.'], 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        Supplier::create($data);

        return response()->json(['data' => $data, 'message' => 'Data ' . $request->name . ' berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return response()->json(['data'  => $supplier]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required|numeric',
                'address' => 'required',
            ],
            [
                'name.required' => 'Nama supplier wajib diisi.',
                'email.required' => 'Email supplier wajib diisi.',
                'phone.required' => 'Nomor handphone supplier wajib diisi.',
                'address.required' => 'Alamat supplier wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal tersimpan.'], 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        $supplier->update($data);

        return response()->json(['data' => $data, 'message' => 'Data ' . $request->name . ' berhasil disimpan.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return response()->json(['message' => 'Data supplier ' . $supplier->name . ' berhasil dihapus.']);
    }
}
