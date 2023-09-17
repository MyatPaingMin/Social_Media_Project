<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
</head>
<body>
    @if(Auth::user()['role'] == 'admin')
    <div class="col m-0 p-0 " style="width: 100%;">
        <div class="row border border-bottom-1 border-gray " style="width: 100%; height: 50px;">
            <div class="col-5 mx-5 text-start">MY MEDIA</div>
            <div class="container-fluid col-4 align-self-right">
                <form class="d-flex" role="search">
                    <input class="form-control me-2 " style="width: 300px;" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                  </form>
            </div>
            <div class="col mx-5 text-end">
                <div>{{Auth::user()['name']}}</div>
            </div>
        </div>
        <div class="row " style="height: 700px; ">
            <div class="col-3 d-flex flex-col  p-0">
                <div class="col ">

                <div class="row mx-2" style="width: 100%;">
                    <ul class="list-group mt-1 p-1" style="width:100%;">
                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                      <div class="ms-2 me-auto">
                        <div class="fw-bold">
                            <a href="{{route('admin#home')}}"> <i class="fa-solid fa-house"></i>HOME</a>
                        </div>

                      </div>
                      {{-- <span class="badge bg-primary rounded-pill">0</span> --}}
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                      <div class="ms-2 me-auto">
                        <div class="fw-bold">
                            <a href="{{route('admin#profile')}}"><span class="material-symbols-outlined">
                                account_circle
                                </span>My Profile</a>
                        </div>
                      </div>
                      {{-- <span class="badge bg-primary rounded-pill">0</span> --}}
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                      <div class="ms-2 me-auto">
                        <div class="fw-bold">
                            <a href="{{route('admin#categorylist')}}" class="text-danger"><i class="fa-solid fa-list"></i>Category</a>
                        </div>
                        <br>
                        <ul class="categoryList">
                            {{-- @foreach($categories as $category)
                                <li>{{$category['name']}}</li>
                            @endforeach --}}
                        </ul>
                      </div>
                      {{-- <span class="badge bg-primary rounded-pill">14</span> --}}
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                        <div class="ms-2 me-auto">
                          <div class="fw-bold">
                            <a href="{{route('admin#listpost')}}">
                                <span class="material-symbols-outlined">post</span>
                                Posts
                            </a>

                          </div>
                        </div>
                        {{-- <span class="badge bg-danger rounded-pill">0</span> --}}
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                        <div class="ms-2 me-auto">
                          <div class="fw-bold">
                            <a href="{{route('admin#userlist')}}"><span class="material-symbols-outlined">
                                person
                                </span>Users</a>
                          </div>
                        </div>
                        {{-- <span class="badge bg-danger rounded-pill">0</span> --}}
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                      <div class="ms-2 me-auto">
                        <div class="fw-bold">
                            <a href="{{route('admin#adminlist')}}"><span class="material-symbols-outlined">
                                manage_accounts
                                </span>Admins</a>
                        </div>
                      </div>
                      {{-- <span class="badge bg-danger rounded-pill">0</span> --}}
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                        <div class="ms-2 me-auto">
                          <div class="fw-bold">
                            <a href="{{route('admin#chatPage')}}"><i class="fa-solid fa-comments"></i>Chat</a>
                          </div>
                        </div>
                        <span class="badge bg-danger rounded-pill" id="chatunseen"></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-start py-3">
                      <div class="ms-2 me-auto">
                        <div class="fw-bold">
                            <a href="{{route('admin#notification')}}"><i class="fa-solid fa-circle-info"></i>nofication</a>
                        </div>
                      </div>
                      <span class="badge bg-danger rounded-pill" id="adminPending"></span>
                    </li>
                  </ul>
                </div>
                <br>

                  <form class="row d-flex justify-content-center" style="width: 100%;" action="{{route('logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-dark px-3 w-50">Log out</button>
                  </form>

                </div>
            </div>
            <div class="col m-3 border border-2 border-gray position-relative">
                @yield('content')
            </div>
            <div class="col-3 m-1 mt-3 d-flex flex-col bg-gray border-secondary  mr-2">
                <ul class="list-group w-100">
                    <h4>Admin</h4>
                    <br>
                    <div class="adminlist">

                    </div>
                    {{-- @foreach($userlist as $user)
                    <li class="list-group-item d-flex justify-content-between align-items-center w-100">
                        {{$user['name']}}
                        <span>
                          <i class="fa-regular fa-envelope"></i>
                        </span>
                    </li>
                    @endforeach --}}

                    <hr>
                    <h4>User</h4>
                    <br>
                    <div class="userlist">

                    </div>
                </ul>
            </div>
        </div>
    </div>
    @endif
    </body>
</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>



    $(document).ready(function(){
        $currentuser = 0;


        // $.ajax({
        //   url: 'http://127.0.0.1:8000/admin/ajax/currentUser',
        //   type: 'GET'
        // })
        // .done(function (response) {
        //   console.log(response);
        //   $currentuser = response.currentuser.id;

        //   return
        $.ajax({
            url: 'http://127.0.0.1:8000/admin/ajax/basic',
            type: 'GET'
          })
        // })
        .done(function(response) {
            // console.log(response.userlist);

                $users = '';
                $admins = '';

                for (let i = 0; i < response['userlist'].length; i++) {
                    let element = response['userlist'][i];
                    // console.log(element);
                    if(element.role == 'user'){
                        $users += `
                            <li class="list-group-item d-flex justify-content-between align-items-center w-100">
                                ${element.name}
                                <span>
                                  <i class="fa-regular fa-envelope"></i>
                                </span>
                            </li>`;
                    }else if(element.role == 'admin'){
                        // Replace "your_value" with the actual value of elementID

                        $admins += `
                                <li class="list-group-item d-flex justify-content-between align-items-center w-100">
                                    ${element.name}
                                    <a href="{{url('admin/chat')}}/${element.id}">
                                        <i class="fa-regular fa-envelope"></i>
                                    </a>
                                </li>`;
                    }

                }
                $('.userlist').html($users);
                $('.adminlist').html($admins);

                $list = '';
                for (let i = 0; i < response['category'].length; i++) {
                    let element = response['category'][i];
                    // console.log(element);

                    $list += `<li>${element.category_name}</li>`;
                }
                $('.categoryList').html($list) ;
        })

        $.ajax({
            type : 'get',
            url : 'http://127.0.0.1:8000/admin/ajax/notification',
            success : function(response){
              $('#adminPending').text(response.adminPending);
            }
        })

        $.ajax({
            type : 'get',
            url : 'http://127.0.0.1:8000/admin/ajax/chatunseen',
            success : function(response){
              $('#chatunseen').text(response.chatunseen);
            }
        })
    })

</script>
{{-- <a href="{{route('admin#chat', ${elementID})}"  ><span class="fa fa-trash-o"></span></a> --}}
{{--
// <form method="POST" action="{{route('admin#chat')}}">
    // @csrf
    // <input name ="otheruser" value = "${element.id}"/>
    // <i class="fa-regular fa-envelope"></i>
// </form> --}}
