<?php

namespace App\Http\Controllers;
use App\Models\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ActionController extends Controller
{
    public function postViewInc(Request $req){
        if(
            Action::where('post_id',$req->post_id)
                ->where('user_id',$req->user_id)
                ->exists()
          )
        {
            Action::where('post_id',$req->post_id)
                    ->where('user_id',$req->user_id)
                    ->update(['view' => 1]);
            return 'UPDATED';
        }else{
            Action::create([
                'post_id' => $req->post_id,
                'user_id' => $req->user_id,
                'view' => 1
            ]);

            return 'CREATED';
        }
    }

    public function giveReact(Request $req){
        $datacreate = $this->datacreate($req);

        Action::create($datacreate);
        return 'success';
    }

    public function changeReact(Request $req){
        $action = Action::where('user_id','=',$req->userID)
                        ->where('post_id','=',$req->postID)
                        ->first();
        logger($action);

        if(Gate::denies('update_action',$action)){
            abort(401);
        }else{
            Action::where('user_id','=',$req->userID)
                    ->where('post_id','=',$req->postID)
                    ->update(['react'=>$req->react]);
            return 'success';
        }

    }

    private function datacreate($data){
        $datacreate = [
            'user_id' => auth()->user()->id,
            'post_id' => $data->postID,
            'react' => $data->react,
        ];
        return $datacreate;
    }

    public function deleteReact(Request $req){
        Action::where('user_id','=',$req->userID)
                ->where('post_id','=',$req->postID)
                ->delete();
        return 'success';
    }


    public function reactpost(Request $req){
        logger('Request Action');
        logger($req);

        // $reaction = $this.reaction($req->react);

        $userID = $req->userid;
        $postID = $req->postid;
        $userReaction = $req->react;

        $react = $this->reactValue($postID, $userID);
        logger($react);

        Action::when($react == 'empty' && $req->react == 'like', function($query) use ($userID, $postID){
                    $query -> create($this->reactionCreate($userID, $postID, 1));
                })
                ->when($react == 'empty' && $req->react == 'dislike', function($query) use ($userID, $postID){
                    $query -> create($this->reactionCreate($userID, $postID, 2));
                })
                ->when($react != 'empty',function($query) use ($userID,$postID,$react,$userReaction){
                    $query ->where('post_id','=',$postID)
                    ->where('user_id','=',$userID)
                    ->when($userReaction == 'like',function($query) use ($userID, $postID, $react){
                        $query -> when($react == 1 ,function($query) use ($react){
                                    $query -> update($this->reaction(0));
                                })
                                ->when($react != 1, function($query) use ($react){
                                    $query -> update($this->reaction(1));
                                });
                    })
                    ->when($userReaction == 'dislike',function($query) use ($userID, $postID, $react){
                        $query -> when($react == 2 ,function($query) use ($react){
                                    $query -> update($this->reaction(0));
                                })
                                ->when($react != 2, function($query) use ($react){
                                    $query -> update($this->reaction(2));
                                });
                    });
                });

        return 'success';
    }

    private function reactValue($postID,$userID){
        $reactValue = 'empty';

        // if(Gate::denies('view_action',$userID)){
        //     abort(401);
        // }else{
            $action = Action::where('post_id','=',$postID)
                            ->where('user_id','=',$userID)
                            ->first();
        // }

        if ($action) {
            $reactValue = $action->react;
        }
        return $reactValue;
    }

    private function reactionCreate($userID,$postID,$react){
        return [
            'user_id' => $userID,
            'post_id' => $postID,
            'react' => $react,
            'view' => 1
        ];
    }

    private function reaction($react){
        return [
            'react' => $react
        ];

    }


    public function reactlist($id,$reactlimit){
        $reactions = DB::table('actions as a')
                        ->leftjoin('users as u','u.id','a.user_id')
                        ->select('u.name','u.profile','u.id','a.react','u.gender')
                        ->where('react','<>','0')
                        ->where('post_id','=',$id)
                        ->limit($reactlimit)
                        ->get();
        return $reactions;
    }
}
