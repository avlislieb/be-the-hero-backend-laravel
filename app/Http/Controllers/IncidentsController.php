<?php

namespace App\Http\Controllers;

use App\Models\Incidents;
use App\Models\Ongs;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class IncidentsController extends Controller
{

    public function index(Request $request)
    {
        $validator = Validator::make($request->query(), [
            'page' => ['numeric']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toArray(), 422);
        }
        $page = (int) $request->get('page', 1);

        $listIncidents = Incidents::with('ong:id,name,email')
            ->skip((($page - 1) * 5))
            ->take(5)
            ->get();

        return response()->json($listIncidents, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(array_merge(['authorization' => $request->header('authorization')], $request->all()),[
            'authorization' => ['required', 'string', 'exists:ongs,id'],
            'title' => ['required', 'string', 'min:3'],
            'description' => ['required', 'string'],
            'value' => ['required', 'numeric'],
            'image' => ['required']
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toArray(), 422);
        }

        try {
            DB::beginTransaction();

            $dataInsert = $request->all();
            $ong = Ongs::findOrFail($request->header('authorization'));

            $dataInsert['image'] = null;
            if ($request->file('image')->isValid()) {
                $dataInsert['image'] = $request->file('image')->storeAs(
                    'incidents/images', $request->file('image')->hashName()
                );
            }

            ['id' => $id] = $ong->Incidents()->create($dataInsert);

            DB::commit();
            return response()->json([ 'id' => $id ], 201);
        } catch(\Exception $e) {
            DB::rollback();
            Log::error('store', [
                'error' => $e
            ]);
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show($id, Request $request)
    {
        $validator = Validator::make(['id' => $id], [
            'id' => [
                'required',
                'numeric',
                'exists:incidents,id',
            ]
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toArray(), 422);
        }

        $incidents = Incidents::with('Ongs')->find($id);

        return response()->json($incidents, 200);
    }

    public function delete(Request $request, $id)
    {
        $validator = Validator::make(array_merge(
            ['id' => $id],
            ['authorization' => $request->header('authorization')]),
            [
                'authorization' => ['required', 'string', 'exists:ongs,id'],
                'id' => [
                    'required',
                    'numeric',
                    'exists:incidents,id',
                    Rule::exists('incidents')->where(function($query)use($id, $request){
                        $query->where('id', $id)->where('ong_id', $request->header('authorization'));
                    })
                ]
            ]
        );

        if($validator->fails()){
            return response()->json($validator->errors()->toArray(), 422);
        }
        try{
            DB::beginTransaction();
                Incidents::destroy($id);
            DB::commit();
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Operation not permitted.'
            ], 400);
        }

        return Response::make('', 204);
    }
}
