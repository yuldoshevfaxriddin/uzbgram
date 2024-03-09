<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Retsept;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
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
        // dd($retsept);
        $user = $retsept->user;
        $like_cnt = 0 ;
        $like_avg = 0 ;
        // foydalanuvchini reytingini aniqlash
        foreach($user->retsepts as $retsept_temp){
            if(count($retsept_temp->like)!=0){
                // dd(count($user->retsepts[0]->like),count($user->retsepts[1]->like));
                $like_avg += $retsept_temp->like->avg('ball');
                $like_cnt +=1;
            }
        }
        $reyting = $like_avg/$like_cnt ;
        return view('retsept.single',['retsept'=>$retsept,'reyting'=>$reyting]);
    }

    public function create(){
        if(auth()->user()){
            return view('retsept.add');
        }
        return redirect()->route('retsept-index');
    }

    public function user_profil(User $user){
        $retsepts = $user->retsepts;
        return view('retsept.index',['retsepts'=>$retsepts]);
    }

    public function store(Request $request){
        $user = auth()->user();
        if($user){
            $path = $request->file('image')->store('images');
            $retsept = new Retsept;
            $retsept->name = $request->name;
            $retsept->user_id = 3;
            $retsept->message = $request->message;
            $retsept->image = $path;
            $retsept->save();
            return redirect()->route('retsept-index')->with('status','Malumot saqlandi');

            }
        return redirect()->route('retsept-index');
   }

    public function edit(Retsept $retsept){
        $user = auth()->user();
        if($user){
            if($user->id == $retsept->user->id){
                return view('retsept.edit',['retsept'=>$retsept]);
            }
        }
        return redirect()->route('retsept-index');
    }

    public function update(Request $request,Retsept $retsept){
        $user = auth()->user();
        if(! $user){
            return redirect()->route('retsept-index');
        }
        if($retsept->user->id == $user->id){
            if($request->file('image')){
                \Illuminate\Support\Facades\Storage::delete($retsept->image);
                $path = $request->file('image')->store('images');
                $retsept->image = $path;
            }
            $retsept->name = $request->name;
            $retsept->message = $request->message;
            $retsept->update();
            return redirect()->route('retsept-index');
    
        }
        return redirect()->route('retsept-show',$retsept)->with('status','Malumot o\'zgartirildi');
    }
    
    public function destroy(Retsept $retsept){
        $user = auth()->user();
        if(! $user){
            return redirect()->route('retsept-index');
        }
        if($retsept->user->id == $user->id){
            \Illuminate\Support\Facades\Storage::delete($retsept->image);
            foreach($retsept->comments as $comment){
                $comment->delete();
            }
            $retsept->delete();
            return redirect()->route('retsept-index')->with('status',' eleted Successfully');
        }
        return redirect()->route('retsept-index');
        
    }

}
