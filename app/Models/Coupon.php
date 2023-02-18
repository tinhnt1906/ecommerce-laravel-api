<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'type', 'value', 'status', 'description'];
    public static function findByCode($code)
    {
        return self::where('code', $code)->first();
    }

    public function discount($total)
    {
        if ($this->type == "fixed") {
            return $total - $this->value;
        } elseif ($this->type == "percent") {
            // return ($this->value / 100) * $total;
            return $total * (100 - $this->value) / 100;
        } else {
            return $total;
        }
    }
}
