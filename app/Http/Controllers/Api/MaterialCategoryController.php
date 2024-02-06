<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company\Material\MaterialCategory;
use Illuminate\Http\Request;

class MaterialCategoryController extends Controller
{
    public function create(Request $request)
    {
        try
        {
            $dataGetted = $request->only([
                'name',
                'company_id',
            ]);

            $materialCategory = MaterialCategory::where([
                ['name', $dataGetted['name']],
                ['company_id', $dataGetted['company_id']]
            ])->first();


            if(!is_null($materialCategory))
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Category name exists in this company.'
                ], 401);
            }

            $materialCategory = MaterialCategory::create($dataGetted);
            $materialCategory->save();

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
                'name',
                'company_id'
            ]);

            $materialCategory = MaterialCategory::where([
                ['id', $dataGetted['id']],
                ['company_id', $dataGetted['company_id']]
            ]);

            if(!$materialCategory)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Material category don\'t exists.'
                ], 401);
            }
            $materialCategory->update($dataGetted);

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

            $materialCategory = MaterialCategory::where([
                ['id', $dataGetted['id']],
                ['company_id', $dataGetted['company_id']]
            ])->first();

            if(!$materialCategory)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Material category don\'t exists.'
                ], 401);
            }

            if ($materialCategory->materials->count() > 0)
            {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => 'Material category has one or more materials.'
                ], 401);
            }

            $materialCategory->delete();

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

            $materialCategory = MaterialCategory::selectRaw('material_categories.*, IF(COUNT(materials.id) > 0, 0, 1) AS can_exclude')
            ->where([
                ['material_categories.company_id', '=', $dataGetted['company_id']]
            ])
            ->leftJoin('materials', 'materials.material_category_id', '=', 'material_categories.id')
            ->groupby('material_categories.id')
            ->get();

            return response()->json([
                'message' => $materialCategory
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
