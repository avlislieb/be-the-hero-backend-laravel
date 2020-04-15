<?php

namespace App\Http\Controllers;

use App\Models\Ongs;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class SessionController extends Controller
{

    public function store(Request $request)
    {
        $id = $request->post('id', '');
        $ong = (object) null;

        try{
            $ong = Ongs::select('name')->findOrFail($id);
        }catch(\Exception $e){

            return response()->json([
                'error' => 'No ONG found with this ID'
            ], 400);
        }


        return response()->json($ong, 200);
    }

}
