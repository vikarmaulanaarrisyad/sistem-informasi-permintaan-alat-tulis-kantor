<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Semester;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermintaanBarang extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesterAktif = Semester::active()->first();
        $products = Product::with('satuan', 'category_product')->get();

        return view('permintaan.index', compact(['products', 'semesterAktif']));
    }

    /**
     * Display a listing of the resource.
     */
    public function data()
    {
        $userId = auth()->user()->id;

        $permintaan = Submission::whereRelation('user', 'user_id', $userId)->orderBy('created_at', 'DESC');

        return datatables($permintaan)
            ->addIndexColumn()
            ->addColumn('product', function ($permintaan) {
                return $permintaan->product->name;
            })
            ->addColumn('quantity', function ($permintaan) {
                return $permintaan->quantity;
            })
            ->addColumn('unit', function ($permintaan) {
                return $permintaan->product->satuan->name;
            })
            ->addColumn('aksi', function ($permintaan) {

                if ($permintaan->status == 'submit') {
                    return '
                        <div class="btn-group">
                            <button onclick="editForm(`' . route('permintaan-barang.show', $permintaan->id) . '`)" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</button>
                            <button onclick="deleteData(`' . route('permintaan-barang.destroy', $permintaan->id) . '`,`' . $permintaan->product->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </div>
                    ';
                } else {
                    return '
                        <a href="" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>
                    ';
                }
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
        $validator = Validator::make($request->all(), [
            'semester' => 'required',
            'name' => 'required',
            'date' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal disimpan.'], 422);
        }

        // Cek apakah ada permintaan barang yang belum diproses untuk produk yang sama
        $existingSubmission = Submission::where('product_id', $request->name)
            ->where('status', 'submit')
            ->first();

        if ($existingSubmission) {
            return response()->json(['message' => 'Maaf Anda sudah memiliki permintaan barang yang belum diverifikasi bagian logistik. Tidak dapat melakukan permintaan data baru'], 422);
        }

        $permintaan = new Submission();
        $permintaan->code = 'P-' . rand(99999999, 10000000);
        $permintaan->semester_id = $request->semester;
        $permintaan->user_id = Auth()->user()->id;
        $permintaan->date = $request->date;
        $permintaan->product_id = $request->name;
        $permintaan->quantity = $request->quantity;
        $permintaan->total_price = $permintaan->product->price * $request->quantity;
        $permintaan->status = 'submit';
        $permintaan->save();



        return response()->json(['data' => $permintaan, 'message' => 'Permintaan anda berhasil disimpan, menunggu approval dari bagian logistik.']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $permintaan = Submission::with('product')->findOrfail($id);

        return response()->json(['data' => $permintaan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal disimpan.'], 422);
        }

        $permintaan = Submission::findOrfail($id);

        $data = [
            'date' => $request->date,
            'quantity' => $request->quantity,
            'status' => $permintaan->status,
        ];

        $permintaan->update($data);

        return response()->json(['data' => $permintaan, 'message' => 'Permintaan anda berhasil disimpan, menunggu approval dari bagian logistik.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $permintaan = Submission::findOrfail($id);

        if ($permintaan->status == 'finish') {
            return response()->josn(['message' => 'Data gagal dihapus.'], 400);
        }

        $permintaan->delete();

        return response()->json(['data' => NULL, 'message' => 'Data berhasil dihapus.']);
    }

    /**
     * Get data products.
     */
    public function getProduct($id)
    {
        $product = Product::with('satuan')->findOrfail($id);

        return response()->json(['data' => $product]);
    }
}
