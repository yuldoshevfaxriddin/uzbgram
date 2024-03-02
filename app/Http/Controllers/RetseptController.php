<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retsept;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RetseptController extends Controller
{
    public function index(){
        $retsepts = Retsept::all();
        return view('retsept.index',['retsepts'=>$retsepts]);
    }
    
    public function filter(Retsept $retsept){
    
        $retsepts = Retsept::where('name',$retsept->name)->get();
        return view('retsept.index',['retsepts'=>$retsepts]);
    }

    public function show(Retsept $retsept){
        // $retsepts = DB::table('retsepts')->orderBy('name')->distinct()->get();
        // dd($retsepts);
        return view('retsept.single',['retsept'=>$retsept]);
    }

    public function create(){
        return view('retsept.add');
    }

    public function user_profil(User $user){
        $retsepts = $user->retsepts;
        return view('retsept.index',['retsepts'=>$retsepts]);
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
        $path = $request->file('image')->store('images');
        $retsept->name = $request->name;
        $retsept->message = $request->message;
        $retsept->image = $path;
        $retsept->update();
        return redirect()->route('retsept-show',$retsept)->with('status','Malumot o\'zgartirildi');
    }

    public function destroy(Retsept $retsept){
        \Illuminate\Support\Facades\Storage::delete($retsept->image);
        $retsept->delete();
        return redirect()->route('retsept-index')->with('status',' eleted Successfully');
    }

}
