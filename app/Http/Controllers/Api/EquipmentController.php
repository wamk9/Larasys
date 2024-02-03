<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company\Equipment\Equipment;

class EquipmentController extends Controller
{
    public function create(Request $request)
    {
        try
        {
            $dataGetted = $request->only([
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
            ]);

            $equipment = Equipment::where([
                ['reference_code', $dataGetted['reference_code']],
                ['company_id', $dataGetted['company_id']]
            ])->first();


            if(!is_null($equipment))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Reference code exists in this company.'
                ], 401);
            }

            $equipment = Equipment::create($dataGetted);
            $equipment->save();

            return response()->json([
                'message' => 'success'
            ], 200);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $dataGetted = $request->only([
                'id',
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
            ]);

            $equipment = Equipment::where([
                ['id', $dataGetted['id']],
                ['company_id', $dataGetted['company_id']]
            ]);

            if(!$equipment)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Equipment don\'t exists.'
                ], 401);
            }
            $equipment->update($dataGetted);

            return response()->json([
                'message' => 'success'
            ], 200);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function delete(Request $request)
    {
        try
        {
            $dataGetted = $request->only([
                'id',
                'company_id'
            ]);

            $equipment = Equipment::where([
                ['id', $dataGetted['id']],
                ['company_id', $dataGetted['company_id']]
            ])->first();

            if(!$equipment)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Equipment don\'t exists.'
                ], 401);
            }

            if ($equipment->orders->count() > 0 || $equipment->stocks->count() > 0)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Material has one or more distributions.'
                ], 401);
            }

            $equipment->delete();

            return response()->json([
                'message' => 'success'
            ], 200);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function list(Request $request)
    {
        try
        {
            $dataGetted = $request->only([
                'company_id',
            ]);

            $material = Equipment::selectRaw('equipments.*, IF(COUNT(order_has_equipments.id) > 0 OR COUNT(stock_has_equipments.id) > 0, 0, 1) AS can_exclude')
            ->where([
                ['equipments.company_id', '=', $dataGetted['company_id']]
            ])
            ->leftJoin('stock_has_equipments', 'equipments.id', '=', 'stock_has_equipments.equipment_id')
            ->leftJoin('order_has_equipments', 'equipments.id', '=', 'order_has_equipments.equipment_id')
            ->groupby('equipments.id')
            ->get();

            return response()->json([
                'message' => $material
            ], 200);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
