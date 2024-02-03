<?php

namespace App\Models\Company\Equipment;

use App\Models\Company\Order\OrderHasEquipment;
use App\Models\Company\Stock\StockHasEquipment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;
    protected $table = 'equipments';
    protected $fillable = [
        'reference_code',
        'company_id',
        'name',
        'price',
        'bought_at',
        'depreciation',
        'max_date_return_value',
        'return_value',
        'use_value',
        'watts_consume'
    ];

    /**
     * Get all of the orders for the Equipment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(OrderHasEquipment::class, 'equipment_id');
    }

    /**
     * Get all of the stocks for the Equipment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stocks(): HasMany
    {
        return $this->hasMany(StockHasEquipment::class, 'equipment_id');
    }
}
