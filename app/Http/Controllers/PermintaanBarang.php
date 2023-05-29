<?php

namespace App\Http\Controllers;

use App\Mail\PermintaanBarangNotify;
use App\Models\Product;
use App\Models\Semester;
use App\Models\Setting;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class PermintaanBarang extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesterAktif = Semester::active()->first();
        $products = Product::with('satuan', 'category_product')->get();

        return view('permintaan.index', compact('products', 'semesterAktif'));
    }

    /**
     * Display a listing of the resource.
     */
    public function data(Request $request)
    {

        $date_range = $request->input('datefilter');
        $userId = auth()->user()->id;

        if (strpos($date_range, ' - ') !== false) {
            $date_parts = explode(' - ', $date_range);

            $start_date = $date_parts[0];
            $end_date = $date_parts[1];

            $permintaan = Submission::whereRelation('user', 'user_id', $userId)
                ->when($request->has('status') && $request->status != "", function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->when(
                    $request->datefilter != "",
                    function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('date', [$start_date, $end_date]);
                    }
                )
                ->orderBy('created_at', 'ASC');
        } else {
            $permintaan = Submission::whereRelation('user', 'user_id', $userId)
                ->when($request->has('status') && $request->status != "", function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->where('status', 'submit')
                ->orderBy('created_at', 'ASC'); // query kosong
        }

        return datatables($permintaan)
            ->addIndexColumn()
            ->addColumn('select_all', function ($permintaan) {
                if ($permintaan->status == 'submit') {
                    return '
                    <input type="checkbox" class="submission_id" name="submission_id[]" id="submission_id" value="' . $permintaan->id . '">
                ';
                }
            })
            ->addColumn('code', function ($permintaan) {
                return '<span class="badge badge-success">' . $permintaan->code . '</span>';
            })
            ->addColumn('product', function ($permintaan) {
                return $permintaan->product->name;
            })
            ->addColumn('quantity', function ($permintaan) {
                return $permintaan->quantity;
                // return '
                //     <input onchange="updateQuantity(`'.route('permintaan-barang.update_quantity', $permintaan->id).'`)" type="number" name="quantity" min="1" class="form-control" value="' . $permintaan->quantity . '" style="width:100px;">
                // ';
            })
            ->addColumn('unit', function ($permintaan) {
                return $permintaan->product->satuan->name;
            })
            ->addColumn('status', function ($permintaan) {
                return '<span class="badge badge-' . $permintaan->textColor() . '">' . $permintaan->status . '</span>';
            })
            ->addColumn('aksi', function ($permintaan) {

                if ($permintaan->status == 'submit') {
                    return '
                        <div class="btn-group">

                            <button onclick="deleteData(`' . route('permintaan-barang.destroy', $permintaan->id) . '`,`' . $permintaan->product->name . '`)" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </div>
                    ';
                    // <button onclick="editForm(`' . route('permintaan-barang.show', $permintaan->id) . '`)" class="btn btn-sm btn-warning"><i class="fas fa-pencil-alt"></i> Edit</button>
                } else {
                    return '';
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
            'product_id' => 'required',
            'date' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Data gagal disimpan.'], 422);
        }

        // Cek apakah ada permintaan barang yang belum diproses untuk produk yang sama
        $existingSubmission = Submission::where('product_id', $request->product_id)
            ->where('status', 'submit')
            ->where('user_id', Auth()->user()->id)
            ->first();

        if ($existingSubmission) {
            return response()->json(['message' => 'Maaf Anda sudah memiliki permintaan barang yang belum diverifikasi bagian logistik. Tidak dapat melakukan permintaan data baru'], 422);
        }

        $product = Product::where('id', $request->product_id)->first();

        if ($product->stock < $request->quantity) {
            return response()->json(['message' => 'Jumlah permintaan melebihi stok tersedia ' . $product->stock], 302);
        } else {
            $date = $request->date;
            $year = substr($date, 2, 2);

            $permintaan = new Submission();
            $permintaan->code = 'P-' . $year . '-'  . rand(999999, 100000);
            $permintaan->semester_id = $request->semester;
            $permintaan->user_id = Auth()->user()->id;
            $permintaan->date = $request->date;
            $permintaan->product_id = $request->product_id;
            $permintaan->quantity = $request->quantity;
            $permintaan->total_price = $permintaan->product->price * $request->quantity;
            $permintaan->status = 'submit';
            $permintaan->save();

            $product->stock -= $request->quantity;
            $product->save();

            return response()->json(['data' => $permintaan, 'message' => 'Permintaan anda berhasil disimpan, menunggu approval dari bagian logistik.']);
        }
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
        $product = Product::findOrfail($permintaan->product_id);
        $product->stock += $permintaan->quantity;

        if ($permintaan->status == 'finish') {
            return response()->josn(['message' => 'Data gagal dihapus.'], 400);
        }

        $product->save();
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

    public function pengajuan(Request $request)
    {
        $user = Submission::where('user_id', Auth()->user()->id)
            ->where('status', 'submit')
            ->get();

        if (!$user->isEmpty()) {
            Submission::whereIn('id', $request->ids)->update(['status' => 'process']);

            /* Notifikasi Email */
            Mail::to('vikar.maulana.arrisyad@gmail.com')->send(new PermintaanBarangNotify($user));
        }

        return response()->json(['message' => 'Permintaan berhasil diajukan bagian logistik.']);
    }
}
