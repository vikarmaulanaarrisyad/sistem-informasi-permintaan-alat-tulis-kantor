<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Http\Request;

class PengeluaranBarangController extends Controller
{
    public function data(Request $request)
    {
        $date_range = $request->input('datefilter');

        if (strpos($date_range, ' - ') !== false) {
            $date_parts = explode(' - ', $date_range);

            $start_date = $date_parts[0];
            $end_date = $date_parts[1];

            $pengeluaran = Submission::where('status', 'finish')
                ->when($request->has('user') != "" && $request->user != "", function ($query) use ($request) {
                    $query->where('user_id', $request->user);
                })
                ->when($request->has('semester') != "" && $request->semester != "", function ($query) use ($request) {
                    $query->where('semester_id', $request->semester);
                })
                ->when(
                    $request->datefilter != "",
                    function ($query) use ($start_date, $end_date) {
                        $query->whereBetween('date', [$start_date, $end_date]);
                    }
                )
                ->orderBy('created_at', 'DESC');
        } else {
            $pengeluaran = Submission::where('status', 'finish')
                ->when($request->has('user') != "" && $request->user != "", function ($query) use ($request) {
                    $query->where('user_id', $request->user);
                })
                ->when($request->has('semester') != "" && $request->semester != "", function ($query) use ($request) {
                    $query->where('semester_id', $request->semester);
                })
                ->orderBy('created_at', 'DESC'); // query kosong
        }

        return datatables($pengeluaran)
            ->addIndexColumn()
            ->editColumn('date', function ($pengeluaran) {
                return tanggal_indonesia($pengeluaran->date);
            })
            ->addColumn('code', function ($pengeluaran) {
                return '<span class="badge badge-success">' . $pengeluaran->code . '</span>';
            })
            ->addColumn('product', function ($pengeluaran) {
                return $pengeluaran->product->name;
            })
            ->addColumn('quantity', function ($pengeluaran) {
                return $pengeluaran->quantity;
            })
            ->addColumn('user', function ($pengeluaran) {
                return $pengeluaran->user->name;
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function index(Request $request)
    {
        $users = User::whereRelation('role', 'role_id', 2)->get();
        $semesters = Semester::orderBy('created_at', 'DESC')->get();
        $semesterAktif = Semester::active()->pluck('id');

        return view('pengeluaran.index', compact(['users', 'semesters', 'semesterAktif']));
    }
}
