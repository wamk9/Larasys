<?php

namespace App\Models\Company\Material;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'material_id',
        'company_id',
        'quantity_bought',
        'quantity_used',
        'price',
        'bought_at',
        'description'
    ];
}
