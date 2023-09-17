@extends('admin.layout.master')

@section('content')
<h2 class="d-inline mx-3"><a href="{{route('admin#profile')}}"><i class="fa-solid fa-arrow-left"></i></a></h2>
<h2 class="d-inline">Profile Picture</h2>

    <div class="w-100 h-100 d-flex justify-content-center align-items-center">

        <div class=" d-flex justify-content-center align-items-center flex-column" style="width: 500px; height: 350px;">
            @if(Auth::user()['profile'] != NULL)
                 <img src="{{asset('storage/user/'.Auth::user()['profile'])}}" alt="" style="width: 300px; height: 300px;" class="bg-secondary object-fit-cover" >
            @else
                @if(Auth::user()['gender'] == 'female')
                    <img src="{{asset('storage/user/default/femaleDefault.jpg')}}" alt="" style="width: 300px; height: 300px;" class="bg-danger">
                @elseif(Auth::user()['gender'] == 'male')
                    <img src="{{asset('storage/user/default/maleDefault.jpg')}}" alt="" style="width: 300px; height: 300px;" class="bg-primary">
                @else
                    <img src="{{asset('storage/user/default/personDefault.jpg')}}" alt="" style="width: 300px; height: 300px;" class="bg-warning">
                @endif
            @endif

            <br>
            <div class="d-flex justify-content-center">
                <form action="{{route('profilePhotoUpdate')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="photo" value="{{old('photo')}}" class="">
                    @error('photo')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                    <input type="submit" value="Save" class="btn btn-primary">
                </form>

            </div>
        </div>

    </div>
@endsection
