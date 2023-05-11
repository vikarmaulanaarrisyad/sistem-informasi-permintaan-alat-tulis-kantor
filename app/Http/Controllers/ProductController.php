<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Satuan;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataSatuan = Satuan::all();
        $dataJenisBarang = Category::all();

        return view('product.index', compact([
            'dataSatuan',
            'dataJenisBarang'
        ]));
    }

    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $product = Product::orderBy('created_at', 'DESC');

        return datatables($product)
            ->addIndexColumn()
            ->addColumn('unit', function ($product) {
                return $product->satuan->name;
            })
            ->addColumn('price', function ($product) {
                return format_uang($product->price);
            })
            ->addColumn('keterangan', function ($product) {
                if ($product->stock < 1) {
                    return 'Habis';
                }
                return 'Tersedia';
            })
            ->addColumn('aksi', function ($product) {
                return '
                    <div class="btn-group">
                        <button onclick="detailForm(`' . route('barang.detail', $product->id) . '`)" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</button>
                        <button onclick="editForm(`' . route('barang.show', $product->id) . '`)" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</button>
                        <button onclick="deleteData(`' . route('barang.destroy', $product->id) . '`,`' . $product->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
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
        // validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required|regex:/^[0-9.]+$/',
            'categories' => 'required',
        ]);

        // cek validasi inputan
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Daftar barang gagal disimpan.'], 422);
        }

        DB::beginTransaction();

        try {
            $product = new Product();
            $product->code = 'BRG-' . rand(1000000000000, 9000000000000);
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->unit_id = $request->unit;
            $product->price = str_replace('.', '', $request->price);
            $product->stock = $request->stock ?? 0;
            $product->save();

            $product->category_product()->attach($request->categories);

            DB::commit();

            return response()->json(['data' => $product, 'message' => 'Data ' . $product->name . ' berhasil disimpan.']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => 'Something Went Wrong!'], 400);
            return $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $product = Product::findOrfail($id);
        $product->categories = $product->category_product;
        $product->unit = $product->satuan->id;

        return response()->json(['data' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function detail(Request $request, $id)
    {
        $product = Product::findOrfail($id);
        $product->categories = $product->category_product;
        $product->unit = $product->satuan->name;


        return response()->json(['data' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // validasi
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'unit' => 'required',
            'price' => 'required|regex:/^[0-9.]+$/',
            'categories' => 'required',
        ]);

        // cek validasi inputan
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Daftar barang gagal disimpan.'], 422);
        }

        DB::beginTransaction();

        try {
            $product = Product::findOrfail($id);
            $product->code = $product->code;
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->unit_id = $request->unit;
            $product->price = str_replace('.', '', $request->price);
            $product->stock = $product->stock;
            $product->save();

            $product->category_product()->sync($request->categories);

            DB::commit();

            return response()->json(['data' => $product, 'message' => 'Data ' . $product->name . ' berhasil disimpan.']);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => 'Something Went Wrong!'], 400);
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrfail($id);
        $product->delete();

        return response()->json(['data' => NULL, 'message' => 'Data ' . $product->name . ' berhasil dihapus.']);
    }
}
