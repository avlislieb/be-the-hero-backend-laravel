<?php

namespace App\Http\Controllers;

use App\Models\Incidents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    public function index(Request $request)
    {
        $validator = Validator::make(['authorization' => $request->header('authorization')], [
            'authorization' => ['required', 'string', 'exists:ongs,id']
        ]);

        if($validator->fails())
            return response()->json($validator->errors()->toArray(),422);

        $listIncidents = Incidents::with('ong')->where('ong_id', $request->header('authorization'))->get();

        return response()->json($listIncidents, 200);
    }
}
