<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $semesterGanjil = new Semester();
        $semesterGanjil->name = '2019-2020';
        $semesterGanjil->semester = 'Ganjil';
        $semesterGanjil->status = 'Tidak Aktif';
        $semesterGanjil->save();

        $semesterGenap = new Semester();
        $semesterGenap->name = '2019-2020';
        $semesterGenap->semester = 'Genap';
        $semesterGenap->status = 'Aktif';
        $semesterGenap->save();

    }
}
