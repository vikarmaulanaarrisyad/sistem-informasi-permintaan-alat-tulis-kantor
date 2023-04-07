<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submission extends Model
{
    use HasFactory;
    protected $table = 'submissions';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function textColor()
    {
        $color = "";

        switch ($this->status) {
            case 'submit':
                $color = 'warning';
                break;

            case 'process':
                $color = 'info';
                break;

            case 'finish':
                $color = 'success';
                break;

            default:
                break;
        }

        return $color;
    }
}
