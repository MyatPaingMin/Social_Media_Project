@extends('admin.layout.master')

@section('content')
<h2 class="d-inline mx-3"><a href="{{route('admin#profile')}}"><i class="fa-solid fa-arrow-left"></i></a></h2>
<h2 class="d-inline">Edit Profile</h2>
<div class="w-100">

<form action="{{route('profileUpdate')}}" method="POST" class=" d-flex justify-content-center mt-5 border p-4 rounded">
@csrf

    <div class="col-6  border-end">
        <div class="row g-3 m-2 align-items-center">
            <div class="col-auto">
              <label for="inputPassword6" class="col-form-label">Name</label>
            </div>
            <div class="col-auto">
              <input type="text" name="name" value="{{Auth::user()['name'],old('name')}}" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
            </div>

            @error('name')
                <p>{{$message}}</p>
            @enderror
        </div>

        <div class="row g-3 m-2 align-items-center">
            <div class="col-auto">
              <label for="inputPassword6" class="col-form-label">Email</label>
            </div>
            <div class="col-auto">
              <input type="email" name="email" value="{{Auth::user()['email'],old('email')}}" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
            </div>

            @error('email')
                <p>{{$message}}</p>
            @enderror
        </div>

        <div class="row g-3 m-2 align-items-center">
            <div class="col-auto">
              <label for="inputPassword6" class="col-form-label">date of birth</label>
            </div>
            <div class="col-auto">
              <input type="date" name="DOB" value="{{Auth::user()['DOB'],old('DOB')}}" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
            </div>

            @error('DOB')
                <p>{{$message}}</p>
            @enderror
        </div>

        <div class="row g-3 m-2 align-items-center">
            <div class="col-auto">
              <label for="inputPassword6" class="col-form-label">Gender</label>
            </div>
            <div class="col-auto">
                <select class="form-select" name="gender" aria-label="Default select example">
                    <option @if(Auth::user()['gender'] == 'male') selected @endif value="male">Male</option>
                    <option @if(Auth::user()['gender'] == 'female') selected @endif value="female">Female</option>
                    <option @if(Auth::user()['gender'] == 'hidden' || !Auth::user()['gender']) selected @endif  value="hidden">Hidden</option>
                </select>
            </div>


        </div>

    </div>

    <div class="col-6 ">

        <div class="row g-3 m-2 align-items-center">
            <div class="col-auto">
              <label for="inputPassword6" class="col-form-label">Live in</label>
            </div>
            <div class="col-auto">
              <input type="text" name="location" value="{{Auth::user()['location'],old('location')}}" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
            </div>

        </div>

        <div class="row g-3 m-2 align-items-center">
            <div class="col-auto">
              <label for="inputPassword6" class="col-form-label">Phone</label>
            </div>
            <div class="col-auto">
              <input type="text" name="phone" value="{{Auth::user()['phone'],old('phone')}}" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
            </div>

        </div>

        <div class="row g-3 m-2 align-items-center">
            <div class="col-auto">
              <label for="inputPassword6" class="col-form-label">Facebook</label>
            </div>
            <div class="col-auto">
              <input type="text" name="facebook" value="{{Auth::user()['facebook'],old('facebook')}}" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
            </div>


        </div>

        <div class="row g-3 m-2 align-items-center">
            <div class="col-auto">
              <label for="inputPassword6" class="col-form-label">Twitter</label>
            </div>
            <div class="col-auto">
              <input type="text" name="twitter" value="{{Auth::user()['twitter'],old('twitter')}}" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
            </div>
        </div>

        <div class="row g-3 m-2 align-items-center">
            <div class="col-auto">
              <label for="inputPassword6" class="col-form-label">Instagram</label>
            </div>
            <div class="col-auto">
              <input type="text" name="instagram" value="{{Auth::user()['instragram'],old('instragram')}}" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
            </div>
        </div>

        <div class="row g-3 m-2 align-items-center">
            <div class="col-auto">
              <label for="inputPassword6" class="col-form-label">LinkedIn</label>
            </div>
            <div class="col-auto">
              <input type="text" name="linkedin" value="{{Auth::user()['linkedin'],old('linkedin')}}" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
            </div>
        </div>

        <div class="row g-3 m-2 align-items-center">
            <div class="col-auto">
              <label for="inputPassword6" class="col-form-label">Hobby</label>
            </div>
            <div class="col-auto">
              <input type="text" name="hobby" value="{{Auth::user()['hobby'],old('hobby')}}" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
            </div>
        </div>
    </div>

    <div class="position-absolute" style="left: 80px; bottom: 120px; ">
        <input type="submit" class="btn btn-primary" value="Save Changes">
    </div>
</form>
</div>

@endsection
