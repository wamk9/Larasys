<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company\Material\Material;
use App\Models\Company\Material\MaterialDistribution;
use Illuminate\Support\Facades\Redis;

class MaterialController extends Controller
{
    public function create(Request $request)
    {
        try
        {
            $dataGetted = $request->only([
                'reference_code',
                'company_id',
                'name',
                'description',
                'unit_of_measurement'
            ]);

            $material = Material::where([
                ['reference_code', $dataGetted['reference_code']],
                ['company_id', $dataGetted['company_id']]
            ])->first();


            if(!is_null($material))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Reference code exists in this company.'
                ], 401);
            }

            $material = Material::create($dataGetted);
            $material->save();

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
                'description',
                'unit_of_measurement'
            ]);

            $material = Material::where([
                ['id', $dataGetted['id']],
                ['company_id', $dataGetted['company_id']]
            ]);

            if(!$material)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Material don\'t exists.'
                ], 401);
            }
            $material->update($dataGetted);

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

            $material = Material::where([
                ['id', $dataGetted['id']],
                ['company_id', $dataGetted['company_id']]
            ])->first();

            if(!$material)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Material don\'t exists.'
                ], 401);
            }

            if ($material->distributions->count() > 0)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Material has one or more distributions.'
                ], 401);
            }

            $material->delete();

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

            $material = Material::selectRaw('materials.*, IF(SUM(material_distributions.quantity_used) IS NOT NULL, SUM(material_distributions.quantity_used), 0) as quantity_used, IF((SUM(material_distributions.quantity_used) - SUM(material_distributions.quantity_bought)) IS NOT NULL, (SUM(material_distributions.quantity_bought) - SUM(material_distributions.quantity_used)), 0) AS remaining_quantity, IF(COUNT(material_distributions.id) > 0, 0, 1) AS can_exclude')
            ->where([
                ['materials.company_id', '=', $dataGetted['company_id']]
            ])
            ->leftJoin('material_distributions', 'materials.id', '=', 'material_distributions.material_id')
            ->groupby('materials.id')
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
    //
}
