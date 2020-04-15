<?php

namespace App\Http\Controllers;

use App\Models\Ongs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class OngsController extends Controller
{
    /**
     * lista de todas as ongs
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $listOngs = Ongs::all();
        return response()->json($listOngs);
    }

    /**
     * salvar uma ong
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $id = substr(uniqid('', true), 15);

        $validator = Validator::make(array_merge(['id' => $id], $request->all()), [
            'id' => ['required', 'unique:ongs'],
            'name' =>  ['string', 'required', 'min:3'],
            'email' => ['string', 'required', 'email', 'unique:ongs'],
            'whatsapp' => ['numeric', 'required', 'min:10'],
            'city' => ['string', 'required'],
            'uf' => ['string', 'required', 'size:2']
        ]);


        if($validator->fails()){
            return response()->json($validator->errors()->toArray(), 422);
        }

        try{
            DB::beginTransaction();

            Ongs::create([
                'id' => $id,
                'name' => $request->post('name', ''),
                'email'=> $request->post('email', ''),
                'whatsapp' => $request->post('whatsapp', ''),
                'city' => $request->post('city', ''),
                'uf' => $request->post('uf', '')
            ]);

            DB::commit();
        }catch(\Exception $e){
            DB::rollback();

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }

        return response()->json(['id' => $id] , 201);
    }
}
