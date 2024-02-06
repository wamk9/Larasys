<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company\Material\MaterialDistribution;
use Illuminate\Http\Request;

class MaterialDistributionController extends Controller
{
    public function create(Request $request)
    {
        try
        {
            $dataGetted = $request->only([
                'material_id',
                'company_id',
                'reference_code',
                'quantity_bought',
                'quantity_used',
                'price',
                'bought_at',
                'description'
            ]);

            $material = MaterialDistribution::create($dataGetted);
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
                'material_id',
                'company_id',
                'quantity_bought',
                'quantity_used',
                'price',
                'bought_at',
                'description'
            ]);

            $material = MaterialDistribution::where([
                ['id', $dataGetted['id']],
                ['material_id', $dataGetted['material_id']],
                ['company_id', $dataGetted['company_id']]
            ]);

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
                'material_id',
                'company_id'
            ]);

            $material = MaterialDistribution::where([
                ['id', $dataGetted['id']],
                ['material_id', $dataGetted['material_id']],
                ['company_id', $dataGetted['company_id']],
                ['quantity_used', 0]
            ]);

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
                'material_id',
                'company_id',
            ]);

            $material = MaterialDistribution::selectRaw('material_distributions.*, IF(material_distributions.quantity_used = 0, 1, 0) as can_exclude')
            ->where([
                ['material_distributions.company_id', '=', $dataGetted['company_id']],
                ['material_distributions.material_id', '=', $dataGetted['material_id']]
            ])
            ->groupby('material_distributions.id')
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
