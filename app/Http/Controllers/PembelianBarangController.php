<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\Semester;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PembelianBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesterAktif = $this->semesterAktif();
        $products = Product::with('satuan', 'category_product')->get();
        $suppliers = Supplier::all();
        $totalItemPembelian = ProductIn::where('semester_id', $semesterAktif->id)->get()->count();
        $totalItemPembelianPrice = ProductIn::where('semester_id', $semesterAktif->id)->get()->sum('total_price');

        return view('pembelian.index', compact('semesterAktif', 'products', 'suppliers', 'totalItemPembelian', 'totalItemPembelianPrice'));
    }

    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {
        $dateRange = $request->input('datefilter');
        if (strpos($dateRange, ' - ') !== false && $dateRange != "") {
            $dateParts = explode(' - ', $dateRange);

            $startDate = $dateParts[0];
            $endDate = $dateParts[1];

            $semesterAktif = $this->semesterAktif();
            $pembelian = ProductIn::where('semester_id', $semesterAktif->id)
                ->when($request->datefilter != "", function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('date', [$startDate, $endDate]);
                });
        } else {
            $semesterAktif = $this->semesterAktif();
            $pembelian = ProductIn::where('semester_id', $semesterAktif->id);
        }


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
            'product_id' => 'required',
            'date' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal disimpan.'], 422);
        }

        DB::beginTransaction();

        try {
            $pembelian = new ProductIn();
            $pembelian->semester_id = $request->semester;
            $pembelian->supplier_id = $request->supplier_id;
            $pembelian->date = $request->date;
            $pembelian->product_id = $request->product_id;
            $pembelian->quantity = $request->quantity;
            $pembelian->total_price = $pembelian->product->price * $request->quantity;
            $pembelian->save();

            $product = Product::where('id', $pembelian->product_id)->first();
            $product->stock += $pembelian->quantity;
            $product->save();

            DB::commit();
            return response()->json(['data' => $pembelian, 'message' => 'Pembelian barang berhasil disimpan.']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['data' => $pembelian, 'message' => 'Pembelian barang gagal disimpan.'], 403);
        }
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


    /**
     * Mendapatkan data Item Pembelian.
     */
    public function getData()
    {
        $semesterAktif = $this->semesterAktif();
        $totalItemPembelian = ProductIn::where('semester_id', $semesterAktif->id)->get()->count();
        $totalItemPembelianPrice = ProductIn::where('semester_id', $semesterAktif->id)->get()->sum('total_price');

        return response()->json([
            'totalItemPembelian' => $totalItemPembelian,
            'totalItemPembelianPrice' => $totalItemPembelianPrice,
        ]);
    }

    /**
     * Mendapatkan semester aktif.
     */
    public function semesterAktif()
    {
        return Semester::active()->first();
    }

}
