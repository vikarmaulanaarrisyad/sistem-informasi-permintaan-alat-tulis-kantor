<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\Semester;
use App\Models\Submission;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $semester = $this->semesterAktif();

        if (Auth::user()->hasRole('admin')) {

            $users = User::where('role_id', 2)->count();
            $kategori = Category::count();
            $totalBarang = Product::count();
            $supplier = Supplier::count();
            $totalBarangMasuk = ProductIn::where('semester_id', $semester->id)->count();
            $totalBarangKeluar = Submission::where('status', 'finish')->where('semester_id', $semester->id)->count();
            $pengajuanBelumDikonfirmasi = Submission::where('status', 'process')->where('semester_id', $semester->id)->count();


            return view('dashboard.admin.index', compact([
                'users',
                'kategori',
                'totalBarang',
                'supplier',
                'totalBarangMasuk',
                'totalBarangKeluar',
                'pengajuanBelumDikonfirmasi',
            ]));
        } else {

            $semesterAktif = Semester::active()->first();
            return view('dashboard.user.index', compact('semesterAktif'));
        }
    }

    public function semesterAktif()
    {
        return Semester::active()->first();
    }

    public function getAjuanByUser()
    {
        $ajuan = Submission::whereHas('semester', function ($query) {
            $query->where('status', 'Aktif');
        })->where('user_id', auth()->user()->id)
            ->get();

        dd($ajuan);
    }
}
