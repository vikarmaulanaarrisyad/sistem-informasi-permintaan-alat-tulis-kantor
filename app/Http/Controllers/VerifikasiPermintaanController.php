<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class VerifikasiPermintaanController extends Controller
{
    public function data(Request $request)
    {
        // $permintaan = Submission::orderBy('created_at', 'DESC')
        //     ->where('status', '!=', 'finish');
        $permintaan = Submission::select('user_id')
            ->where('status', '!=', 'finish')
            ->where('status', '!=', 'submit')
            ->groupBy('user_id')->get();


        return datatables($permintaan)
            ->addIndexColumn()
            ->addColumn('select_all', function ($permintaan) {
                return '
                    <input type="checkbox" class="submission_id" name="submission_id[]" id="submission_id" value="' . $permintaan->user_id . '">
                ';
            })
            ->addColumn('prodi', function ($permintaan) {
                // return $permintaan->user->name;
                $user = User::find($permintaan->user_id); // Retrieve the user record using user_id
                return $user ? $user->name : 'N/A'; //
            })
            ->addColumn('semester_ajuan', function ($permintaan) {
                // return $permintaan->semester->name . ' - ' . $permintaan->semester->semester;
                $submission = Submission::where('user_id', $permintaan->user_id)
                    ->orderBy('created_at', 'DESC')
                    ->first(); // Retrieve the latest submission record for the user
                if ($submission && $submission->semester) {
                    return $submission->semester->name . ' - ' . $submission->semester->semester;
                }
                return 'N/A';
            })
            ->addColumn('total_ajuan', function ($permintaan) {
                $totalAjuan = Submission::where('user_id', $permintaan->user_id)
                    ->where('status', '!=', 'finish')
                    ->where('status', '!=', 'submit')
                    ->count(); // Count the total number of submissions for the user
                return $totalAjuan;
            })
            ->addColumn('total', function ($permintaan) {
                $total = Submission::where('user_id', $permintaan->user_id)
                    ->where('status', '!=', 'finish')
                    ->where('status', '!=', 'submit')
                    ->sum('total_price'); // Count the total number of submissions for the user
                return format_uang($total);
            })
            ->addColumn('status_pengajuan', function ($permintaan) {
                if ($permintaan->status != 'finish' && $permintaan->status != "submit") {
                    return '
                        <span class="badge badge-success">Menunggu dikonfirmasi</span>
                    ';
                }
                return '-';
            })
            ->addColumn('aksi', function ($permintaan) {
                return '
                <a href="' . route('verifikasi-permintaan.detail', $permintaan->user_id) . '"  class="btn btn-primary btn-sm btn-block"><i class="fas fa-eye"></i> Lihat Detail</a>
                ';
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
        Submission::whereIn('user_id', $request->ids)->update(['status' => 'finish']);

        $permintaan = Submission::whereIn('user_id', $request->ids)
            ->get();

        foreach ($permintaan as  $item) {
            $productIn = ProductIn::where('product_id', $item->product_id)->first();
            $permintaanByUser = Submission::where('user_id', $item->user_id)->get();

            $userEmail = $item->user->email;

            if ($productIn) {
                $productIn->quantity;
            }
            $product = Product::findOrFail($item->product_id);
            $product->last_stock = $product->stock;
            $product->save();

            /* Notifikasi Email ke user */
            // Mail::to($userEmail)->send(new VerifikasiBarangNotify($permintaanByUser));
        }


        return response()->json(['message' => 'Permintaan berhasil diverifikasi.']);
    }

    public function detail($id)
    {
        $user = User::findOrfail($id);

        $pengajuanBarang = Submission::with('semester')->where('user_id', $user->id)->where('status', 'process')->get();

        return view('verifikasi.detail', compact('pengajuanBarang', 'user'));
    }
}
