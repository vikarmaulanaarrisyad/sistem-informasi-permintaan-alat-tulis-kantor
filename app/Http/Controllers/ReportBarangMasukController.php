<?php

namespace App\Http\Controllers;

use App\Models\ProductIn;
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

        while (strtotime($start) <= strtotime($end)) {
            $barangMasuk = ProductIn::where('date', 'LIKE', "%$start%")
                ->get();

            $separate = '';
            if ($escape) $separate = ',-';

            $row = [];
            $row['DT_RowIndex'] = $i++;
            $row['tanggal'] = tanggal_indonesia($start);

            if (!$barangMasuk->isEmpty()) {
                $row['product'] = $barangMasuk[0]->product->name;
                $row['stock'] = $barangMasuk[0]->quantity;
            } else {
                $row['product'] = '-';
                $row['stock'] = 0;
            }

            array_push($data, $row);

            $start = date('Y-m-d', strtotime('+1 day', strtotime($start)));
        }

        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'product' => '',
            'stock' => '',
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
}
