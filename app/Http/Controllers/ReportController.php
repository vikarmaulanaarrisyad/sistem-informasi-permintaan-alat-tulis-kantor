<?php

namespace App\Http\Controllers;

use App\Models\ProductIn;
use App\Models\Submission;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = now()->subDays(30)->format('Y-m-d');
        $end = date('Y-m-d');

        if ($request->has('start') && $request->start != "" && $request->has('end') && $request->end != "") {
            $start = $request->start;
            $end = $request->end;
        }

        return view('report.index', compact('start', 'end'));
    }

    public function getData($start, $end, $jenisLaporan)
    {
        $data = [];
        $i = 1;

        while (strtotime($start) <= strtotime($end)) {
            if ($jenisLaporan == 'masuk') {
                $result = ProductIn::whereDate('date', $start)->get();
            } else {
                $result = Submission::whereDate('date', $start)->get();
            }

            if ($result->isNotEmpty()) {
                $row = [];
                $row['DT_RowIndex'] = $i++;
                $row['product'] = $result[0]->product->name;
                $row['tanggal'] = $result[0]->date;

                array_push($data, $row);
            }

            $start = date('Y-m-d', strtotime('+1 day', strtotime($start)));
        }

        $data[] = [
            'DT_RowIndex' => '',
            'product' => '',
            'tanggal' => '',
        ];

        return $data;
    }

    public function data(Request $request)
    {
        $dateRange = $request->datefilter;
        $jenisLaporan = $request->laporan;

        if (strpos($dateRange, ' - ') !== false || $dateRange != "") {
            $dateParts = explode(' - ', $dateRange);

            $start = $dateParts[0];
            $end = $dateParts[1];

            $data = $this->getData($start, $end, $jenisLaporan);
        } else {
            $start = now()->subDays(30)->format('Y-m-d');
            $end = date('Y-m-d');
            $data = $this->getData($start, $end, $jenisLaporan);
        }

        return datatables($data)
            ->escapeColumns([])
            ->make(true);
    }
}
