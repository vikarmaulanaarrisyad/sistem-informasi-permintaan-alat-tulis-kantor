<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductIn;
use App\Models\Semester;
use App\Models\Submission;
use Illuminate\Http\Request;

class ReportBarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $start = now()->subDays(30)->format('Y-m-d');
        $end = date('Y-m-d');

        if ($request->has('start') && $request->start != "" && $request->has('end') && $request->end != "") {
            $start = $request->start;
            $end   = $request->end;
        }

        return view('report.barang.masuk.index', compact('start', 'end'));
    }

    public function getData($start, $end, $escape = false)
    {
        $data = [];
        $i = 1;
        $semesterId = $this->semesterAktif();
        $previousStock = 0;

        while (strtotime($start) <= strtotime($end)) {
            $barangMasuk = ProductIn::where('date', 'LIKE', "%$start%")
            ->where('semester_id', $semesterId)
                ->get();

            $barangKeluar = Submission::where('date', 'LIKE', "%$start%")
            ->where('semester_id', $semesterId)
                ->get();

            $separate = '';
            if ($escape) $separate = ',-';

            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['tanggal'] = tanggal_indonesia($start);

            $stokMasuk = $barangMasuk->sum('quantity');
            $stokKeluar = $barangKeluar->sum('quantity');
            $sisaStok = $previousStock + $stokMasuk - $stokKeluar;

            $row['stok_masuk'] = $stokMasuk;
            $row['stok_keluar'] = $stokKeluar;
            $row['sisa_stok'] = $sisaStok;

            array_push($data, $row);

            $previousStock = $sisaStok;
            $start = date('Y-m-d', strtotime('+1 day', strtotime($start)));
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'stok_masuk' => '',
            'stok_keluar' => '',
            'sisa_stok' => '',
        ];

        return $data;
    }

    public function data($start, $end)
    {
        $data = $this->getData($start, $end);

        return datatables($data)
            ->escapeColumns([])
            ->make(true);
    }

    public function semesterAktif()
    {
        return Semester::active()->pluck('id')->first();
    }
}
