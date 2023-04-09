<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\Semester;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PembelianBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesterAktif = Semester::active()->first();
        $products = Product::with('satuan', 'category_product')->get();
        $suppliers = Supplier::all();

        return view('pembelian.index', compact('semesterAktif', 'products', 'suppliers'));
    }

    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $pembelian = ProductIn::all();

        return datatables($pembelian)
            ->addIndexColumn()
            ->addColumn('date', function ($pembelian) {
                return tanggal_indonesia($pembelian->date);
            })
            ->addColumn('code_product', function ($pembelian) {
                return '
                <span class="badge badge-primary">' . $pembelian->product->code . '</span>
                ';
            })
            ->addColumn('product', function ($pembelian) {
                return $pembelian->product->name;
            })
            ->addColumn('unit', function ($pembelian) {
                return $pembelian->product->satuan->name;
            })
            ->addColumn('price', function ($pembelian) {
                return format_uang($pembelian->product->price);
            })
            ->addColumn('total', function ($pembelian) {
                return format_uang($pembelian->total_price);
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

        $pembelian = new ProductIn();
        $pembelian->semester_id = $request->semester;
        $pembelian->supplier_id = $request->supplier_id;
        $pembelian->date = $request->date;
        $pembelian->product_id = $request->name;
        $pembelian->quantity = $request->quantity;
        $pembelian->total_price = $pembelian->product->price * $request->quantity;
        $pembelian->save();

        $product = Product::where('id', $pembelian->product_id)->first();
        $product->stock += $pembelian->quantity;
        $product->save();
        
        return response()->json(['data' => $pembelian, 'message' => 'Pembelian barang berhasil disimpan.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
