<?php

namespace App\Http\Controllers;

use App\Models\ProductOut;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifikasiPermintaanController extends Controller
{
    public function data(Request $request)
    {
        $permintaan = Submission::orderBy('created_at', 'DESC')->where('status', '!=', 'finish')->where('status', '!=', 'process');


        return datatables($permintaan)
            ->addIndexColumn()
            ->addColumn('select_all', function ($permintaan) {
                return '
                    <input type="checkbox" class="submission_id" name="submission_id[]" id="submission_id" value="' . $permintaan->id . '">
                ';
            })
            ->addColumn('prodi', function ($permintaan) {
                return $permintaan->user->name;
            })
            ->addColumn('product', function ($permintaan) {
                return $permintaan->product->name;
            })
            ->addColumn('unit', function ($permintaan) {
                return $permintaan->product->satuan->name;
            })
            ->addColumn('price', function ($permintaan) {
                return format_uang($permintaan->product->price);
            })
            ->addColumn('total', function ($permintaan) {
                return format_uang($permintaan->total_price);
            })
            ->addColumn('aksi', function () {
                return '';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function index()
    {
        return view('verifikasi.index');
    }

    public function approval(Request $request)
    {
       Submission::whereIn('id', $request->ids)->update(['status' => 'finish']);

        return response()->json(['message' => 'Permintaan berhasil diverifikasi.']);
    }
}
