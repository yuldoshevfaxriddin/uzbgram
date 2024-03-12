<?php

namespace App\Http\Controllers;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\Retsept;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class RetseptController extends Controller
{
    public function index(){
        $retsepts = Retsept::orderBy('id','desc')->get();
        return view('retsept.index',['retsepts'=>$retsepts]);
    }

    public function filter(Retsept $retsept){
        $retsepts = Retsept::where('name',$retsept->name)->orderBy('id','desc')->get();
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
        $reyting = null ;
        if($like_cnt!=0){
            $reyting = $like_avg/$like_cnt ;
        }
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
            $validated = $request->validate([
                'name' => 'required|min:2',
                'message' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
            ] , [
        'name.required' => 'Nomini yozish majburiy',
        'message.required' => 'Matn yozish majburiy',
        'image.required' => 'Rasm joylash majburiy',
        'image.mimes' => 'Quyidagi formatlarda jo\'nating: jpeg,jpg,png,gif',
        'image.max' => 'Rasm hajmi 2 mb dan oshmasin',
     ]);
//            dd($validated);
            $path = $request->file('image')->store('images');
            $retsept = new Retsept;
            $retsept->name = $request->name;
            $retsept->user_id = $user->id;
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
            return redirect()->route('retsept-index')->with('status','Malumot o\'zgartirildi');
        }
        return redirect()->route('retsept-show',$retsept);
    }

    public function destroy(Retsept $retsept){
        $user = auth()->user();
        if(! $user){
            return redirect()->route('retsept-index');
        }
        if($retsept->user->id == $user->id){
            foreach($retsept->like as $like){
                $like->delete();
            }
            foreach($retsept->comments as $comment){
                $comment->delete();
            }
            \Illuminate\Support\Facades\Storage::delete($retsept->image);
            $retsept->delete();
            return redirect()->route('retsept-index')->with('status','Malumot o\'chirildi');
        }
        return redirect()->route('retsept-index');

    }

}
