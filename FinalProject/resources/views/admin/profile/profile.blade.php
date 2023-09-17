@extends('admin.layout.master')

@section('content')


<div class="overflow-scroll h-100 overflow-x-hidden position-relative">

<h2>Profile</h2>

@if(session('passwordSuccess'))
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
@endif

<div class="w-100 row bg-warning" style="width: 100%;height: 150px;">
    <img src="" alt="" class="">
</div>


<div class="w-100 row " style="width: 100%;height: 120px;">
    <div class="col-4  position-relative">
        @if(Auth::user()['profile'] != NULL)
             <img src="{{asset('storage/user/'.Auth::user()['profile'])}}" alt=""  class="rounded-circle bg-secondary position-absolute bottom-50 object-fit-cover"  width="150px" height="150px" style="left: 80px" >
        @else
            @if(Auth::user()['gender'] == 'female')
                <img src="{{asset('storage/user/default/femaleDefault.jpg')}}" alt=""  class="rounded-circle bg-secondary position-absolute bottom-50 object-fit-cover"  width="150px" height="150px" style="left: 80px">
            @elseif(Auth::user()['gender'] == 'male')
                <img src="{{asset('storage/user/default/maleDefault.jpg')}}" alt=""  class="rounded-circle bg-secondary position-absolute bottom-50 object-fit-cover"  width="150px" height="150px" style="left: 80px">
            @else
                <img src="{{asset('storage/user/default/personDefault.jpg')}}" alt="" class="rounded-circle bg-secondary position-absolute bottom-50 object-fit-cover"  width="150px" height="150px" style="left: 80px">
            @endif
        @endif
        <img src="" alt="">
        <div class="position-absolute" style="left: 90px; bottom: 10px;">
            <a href="{{route('profilePhoto')}}" class="mx-2"  title="Change Profile Image"><span class="material-symbols-outlined">contacts</span></a>
            <a href="{{route('profileEdit')}}" class="mb-2 mx-2 fs-4 fw-light" title="edit profile detail"><i class="fa-solid fa-pen-to-square"></i></a>
            <a href="{{route('profilePassword')}}" class="mb-2 " title="Change Password"><span class="fs-2 material-symbols-outlined">lock_reset</span></a>
        </div>
    </div>
    <div class="col text-left ">
        <div class="d-flex">
            <h3>{{Auth::user()['name']}}</h3>
            @if(Auth::user()['gender'] == 'male')
                <i class="fa-solid fa-mars mt-2 ms-2 fs-4 text-primary"></i>
            @elseif(Auth::user()['gender'] == 'female')
                <i class="fa-solid fa-venus mt-2 ms-2 fs-4 text-danger"></i>
            @endif
        </div>

        <h5>{{Auth::user()['email']}}</h5>
        <div>
            @if(Auth::user()['instagram'] != NULL)
                <span><i class="fa-brands fa-instagram"></i>{{Auth::user()['instagram']}}</span> |
            @endif
            @if(Auth::user()['facebook'] != NULL)
                <span><i class="fa-brands fa-facebook"></i>{{Auth::user()['facebook']}}</span> |
            @endif
            @if(Auth::user()['twitter'] != NULL)
                <span><i class="fa-brands fa-twitter"></i>{{Auth::user()['twitter']}}</span> |
            @endif
            @if(Auth::user()['linkedin'] != NULL)
                <span><i class="fa-brands fa-linkedin"></i>{{Auth::user()['linkedin']}}</span>
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
                <td class="align-middle d-block"><i class="fa-solid fa-phone"></i>{{Auth::user()['phone']}}</td>
                <td class="align-middle d-block"><i class="fa-solid fa-envelope"></i>{{Auth::user()['email']}}</td>
              </tr>
            </tbody>
          </table>
    </div>
    <div class="col ">


        @foreach ($posts as $post)

         {{-- Post Start --}}
         <div class="border border-1 p-4 m-0 rounded">
            <div class="row py-2 border-bottom m-0 p-0">
                <div class="col-8 text-start m-0 p-0">
                    <img src="{{asset('storage/user/'.$post['profile'])}}" alt="" class="rounded-circle bg-secondary" style="width: 40px; height: 40px;">
                    {{$post['creater_name']}}
                    <span class="mx-2">{{$post['updated_at']}}</span>
                    <span class="">{{$post['view_count']}}</span>
                </div>
                <div class="col text-end">
                    <i class="fa-solid fa-ellipsis"></i>
                </div>
            </div>

            <br>

            <div class="text-center">
                <div class="row text-start">
                    <p>{{$post['description']}}</p>
                </div>
                @if($post['image'] != NULL)
                    <img src="{{asset('storage/post/'.$post['image'])}}" alt="" style="width: 90%; height: 300px;" class="object-fit-contain">
                @else
                    <img src="{{asset('storage/post/default.png')}}" alt="" style="width: 90%; height: 300px;" class="object-fit-contain">
                @endif
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
    </div>
</div>


</div>
<a href="{{route('createPostPage')}}"class="position-absolute py-1 px-3 btn btn-danger" style="bottom: 40px; left: 40px;">
    <button class=" btn " ><i class="fa-solid fa-circle-plus"></i>Create Post</button>
</a>
@endsection

<script>



</script>
