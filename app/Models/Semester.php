<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory;

    public function statusColor()
    {
        $color = '';

        switch ($this->status) {
            case 'Aktif':
                $color = 'success';
                break;

            case 'Tidak Aktif':
                $color = 'danger';
                break;

            default:
                # code...
                break;
        }
        return $color;
    }
}
