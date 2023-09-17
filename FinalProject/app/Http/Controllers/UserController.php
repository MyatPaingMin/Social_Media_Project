<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    public function loginUser(Request $req){
        Validator::make($req->all(),[
            'email' => ['required','email'],
            'password' => 'required'
        ],[
            'password.required' => 'Password is required',
            'email.required' => 'User email is required',
            'email.email' => 'Email is not in a right format',
        ])->validate();

        $user = User::where('email','=',$req->email)->first();
        if($user){
            if($user['role'] != 'admin' && $user['role'] != 'admin_pending'){
                return abort(401);
                // return redirect()->back();
            }
        };

        $credentials = $req->only('email', 'password');
        $rememberCheck = $req->filled('remember');

        if(auth()->attempt($credentials,$rememberCheck)){
            return redirect()->route('admin#home');
        }else{
            return redirect()->back();
        }
    }
    //Create Admin start
    public function registerUser(Request $req){
        // dd($req->toArray());
        $this->validation($req);
        $datapack = $this->combine($req);
        // dd($datapack);

        $user = User::create($datapack);

        auth()->login($user);
        // dd('success');
        return redirect()->route('admin#home');
    }

    private function validation($data){
        $validRule = [
            'name' => 'required|unique:users,name',
            'email'  => 'required|unique:users,email',
            'password' => ['required',Password::min(8)
                                            ->letters()
                                            ->mixedCase()
                                            ->numbers()
                                            ->symbols()],
            'confirm' => 'required|same:password'
            // regex:/^.*(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/
        ];
        $invalidMsg = [
            'name.required' => 'Please fill in user name',
            'name.unique' => 'This user name has already been taken.',
            'email.required' => 'Please fill in Email field',
            'email.unique' => 'This email has already been taken',
            'password.required' => 'Password field needs to be filled',
            // 'password.min' => 'Password must be more than 8 characters long.',
            // 'password.letters|mixedcase|numbers|symbols' => 'Password needs upper and lower case characters with numbers and special letters',
            'confirm.required' => 'Please confirm your password',
            'confirm.same' => 'Password and Confirm password does not match'
        ];
        Validator::make($data->all(),$validRule,$invalidMsg)->validate();
    }

    private function combine($data){
        return [
            'name' => $data->name,
            'email' => $data->email,
            'password' => Hash::make($data-> password),
            'role' => 'admin_pending',
        ];
    }
    //Create admin end

    //Default Home start
    public function adminBasic(){
            $userlist = User::where('id','<>',Auth::user()['id'])->get();
            $categories = Category::all();
            $response = [
                'userlist' => $userlist,
                'category' => $categories
            ];
            return response()->json($response,200);
    }

    public function adminNotificationAmount(){
        $adminPending = User::where('role','=','admin_pending')->count();
        return response()->json(['adminPending' => $adminPending]);
    }

    public function adminPendingList(){
        $adminPending = User::where('role','=','admin_pending')->get();
        return response()->json($adminPending);
    }

    //Default Home end


    //Redirect pages start

    public function adminHome(){
        return view('admin.post.home');
    }
    public function adminProfile(){
        $user = User::where('id',Auth::user()['id'])->first();
        $posts = Post::select([
                    'posts.id',
                    DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = posts.id AND a.react <> 0) AS react_count'),
                    DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = posts.id AND a.view = 1) AS view_count'),
                    DB::raw('(SELECT COUNT(*) FROM comments c WHERE c.post_id = posts.id) AS comment_count'),
                    'ad.name as creater_name',
                    'ad.gender',
                    'ad.profile',
                    'posts.title',
                    'posts.description',
                    'posts.created_at',
                    'posts.updated_at',
                    'posts.image'
                ])
                ->where('ad.id','=',Auth::user()['id'])
                ->join('users as ad', 'posts.user_id', '=', 'ad.id')
                ->get()
                ->toArray();
        return view('admin.profile.profile',compact(['user','posts']));
    }
    public function adminCategory(){
        return view('admin.category.category');
    }
    public function adminUserlist(){

        $users = User::where('id','<>',Auth::user()['id'])
                ->where('role','=','user')
                ->get();

        foreach ($users as $user) {
           if(
                $user['status'] == 1 && $user['banned_date'] < Carbon::now()->subday() ||
                $user['status'] == 2 && $user['banned_date'] < Carbon::now()->subday(7) ||
                $user['status'] == 3 && $user['banned_date'] < Carbon::now()->subday(30)
            ){
                $user['over'] = true;
            }else{
                $user['over'] = false;
            };
        }

        return view('admin.list.userlist',compact('users'));
    }
    public function adminAdminlist(){
        $admins = User::where('role','=','admin')
                ->where('id','<>',Auth::user()['id'])
                ->when(request('searchkey'),function($query){
                    $query -> where('name','like','%'.request('searchkey').'%');
                        //    -> orWhere('email','like','%'.request('searchkey').'%');
                })
                ->get();
        // dd($admins);
        return view('admin.list.adminlist',compact('admins'));
    }
    public function adminChat(){
        return view('admin.chat.chat');
    }
    public function adminNotification(){
        $adminPending = User::where('role','=','admin_pending')->get();
        return view('admin.notification.notification',compact('adminPending'));
    }
    public function adminApprove($id){
        User::where('id','=',$id)->update(['role' => 'admin']);
        return redirect()->route('admin#notification');
    }
    public function adminDeny($id){
        User::where('id','=',$id)->delete();
        return redirect()->route('admin#notification');
    }
    public function profileEdit(){
        return view('admin.profile.edit');
    }
    public function profilePhoto(){
        return view('admin.profile.photo');
    }
    public function adminDetail($id){
        $posts =Post::select([
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
                ->where('ad.id','=',$id)->get();

        $user = User::where('id',$id)->first();
        return view('admin.list.admindetail',compact(['user','posts']));
    }
    public function userDetail($id){

        $user = User::where('id',$id)->first();

        $posts = DB::table('posts as p')
                ->select([
                    'p.id',
                    DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.react <> 0) AS react_count'),
                    DB::raw('(SELECT COUNT(*) FROM actions a WHERE a.post_id = p.id AND a.view = 1) AS view_count'),
                    DB::raw('(SELECT COUNT(*) FROM comments c WHERE c.post_id = p.id) AS comment_count'),
                    'ad.name as creater',
                    'ad.gender',
                    'ad.profile',
                    'p.title',
                    'p.description',
                    'p.created_at',
                    'p.updated_at',
                    'p.image'
                ])
                ->join('comments as c','c.post_id','p.id')
                ->leftJoin('users as ad','ad.id','p.user_id')
                ->where('c.user_id','=',$id)
                ->groupBy(['p.id',
                    'ad.name',
                    'ad.gender',
                    'ad.profile',
                    'p.title',
                    'p.description',
                    'p.created_at',
                    'p.updated_at',
                    'p.image']
                )
                ->get();

        return view('admin.list.userdetail',compact(['user','posts']));
    }
    public function userDelete($id){
        User::where('id',$id)->first()->delete();
        return redirect()->route('admin#userlist')->with(['deleteuser'=>'User deleted successfully.']);
    }
    public function userBan($id,$duration){

        User::where('id',$id)->first()->update([
            'status' => $duration,
            // 'hobby' => 'newHobby',
            'banned_date' => Carbon::now()
            // 'banned_date' => 'Hello'
        ]);
        // return back();
        return redirect()->route('admin#userlist')->with(['banneduser'=>'Successfullybanned the user.']);
    }

    public function banDetail($id){
        // dd($id);
        $user = User::where('id',$id)->first();
        return view('admin.list.banDetail',compact('user'));
    }

    public function unban($id){
        User::where('id',$id)->update([
            'status'=> NULL,
            'banned_date' => NULL
        ]);
        return redirect()->route('admin#userlist');
    }
    //Redirect pages end

    //Update profile start
    public function profilePhotoUpdate(Request $req){
        $this->validateProfile($req);
        // dd($req);
        $photoName = Auth::user()['id'].$req->file('photo')->getClientOriginalName();

        $oldPhoto = '';
        if(Auth::user()['profile']){
            $oldPhoto = Auth::user()['profile'];
            Storage::delete('public/user/'.$oldPhoto);
        }

        $req->file('photo')->storeAs('public/user', $photoName);
        $datapack = ['profile' => $photoName];

        User::where('id',Auth::user()['id'])->update($datapack);
        return redirect()->route('admin#profile');
    }
    private function validateProfile($data){
        Validator::make($data->all(),
        [   'photo' => 'required',
            'photo'=>'mimes:jpg,jpeg,webp,png'],
        [   'photo.required' => 'Please choose a profile photo.',
            'photo.mimes'=>'Photo is not in the right format.'])
            ->validate();
    }

    //update profile end

    //Update Data Start
    public function profileUpdate(Request $req){
        // dd($req->all());
        $this->validateData($req);
        $datapack = $this->dataEdited($req);
        User::where('id','=',Auth::user()['id'])
                ->update($datapack);
        return redirect()->route('admin#profile')->with(['profileSuccess'=>'Saved changed of personal data.']);
    }

    public function userUnban(){
    }

    private function validateData($data){
        $valideData = [
            'name' => 'required|unique:users,name,'.Auth::user()['id'],
            'email'  => 'required|unique:users,email,'.Auth::user()['id'],
            // 'DOB' => 'required',
        ];
        $validMsg = [
            'name.required' => 'Name cannot be blank',
            'email.required' => 'Email cannot be blank',
            // 'DOB.required' => 'Date of birth cannot be blank',
            'email.unique' => 'An account with this email exists.',
            'name.unique' => 'An account with this name exists.',
        ];
        Validator::make($data->all(),$valideData,$validMsg)->validate();
    }

    private function dataEdited($data){
        $datapack = [
            'name' => $data->name,
            'email' => $data->email,
            'DOB' => $data->DOB,
            'gender' => $data->gender,
            'location' => $data->location,
            'phone' => $data->phone,
            'facebook' => $data->facebook,
            'twitter' => $data->twitter,
            'instagram' => $data->instagram,
            'linkedin' => $data->linkedin,
            'status' => $data->status
        ];
        return $datapack;
    }

    //update data end

    //update password start

    public function profilePassword(){
        return view('admin.profile.password');
    }
    public function profilePasswordUpdate(Request $req){
        $this->validatePassword($req);

        if(Hash::check($req->oldpassword,Auth::user()['password'])){
            if(!Hash::check($req->newpassword,Auth::user()['password'])){
                $datapack = ['password' => Hash::make($req->newpassword)];
                User::where('id',Auth::user()['id'])->update($datapack);
                return redirect()->route('admin#profile')->with(['passwordSuccess'=>'Changed password successfully.']);
            }else{
                return back()->withErrors(['newpassword'=>'The new passwordcannot be the same as origninal one.']);
            }
        }else{
            return back()->withErrors(['oldpassword' => 'Wrong Password.']);
        }
    }


    private function validatePassword($data){
        $validPassword = [
            'oldpassword' =>'required',
            'newpassword' => 'required',
            'confirmpassword' => 'required|same:newpassword'
        ];
        $validMsg = [
            'oldpassword.required' => 'Please enter original password.',
            'newpassword.required' => 'Please enter new password.',
            'confirmpassword.required' => 'Please confirm your password.',
            'confirmpassword.same' => 'Password confirmation does not match.'
        ];
        Validator::make($data->all(),$validPassword,$validMsg)->validate();
    }
    //update password end

    //search admin start

    //search admin end








    // API
    public function currentUser(){
        logger(Auth::user());
        logger('Here_is_user');
        return Auth::user();
    }

    public function checkUser(Request $req){
        $email = $req->email;
        $password = $req->password;

        $user = User::where('email',$email)->first();

        if($user){
            if($user['role'] != 'user'){
                return [
                    'status' => 'wrongRole'
                ];
            }
        };
        // $credentials = $req->only('email','password');
        // auth()->attempt($credentials); Not Essential

        if(isset($user)){
            if(Hash::check($password,$user['password'])){
                return [
                    'status' => 'success',
                    'userData' => $user,
                    'token' => $user->createToken(time())->plainTextToken
                ];
            }else{
                return [
                    'status' => 'fail',
                    'userData' => NULL,
                    'token' => NULL
                ];
            }
        }else{
            return [
                'status' => 'fail',
                'userData' => NULL,
                'token' => NULL
            ];
        }
    }

    public function createUser(Request $req){
        $this->userValidation($req);
        $userExist = User::where('email','=',$req->email)
                        ->  orWhere('name','=',$req->name)
                        ->  exists();
        if($userExist){
            return response()->json(['status' => 'userExists']);
        }else{
            $data = [
                'name' => $req->name,
                'email' => $req->email,
                'gender' => $req->gender,
                'password' => Hash::make($req->password),
                'role' => 'user'
            ];
            $user = User::create($data);
            return [
                'status' => 'success',
                'user' => $user,
                'token' => $user->createToken(time())->plainTextToken
            ];
        }
    }
    private function userValidation($data){
        $validateItem = [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required|min:8',
            'confirmpass' => 'required|min:8',
            'gender' => 'required'
        ];
        Validator::make($data->all(),$validateItem)->validate();
    }

    //User register

    public function userRegisterPage(){
        return view('registerPage.vue');
    }

    public function logoutUser(){
        auth()->user()->currentAccessToken()->delete();
    }

    public function adminCurrentUser(){
        dd(Auth::user());
        return Auth::user();
    }

}
