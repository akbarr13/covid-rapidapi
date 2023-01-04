<?php

namespace App\Models;

use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CovidData extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'continent',
        'country',
        'population',
        'total_case'
    ];

    public $sortable = [
        'id',
        'continent',
        'country',
        'population',
        'total_case',
        'created_at',
        'updated_at'
    ];
}
