<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Action;
use App\Models\Comment;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function getPost(){
        return true;
    }

    //adminhome start
    public function adminhome(){
        // $posts = Post::select('posts.id','image','title','description','users.name as creater_name','users.profile','users.name as creater','users.gender','categories.category_name as category_name','view_count','posts.updated_at')
        //                 ->leftJoin('users','users.id','posts.user_id')
        //                 ->leftJoin('categories','categories.id','posts.category_id')
        //                 ->when(request('searchkey'),function($query){
        //                     $query->where('title','like','%'.request('searchkey').'%')
        //                           ->orWhere('description','like','%'.request('searchkey').'%');
        //                 })->orderBy('posts.updated_at','DESC')
        //                 ->get()->toArray();
        $role = Auth::user()['role'];
        if($role == 'admin_pending'){
            $user = User::where('id','=',Auth::user()['id'])->first();
            return view('admin.post.home',compact('user'));
        }else{
            $posts = Post::select([
                        'posts.id',
                        DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = posts.id AND a.react <> 0) AS react_count'),
                        DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = posts.id AND a.view = 1) AS view_count'),
                        DB::raw('(SELECT COUNT(*) FROM comments c WHERE c.post_id = posts.id) AS comment_count'),
                        'ad.name',
                        'ad.gender',
                        'ad.profile',
                        'posts.title',
                        'posts.description',
                        'posts.created_at',
                        'posts.updated_at',
                        'posts.image'
                    ])
                    ->join('users as ad', 'posts.user_id', '=', 'ad.id')
                    ->get()
                    ->toArray();
            // dd($posts);
            return view('admin.post.home',compact('posts'));
        }
    }
    //adminhome end

    //post list start
    public function listpost(){
        $posts = Post::select('posts.id','image','title','description','users.name as creater_name','users.profile','users.name as creater','users.gender','categories.category_name as category_name','view_count','posts.updated_at')
                        ->leftJoin('users','users.id','posts.user_id')
                        ->leftJoin('categories','categories.id','posts.category_id')
                        ->when(request('searchkey'),function($query){
                            $query->where('title','like','%'.request('searchkey').'%')
                                  ->orWhere('description','like','%'.request('searchkey').'%');
                        })->orderBy('posts.updated_at','DESC')
                        ->get();
        return view('admin.post.postlist',compact('posts'));
    }


    public function loadSearch(){
        // logger($_REQUEST['orderBy']);
        $posts = Post::select(['posts.id',
                                'image',
                                DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = posts.id AND a.view = 1) AS view_count'),
                                'title',
                                'description',
                                'users.name as creater_name',
                                'categories.category_name as category_name',
                                'posts.updated_at'
                             ])
                        ->leftJoin('users','users.id','posts.user_id')
                        ->leftJoin('categories','categories.id','posts.category_id')
                        ->when(request('searchkey'),function($query){
                            $query->where('title','like','%'.request('searchkey').'%')
                                  ->orWhere('description','like','%'.request('searchkey').'%');
                        })->when(request('sortBy'),function($query){
                            $query-> orderBy(request('sortBy'),'DESC');

                            // when(request('sortBy'),'=','interest'),function($order){
                            //             $order  -> leftJoin('actions','actions.post_id','posts.id')
                            //                     ->
                            //         }->when(request('sortBy','!=','interest'),function($order){
                            //             $order -> orderBy(request('sortBy'),'DESC');
                            //         });
                        })->when(request('category'),function($query){
                            $query->where('category_id','=',request('category'));
                        })->get()->toArray();

        return response()->json($posts);
    }

    //post list end


    //createPost start
    public function createPostPage(){
        $categories = Category::get();
        return view('admin.post.postcreate',compact('categories'));
    }
    public function CU_Post(Request $req){
        $valid = $this->dataValidation($req);
        if($valid->fails()){
            return back()->withErrors($valid)->withInput();
        };

        $dataArray = $this->dataArray($req);
        if($req->hasFile('image') == true){
            $filename = uniqid().'_'.$req->image->getClientOriginalName();
            $fileValid = $this->fileValidate($req);
            if($fileValid->fails()){
                return back()->withErrors($fileValid)->withInput();
            }

            //For update
            if($req->id){
                $oldname = Post::where('id',$req->id)->first()['image'];
                if($oldname != NULL){
                    // dd($oldname);
                    Storage::delete('public/post/'.$oldname);
                }
            }

            $req->image->move(public_path().'/storage/post',$filename);
            $dataArray['image'] = $filename;
        }

        // dd($req->all());

        if($req->id){
            $dataArray['updated_admin'] = Auth::user()['id'];
            Post::where('id',$req->id)->update($dataArray);
            return redirect()->route('admin#profile')->with(['updateSuccess' => 'Post updated successfully.']);
        }else{
            Post::create($dataArray);
            return redirect()->route('admin#profile')->with(['createSuccess' => 'Post created successfully.']);
        }
    }
    private function fileValidate($data){
        return Validator::make($data->all(),['image'=>'mimes:jpg,jpeg,png,webp'],['image.mimes'=>'File is not in the right format.']);
    }
    private function dataValidation($data){
        $invalidData = [
            'title' => 'required',
            'description' => 'required',
            'category' => 'required'
        ];
        $errorMsg = [
            'title.required' => 'Post title is required.',
            'description.required' => 'Post description is required.',
            'category.required' => 'Post category is required.'
        ];
        // dd($data->category);
        return Validator::make($data->all(),$invalidData,$errorMsg);
    }
    private function dataArray($data){
        return [
            'title' => $data->title,
            'description' => $data->description,
            'user_id' => Auth::user()['id'],
            'view_count' => 0,
            'category_id' => $data->category
        ];
    }
    //creatPost end

    //updatePost start
    public function updatePostPage($id){
        $post = Post::select('posts.id','title','description','posts.image','created_user.name as creater','categories.id as category_id','categories.category_name as category_name','view_count','posts.updated_at','updated_user.name as updated_by')
                    ->leftJoin('users as created_user','created_user.id','posts.user_id')
                    ->leftJoin('users as updated_user','updated_user.id','posts.updated_admin')
                    ->leftJoin('categories','categories.id','posts.category_id')
                    ->where('posts.id',$id)
                    ->first()->toArray();
        $categories = Category::get();
        return view('admin.post.postupdate',compact(['post','categories']));
    }

    public function updatePost(Request $req){
        return redirect()->route('admin#posts');
    }
    //updatePost end

    //DeletePost start
    public function deletePost($id){
        Post::where('id',$id)->delete();
        return redirect()->route('admin#listpost')->with(['deleteSuccess' => 'Post deleted successfully.']);
    }
    //deletePost end

    public function seePost($id){
        $post =  Post::select([
                        'posts.id',
                        DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = posts.id AND a.react <> 0) AS react_count'),
                        DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = posts.id AND a.view = 1) AS view_count'),
                        DB::raw('(SELECT COUNT(*) FROM comments c WHERE c.post_id = posts.id) AS comment_count'),
                        'ad.name as creater',
                        'ad.gender',
                        'ad.profile',
                        'posts.title',
                        'posts.description',
                        'posts.created_at',
                        'posts.updated_at',
                        'posts.image'
                    ])
                    ->leftJoin('users as ad', 'posts.user_id', '=', 'ad.id')
                    ->where('posts.id','=',$id)
                    ->first();

        $comments = $this->commentLoad($id,5);
        $reactions = $this->reactLoad($id);

        return view('admin.post.seepost',compact(['post','comments','reactions']));
    }

    public function commentLoad($id,$limit){
        $comments = Comment::select([
            'comments.text',
            'comments.created_at',
            'comments.updated_at',
            'u.name as commenter_name',
            'u.profile as commenter_profile',
            'u.gender',
            ])
        ->where('post_id','=',$id)
        ->leftJoin('users as u','u.id','comments.user_id')
        ->limit($limit)
        ->get();
        return $comments;
    }


    public function reactLoad($id){
        $reactions = Action::select([
            'actions.react',
            'actions.created_at',
            'actions.updated_at',
            'u.name as reacter_name',
            'u.profile as reacter_profile',
            'u.gender'
            ])
            ->where('post_id','=',$id)
            ->where('react','>',0)
            ->leftJoin('users as u','u.id','actions.user_id')
            // ->limit($limit)
            ->get();
        return $reactions;
    }
}
