<?php

namespace App\Http\Controllers\apiList;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function allPost(){
        $posts = Post::all();

        return response()->json([
            'user' => auth()->user(),
            'posts' => $posts
        ]);
    }

    //postPage Start

    // public function postList(Request $req){
    //     logger($req);
    //     $react_count_subquery = DB::table('actions as a')
    //         ->select(DB::raw('COUNT(*)'))
    //         ->where('a.post_id', '=', 'p.id')
    //         ->where('a.react', '<>', 0);
    //     $view_count_subquery = DB::table('actions as a')
    //         ->select(DB::raw('COUNT(*)'))
    //         ->where('a.post_id', '=',  'p.id')
    //         ->where('a.view', '=', 1);
    //     $user_react_subquery = DB::table('actions as a')
    //         ->select('a.react')
    //         ->where('a.post_id', '=', 'p.id')
    //         ->where('a.user_id', '=', $req->userID);
    //     $posts = DB::table('posts as p')
    //         ->join('admins as ad', 'p.user_id', '=', 'ad.id')
    //         ->join('actions as a','p.id','=','a.post_id')
    //         ->leftJoinSub($user_react_subquery, 'action a', function ($join) {
    //             $join->on('a.post_id', '=', 'p.id');
    //         })
    //         // ->select(
    //         //     $react_count_subquery->as('react_count'),
    //         //     $view_count_subquery->as('view_count'),
    //         //     'ad.name', 'ad.photo', 'p.title', 'p.description', 'p.created_at', 'p.photo',
    //         //     'a.react as user_react'
    //         // )
    //         ->selectRaw('
    //             (' . $react_count_subquery->toSql() . ') as react_count,
    //             (' . $view_count_subquery->toSql() . ') as view_count,
    //             ad.name, ad.profile, p.title, p.description, p.created_at, p.image,
    //             a.react as user_react
    //         ')
    //         // ->where('p.id', '=', $req->post_id)
    //         ->addBinding($req->userID)
    //         ->get();
    //     return response()->json($posts);
    // }

    public function postList($userID,$postLimit){
        // dd($userID,$postLimit);
        // return $userID . $postLimit;
        // $query = DB::table(DB::raw('(
        //         SELECT
        //             p.id,
        //             (SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.react <> 0) AS react_count,
        //             (SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.view = 1) AS view_count,
        //             (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS comment_count,
        //             ad.name,
        //             ad.gender,
        //             ad.profile,
        //             p.title,
        //             p.description,
        //             p.created_at,
        //             p.updated_at,
        //             p.image,
        //             a.react AS user_react
        //         FROM posts p

        //         JOIN users ad ON p.user_id = ad.id
        //         LEFT JOIN actions a
        //         ON p.id = a.post_id AND a.user_id = :userID
        //         LIMIT :postLimit
        //     ) AS subquery'));

        //     // ->when(request('searchkey'),function($query){
        //     //         $query->where('p.title','like','%'.request('searchkey').'%')
        //     //               ->orWhere('p.description','like','%'.request('searchkey').'%');
        //     // })->orderBy('p.updated_at','DESC');


        //     //WHERE p.id = :post_id

        //     //$query->addBinding($req->post_id);
        //     $query->addBinding($userID);
        //     $query->addBinding($postLimit);

        //     $posts = $query->get();

        //     // return $posts;
        //         logger($posts);

        $posts = DB::table('posts as p')
                ->select([
                    'p.id',
                    DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.react <> 0) AS react_count'),
                    DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.view = 1) AS view_count'),
                    DB::raw('(SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS comment_count'),
                    'ad.name',
                    'ad.gender',
                    'ad.profile',
                    'p.title',
                    'p.description',
                    'p.created_at',
                    'p.updated_at',
                    'p.image',
                    'a.react AS user_react'
                ])

                ->join('users as ad', 'p.user_id', '=', 'ad.id')
                ->leftJoin('actions as a', function ($query) use ($userID) {
                    $query -> on('p.id', '=', 'a.post_id')
                           -> where('a.user_id', '=', $userID);
                })
                ->limit($postLimit)
                ->get();

            return response()->json($posts);
    }

    public function postReload($postID,$userID){
        // logger($id);
        // $post = Post::where('id','=',$id)
        //             ->first();

        $query = DB::table(DB::raw('(
                    SELECT
                        p.id,
                        (SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.react <> 0) AS react_count,
                        (SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.view = 1) AS view_count,
                        (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS comment_count,
                        ad.name,
                        ad.gender,
                        ad.profile,
                        p.title,
                        p.description,
                        p.created_at,
                        p.updated_at,
                        p.image,
                        a.react AS user_react
                    FROM posts p

                    JOIN users ad ON p.user_id = ad.id
                    LEFT JOIN actions a
                    ON p.id = a.post_id
                    AND a.user_id = :user_id
                    AND p.id = :post_id
                ) AS subquery'));
        $query->addBinding($userID);
        $query->addBinding($postID);
        // $query->addBinding($postLimit);
        $posts = $query->first();

        return response()->json($posts);
    }

    //postPage End

    public function postSearch(Request $req){
        // logger($req->all());

        $searchkey = $req->searchkey;
        $posts = Post::where('title','like','%'.$searchkey.'%')
                      -> orWhere('description','like','%'.$searchkey.'%')
                      -> get();
        return response()->json([
            'posts' => $posts
        ]);

        return response()->json([
            'response' => 'success'
        ]);
    }

    public function postCall($postID,$userID){
        // $post = Post::select(['title','description', DB::raw('COUNT(actions.view) as view_count'),'users.name as creater','posts.updated_at','users.gender','users.profile','posts.image','posts.updated_admin'])
        // $post =  DB::table('posts as p')
        //             ->leftJoin('users as u','u.id','=','p.user_id')
        //             ->where('p.id',$req->id)
        //             ->select('p.id','p.title','p.description','u.name as creater','p.updated_at','u.gender','u.profile','p.image','p.updated_admin')
        //             // DB::raw('COUNT(a.view) as view_count')
        //             ->where('p.id',$req->id)

        //             // ->groupBy('p.id')
        //             // ->groupBy(['title','description','creater','updated_at','gender','profile','image','updated_admin'])  FOR GROUPING TOGETHER
        //             ->first();
        // $viewCount = DB::table('actions as a')
        //                 ->select('a.post_id', DB::raw('COUNT(a.view) as view_count'))
        //                 ->where('a.view',1)
        //                 ->orWhereNull('a.view',0)
        //                 ->where('a.post_id','=',$post->id)
        //                 ->groupBy('a.post_id')
        //                 ->get();

//         SELECT p.productID, p.productName, p.productCategory, COUNT(v.view) AS viewCount
// FROM product p
// LEFT JOIN view v ON p.productID = v.productID
// WHERE v.view = 1
// GROUP BY p.productID, p.productName, p.productCategory;

        // $query = DB::table(DB::raw('(
        //     SELECT
        //         p.id,
        //         (SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.react <> 0) AS react_count,
        //         (SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.view = 1) AS view_count,
        //         (SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS comment_count,
        //         ad.name,
        //         ad.gender,
        //         ad.profile,
        //         p.title,
        //         p.description,
        //         p.created_at,
        //         p.updated_at,
        //         p.image,
        //         a.react AS user_react
        //     FROM posts p

        //     JOIN users ad ON p.user_id = ad.id
        //     LEFT JOIN actions a
        //     ON p.id = a.post_id
        //     AND a.user_id = :userID
        //     AND p.id = :postID
        // ) AS subquery'));
        // $query->addBinding($userID);
        // $query->addBinding($postID);
        // // $query->addBinding($postLimit);
        // $post = $query->first();
            // if(Gate::denies('view_post',$postID)){
            //    abort(401);
            // }
            // $post = Post::where('id','=',$postID)->first();
            if(Gate::denies('view_post', Post::class)){
                abort(401);
            }

        $post = DB::table('posts as p')
                ->select([
                    'p.id',
                    DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.react <> 0) AS react_count'),
                    DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.view = 1) AS view_count'),
                    DB::raw('(SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS comment_count'),
                    'ad.name',
                    'ad.gender',
                    'ad.profile',
                    'p.title',
                    'p.description',
                    'p.created_at',
                    'p.updated_at',
                    'p.image',
                    'a.react AS user_react'
                ])
                ->where('p.id', '=', $postID)
                ->join('users as ad', 'p.user_id', '=', 'ad.id')
                ->leftJoin('actions as a', function ($query) use ($userID,$postID) {
                    $query -> on('p.id', '=', 'a.post_id')
                           -> where('a.user_id', '=', $userID);
                })
                ->first();

        return response()->json($post);
        // $post = DB::table('posts as p')
        // ->select(
        //     'p.id',
        //     'p.title',
        //     'p.description',
        //     'u.name as creater',
        //     'p.updated_at',
        //     'u.gender',
        //     'u.profile',
        //     'p.image',
        //     'p.updated_admin',
        //     'r.reaction',
        //     // DB::raw('COUNT(r.react) AS react_count'),
        //     DB::raw(' SUM(CASE WHEN a.react <> 0 THEN 1 ELSE 0 END) AS react_count'),
        //     DB::raw('COUNT(a.view) AS view_count')
        // )
        // ->leftjoin('users as u', 'p.user_id', '=', 'u.id')
        // ->leftJoin('actions as a', function ($query){
        //     $query->on('p.id', '=', 'a.post_id')
        //          ->where('a.view', '=', 1);
        // })
        // ->leftJoin('actions as r',function($query) use ($userID){
        //     $query -> on('p.id','=','r.post_id')
        //            -> where('r.user_id','=',$userID);
        // })
        // ->orWhereNull('r.reaction')
        // // ->leftJoin('actions as r',function($query){
        // //     $query ->  on('p.id', '=', 'r.post_id')
        // //             -> where('r.react','<>',0);
        // // })
        // // ->where('r.react', '<>', '0')
        // ->where('p.id',$postID)
        // ->groupBy(
        //     'p.id',
        //     'p.title',
        //     'p.description',
        //     'creater',
        //     'p.updated_at',
        //     'u.gender',
        //     'u.profile',
        //     'p.image',
        //     'p.updated_admin'
        // )
        // ->get();

        // return response()->json([
        //     'post' => $post
        // ]);
    }

    public function totalPosts(){
        $postcount = Post::get()->count();
        return response()->json($postcount);
    }
}
