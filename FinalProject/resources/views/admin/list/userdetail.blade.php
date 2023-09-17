@extends('admin.layout.master')

@section('content')


<div class="overflow-scroll h-100 overflow-x-hidden position-relative">

<h2>User Detail</h2>

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
        {{-- <div class="position-absolute" style="left: 90px; bottom: 10px;">
            <a href="{{route('profilePhoto')}}" class="mx-2"  title="Change Profile Image"><span class="material-symbols-outlined">contacts</span></a>
            <a href="{{route('profileEdit')}}" class="mb-2 mx-2 fs-4 fw-light" title="edit profile detail"><i class="fa-solid fa-pen-to-square"></i></a>
            <a href="{{route('profilePassword')}}" class="mb-2 " title="Change Password"><span class="fs-2 material-symbols-outlined">lock_reset</span></a>
        </div> --}}
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
            @if($user['instagram'])
            <span><i class="fa-brands fa-instagram"></i>{{$user['instagram']}}</span>|
            @endif
            @if($user['facebook'])
            <span><i class="fa-brands fa-facebook"></i>{{$user['facebook']}}</span>|
            @endif
            @if($user['twitter'])
            <span><i class="fa-brands fa-twitter"></i>{{$user['twitter']}}</span>|
            @endif
            @if($user['linkedin'])
            <span><i class="fa-brands fa-linkedin"></i>{{$user['linkedin']}}</span>
            @endif
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

         {{-- Post Start --}}
         @foreach($posts as $post)
         <div class="border border-1 p-4 m-0 rounded">
            <div class="row py-2 border border-2 border-secondary rounded m-0 p-0" style="height: 40px;">
                <p>{{$user['name']}} has commented in {{$post->creater}}'s post.</p>
            </div>
            <div class="row py-2 border-bottom m-0 p-0">
                <div class="col-8 text-start m-0 p-0">
                    <div class="d-flex my-2">
                        @if($post->profile != NULL)
                             <img src="{{asset('storage/user/'.$post->profile)}}" alt=""  class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                        @else
                            @if($post->gender == 'female')
                                <img src="{{asset('storage/user/default/femaleDefault.jpg')}}" alt="" class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                            @elseif($post->gender == 'male')
                                <img src="{{asset('storage/user/default/maleDefault.jpg')}}" alt="" class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                            @else
                                <img src="{{asset('storage/user/default/personDefault.jpg')}}" alt="" class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                            @endif
                        @endif
                        <h4>{{$post->creater}}</h4>
                    </div>
                    <span class="mx-5">{{$post->updated_at}}</span>
                    <span class=""><i class="fa-solid fa-eye"></i> {{$post->view_count}}</span>
                </div>
                <div class="col text-end">
                    <i class="fa-solid fa-ellipsis"></i>
                </div>
            </div>

            <br>

            <div class="text-center">
                <div class="row text-start">
                    <h4>{{$post->title}}</h4>
                    <p>{{$post->description}}
                        <span><a href="{{route('seePost',$post->id)}}" class=" btn btn-primary rounded-2" style="width:100px; height: 40px; ">View</a></span>
                    </p>
                </div>
                <img src="{{asset('storage/post/'.$post->image)}}" class="object-fit-contain bg-secondary" style="width: 90%; height: 300px;">
            </div>

            <hr>

            <div class="row">
                <div class="col text-center mb-2">
                    {{$post->react_count}} reacts
                </div>
                <div class="col text-center mb-2">
                    {{$post->comment_count}} comments
                </div>
            </div>
            <hr>
        </div>
        <br>
        @endforeach
        {{-- Post End --}}
    </div>
</div>


</div>

@endsection
