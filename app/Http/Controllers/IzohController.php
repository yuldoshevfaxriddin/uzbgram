<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izoh;

class IzohController extends Controller
{
    public function store(Request $request){
        
        Izoh::create([
            'retsept_id' => $request->retsept_id,
            'user_id' => $request->user_id,
            'description' => $request->message,
        ]);
        return redirect()->back();
    }
}
