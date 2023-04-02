<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Semester extends Model
{
    use HasFactory;

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('status', 'Aktif');
    }

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
