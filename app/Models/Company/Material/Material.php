<?php

namespace App\Models\Company\Material;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_code',
        'company_id',
        'name',
        'description',
        'unit_of_measurement'
    ];

    /**
     * Get all of the distributions for the Material
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function distributions(): HasMany
    {
        return $this->hasMany(MaterialDistribution::class, 'id', 'material_id');
    }
}
