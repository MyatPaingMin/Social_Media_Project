
@extends('admin.layout.master')

@section('content')
<div class="" style="width: 700px; margin-left: 50px;">
{{-- {{dd($convas)}} --}}
    @foreach($convas as $conva)
    <div class="row border border-2 border-secondary d-flex justify-content-center align-items-center rounded-2 my-3" style="height: 60px;">
        <div class="col-4 d-flex">
            <img src="" alt="" width="45px" height="45px" class="rounded-circle bg-secondary" >
            <h4>{{$conva->other_name}}</h4>
        </div>
        <div class="col-6">
            @if($conva->last_msg_sender == Auth::user()['id'])
                <p>You : {{$conva->last_msg_message}}</p>
            @else
                <p>{{$conva->other_name}} : {{$conva->last_msg_message}}</p>
            @endif
        </div>
        <div class="col-1">
            <a class="btn btn-primary" href="{{route('admin#chat',$conva->other_id)}}">
                Enter
            </a>
        </div>
    </div>
    @endforeach

</div>
@endsection

