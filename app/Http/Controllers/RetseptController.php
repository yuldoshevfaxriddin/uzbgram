<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retsept;

class RetseptController extends Controller
{
    public function index(){
        return view('retsept.index',['retsepts'=>Retsept::all()]);
    }

    public function show(Retsept $retsept){
        return view('retsept.single',['retsept'=>$retsept]);
    }

    public function create(){
        return view('retsept.add');
    }

    public function store(Request $request){
        $path = $request->file('image')->store('images');
        $retsept = new Retsept;
        $retsept->name = $request->name;
        $retsept->user_id = 3;
        $retsept->message = $request->message;
        $retsept->image = $path;
        $retsept->save();
        return redirect()->route('retsept-index')->with('status','Malumot saqlandi');
    }

    public function edit(Retsept $retsept){
        return view('retsept.edit',['retsept'=>$retsept]);
    }

    public function update(Request $request,Retsept $retsept){
        \Illuminate\Support\Facades\Storage::delete($retsept->image);
        $retsept->name = $request->name;
        $retsept->message = $request->message;
        $retsept->image = $request->image;
        $retsept->update();
        return redirect()->route('retsept-show',$retsept)->with('status','Malumot o\'zgartirildi');
    }

    public function destroy(Retsept $retsept){
        \Illuminate\Support\Facades\Storage::delete($retsept->image);
        $retsept->delete();
        return redirect()->route('retsept-index')->with('status',' eleted Successfully');
    }
   
}
