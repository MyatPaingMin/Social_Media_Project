<?php

namespace App\Http\Controllers\apiList;

use Carbon\Carbon;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function createComment(Request $req){

        if(!Gate::allows('comment-create',$req->userID)){
            abort(401);
        }else{
            $datacreate = $this->datacreate($req);
            Comment::create($datacreate);
            return 'success';
        }
    }

    public function updateComment(Request $req){

        $comment = Comment::find($req->commentID);

        if(!Gate::allows('comment-update', $comment)){
            logger('COMMENT UPDATE ABORTED');
            abort(401);
        }else{
            $dataupdate = $this->dataupdate($req);
            Comment::where('id','=',$req->commentID)->update($dataupdate);
            return 'updated Comment second time Successfully';
        }

    }

    private function dataupdate($data){
        $dataupdate = [
            'text' => $data->text,
            'updated_at' => Carbon::now()
        ];
        return $dataupdate;
    }

    private function datacreate($data){
        logger($data);
        $datacreate = [
            'user_id' => $data->userID,
            'post_id' => $data->postID,
            'text' => $data->text,
            'parent' => $data->parent,
        ];
        return $datacreate;
    }

    public function viewComment(Request $req){
        $comment = Comment::limit($req->lazy)->get();
        return $comment;
    }

    public function deleteComment($commentID){

        $comment = Comment::find($commentID);

        if(!Gate::allows('comment-delete', $comment)){
            abort(401);
        }else{
            Comment::where('id','=',$commentID)->first()->delete();
            return 'deleted';
        }
    }

    public function commentlist($id,$commentlimit){
        $comments = Comment::select('comments.*','comments.created_at as comment_time','users.id as commenter_id','users.name as commenter','users.profile as commenter_profile')
                            ->leftjoin('users','comments.user_id','=','users.id')
                            ->where('post_id','=',$id)
                            ->limit($commentlimit)
                            ->orderBy('comments.created_at','DESC')
                            ->get();
        return response()->json($comments);
    }

    public function onecomment($id,$commentID){
        $comments = Comment::select('comments.*','comments.created_at as comment_time','users.id as commenter_id','users.name as commenter','users.profile as commenter_profile')
                            ->leftjoin('users','comments.user_id','=','users.id')
                            ->where('post_id','=',$id)
                            ->where('comments.id','=',$commentID)
                            ->orderBy('comments.created_at','DESC')
                            ->get();
        return response()->json($comments);
    }
}
