@if(isset($posts))

@extends('admin.layout.master')

@section('content')
    {{-- THIS IS HOME PAGE --}}
    <div class="container m-0 p-0 overflow-y-scroll overflow-x-hidden" style="height: 650px; ">


        @foreach($posts as $post)
        {{-- {{dd($post)}} --}}
            {{-- Post Start --}}

        <div class="">
            <div class="row py-2 border-bottom m-0 p-0">
                <div class="col text-start m-0 p-0 d-flex align-items-center">
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
                        <h4>{{$post['name']}}</h4>
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
                    <h4>{{$post['title']}}</h4>
                    <p>{{$post['description']}}</p>
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


    </div>
@endsection

@elseif(isset($user) && $user['role'] == 'admin_pending')
    <div class="m-5">
        <h4>{{$user['name']}}</h4>
        <p>{{$user['email']}}</p>
        <p class="text-danger">Your account is pending. One of the existing admins will approve you soon.</p>
        <div class="d-flex flex-row">
            <a href="{{route('admin#home')}}" class="btn btn-primary h-100">Reload</a>
            <form action="{{route('logout')}}">
                @csrf
                <button type="submit" class="btn btn-dark h-100 offset-3">Logout</button>
            </form>
        </div>

    </div>
@endif
