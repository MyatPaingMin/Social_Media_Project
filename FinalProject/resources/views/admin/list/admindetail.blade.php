@extends('admin.layout.master')

@section('content')


<div class="overflow-scroll h-100 overflow-x-hidden position-relative">

<h2>Admin Detail</h2>


    {{-- @if(session('passwordSuccess'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <p>{{session('passwordSuccess')}}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('profileSuccess'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <p>{{session('profileSuccess')}}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif --}}

<div class="w-100 row bg-warning" style="width: 100%;height: 150px;">
    <img src="" alt="" class="">
</div>


<div class="w-100 row " style="width: 100%;height: 120px;">
    <div class="col-4  position-relative">
        @if($user['profile'] != NULL)
             <img src="{{asset('storage/user/'.$user['profile'])}}" alt=""  class="rounded-circle bg-secondary position-absolute bottom-50 object-fit-cover"  width="150px" height="150px" style="left: 80px" >
        @else
            @if($user['gender'] == 'female')
                <img src="{{asset('storage/user/default/femaleDefault.jpg')}}" alt=""  class="rounded-circle bg-secondary position-absolute bottom-50 object-fit-cover"  width="150px" height="150px" style="left: 80px">
            @elseif($user['gender'] == 'male')
                <img src="{{asset('storage/user/default/maleDefault.jpg')}}" alt=""  class="rounded-circle bg-secondary position-absolute bottom-50 object-fit-cover"  width="150px" height="150px" style="left: 80px">
            @else
                <img src="{{asset('storage/user/default/personDefault.jpg')}}" alt="" class="rounded-circle bg-secondary position-absolute bottom-50 object-fit-cover"  width="150px" height="150px" style="left: 80px">
            @endif
        @endif


    </div>
    <div class="col text-left ">
        <div class="d-flex">
            <h3>{{$user['name']}}</h3>
            @if($user['gender'] == 'male')
                <i class="fa-solid fa-mars mt-2 ms-2 fs-4 text-primary"></i>
            @elseif($user['gender'] == 'female')
                <i class="fa-solid fa-venus mt-2 ms-2 fs-4 text-danger"></i>
            @endif
        </div>

        <h5>{{$user['email']}}</h5>
        <div>
            <span><i class="fa-brands fa-instagram"></i>Instagram</span>|
            <span><i class="fa-brands fa-facebook"></i>Facebook</span>|
            <span><i class="fa-brands fa-twitter"></i>Twitter</span>|
            <span><i class="fa-brands fa-linkedin"></i>LinkedIn</span>
        </div>
    </div>
</div>

<hr>

<div  class="w-100 row " style="width: 100%;height: 120px;">
    <div class="col-4  d-flex justify-content-center">

        <table style="height: 100px;" class="mt-3">
            <tbody>
              <tr>
                <td class="align-middle d-block"><i class="fa-solid fa-phone"></i>{{$user['phone']}}</td>
                <td class="align-middle d-block"><i class="fa-solid fa-envelope"></i>{{$user['email']}}</td>
              </tr>
            </tbody>
          </table>
    </div>
    <div class="col ">
        @if(count($posts) == 0)
            <h2 class="text-secondary d-block text-center">There is no post.</h2>
        @else

        @foreach($posts as $post)
        {{-- Post Start --}}
        <div class="">
            <div class="row py-2 border-bottom m-0 p-0">
                <div class="col text-start m-0 p-0">
                    <div class="d-flex my-2">
                        @if($post['profile'] != NULL)
                             <img src="{{asset('storage/user/'.$post['profile'])}}" alt=""  class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                        @else
                            @if($post['gender'] == 'female')
                                <img src="{{asset('storage/user/default/femaleDefault.jpg')}}" alt="" class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                            @elseif($post['gender'] == 'male')
                                <img src="{{asset('storage/user/default/maleDefault.jpg')}}" alt="" class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                            @else
                                <img src="{{asset('storage/user/default/personDefault.jpg')}}" alt="" class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                            @endif
                        @endif
                        <h4>{{$post['creater']}}</h4>
                    </div>
                    <span class="mx-5">{{$post['updated_at']}}</span>
                    <span class=""><i class="fa-solid fa-eye"></i> {{$post['view_count']}}</span>
                </div>
                <div class="col text-end">
                    <i class="fa-solid fa-ellipsis"></i>
                </div>
            </div>

            <br>

            <div class="text-center">
                <div class="row text-start">
                    <p>{{$post['description']}}
                        <span><a href="{{route('seePost',$post->id)}}" class=" btn btn-primary rounded-2" style="width:100px; height: 40px; ">View</a></span>
                    </p>
                </div>
                <img src="{{asset('storage/post/'.$post['image'])}}" class="object-fit-contain bg-secondary" style="width: 90%; height: 300px;">
            </div>

            <hr>

            <div class="row">
                <div class="col text-center mb-2">
                    {{$post['react_count']}} reacts
                </div>
                <div class="col text-center mb-2">
                    {{$post['comment_count']}} comments
                </div>
            </div>
            <hr>
        </div>
        <br>
        {{-- Post End --}}
        @endforeach
        @endif

    </div>
</div>

</div>

@endsection
