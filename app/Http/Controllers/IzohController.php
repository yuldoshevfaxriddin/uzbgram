<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class IzohController extends Controller
{
    public function store(Request $request){
        
        $user_id = 3;
        $message = $request->message;
        $retsept_id = $request->retsept_id;

        Comment::create([
            'retsept_id' => $retsept_id,
            'user_id' => $user_id,
            'description' => $message,
        ]);
        return redirect()->back();
    }
}
