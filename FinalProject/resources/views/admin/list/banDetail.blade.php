@extends('admin.layout.master')

@section('content')

<div class="d-flex m-3">
    <h2 class="d-inline " ><a href="{{route('admin#userlist')}}"><i class="fa-solid fa-arrow-left"></i></a></h2>
    <h2 class="mx-3">Banned user</h2>
</div>

    <p>{{$user['status']}}</p>

    <br><br>

    <a href="{{route('unban',$user['id'])}}">
        <button>UNBAN</button>
    </a>

@endsection
