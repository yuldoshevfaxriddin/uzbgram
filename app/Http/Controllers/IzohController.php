<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Retsept;

class IzohController extends Controller
{
    public function store(Request $request){
        

        $user_id = 1; //user_id = 1 bu anonim user hisoblanadi
        $user = auth()->user();
        if($user){
            $user_id = $user->id;
        }
        
        $message = $request->message;
        $retsept_id = $request->retsept_id;
        Comment::create([
            'retsept_id' => $retsept_id,
            'user_id' => $user_id,
            'description' => $message,
        ]);
        
        return redirect()->back()->with('status','Izoh qabul qilindi');
        
    }
    public function ball(Request $request){
        $user = auth()->user();
        if($user){
            $retsept_id = $request->retsept_id;
            $retsept = Retsept::find($retsept_id);
            $ball = $request->qiymat;
            $like = Like::where('user_id',$user->id)->where('retsept_id',$retsept_id)->first();
            if(! $like){
                Like::create([
                    'user_id'=>$user->id,
                    'retsept_id'=>$retsept_id,
                    'ball'=>$ball,
                ]);

                $like_cnt = 0 ;
                $like_avg = 0 ;
                $user_temp = $retsept->user;
                // foydalanuvchini reytingini aniqlash
                foreach($user_temp->retsepts as $retsept_temp){
                    if(count($retsept_temp->like)!=0){
                        // dd(count($user->retsepts[0]->like),count($user->retsepts[1]->like));
                        $like_avg += $retsept_temp->like->avg('ball');
                        $like_cnt +=1;
                    }
                }
                $reyting = null;
                if($like_cnt!=0){
                    $reyting = $like_avg/$like_cnt ;
                }
                $message['avg_qiymat']=round($retsept->like->avg('ball'),1);
                $message['reyting']=round($reyting,1);
                $message['qiymat']=$ball;
                $message['message']="malumot saqlandi";
                return response()->json($message);
            }

            // return "if bu";
            $like->ball=$ball;
            $like->update();

            $like_cnt = 0 ;
            $like_avg = 0 ;
            $user_temp = $retsept->user;
            // foydalanuvchini reytingini aniqlash
            foreach($user_temp->retsepts as $retsept_temp){
                if(count($retsept_temp->like)!=0){
                    // dd(count($user->retsepts[0]->like),count($user->retsepts[1]->like));
                    $like_avg += $retsept_temp->like->avg('ball');
                    $like_cnt +=1;
                }
            }
            $reyting = null;
            if($like_cnt!=0){
                $reyting = $like_avg/$like_cnt ;
            }
            $message['avg_qiymat']=round($retsept->like->avg('ball'),1);
            $message['qiymat']=$ball;
            $message['reyting']=round($reyting,1);
            $message['message']="malumot uzgartirildi";
            return response()->json($message);
        }
        $message['qiymat']=0;
        $message['avg_qiymat']='null';
        $message['message']="siz ro'yhatdan o'tmagansiz";
        return response()->json($message);
    }
}
