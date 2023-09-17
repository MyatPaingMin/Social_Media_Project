@extends('admin.layout.master')

@section('content')

<h2 class="d-inline mx-3"><a href="{{route('admin#profile')}}"><i class="fa-solid fa-arrow-left"></i></a></h2>
<h2 class="d-inline">Change Password</h2>

<div class="w-100">
    <form action="{{route('profilePasswordUpdate')}}" method="POST" class=" d-flex justify-content-center mt-5 border p-4 rounded">
    @csrf


        <div class="col-7 ">
            <div class="row g-3 m-2 align-items-center">
                <div class="col-auto">
                  <label for="inputPassword6" class="col-form-label">Original Password</label>
                </div>
                <div class="col-auto">
                  <input type="password" name="oldpassword" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
                </div>

                @error('oldpassword')
                    <small style="color: red;">{{$message}}</small>
                @enderror
            </div>

            <div class="row g-3 m-2 align-items-center">
                <div class="col-auto">
                  <label for="inputPassword6" class="col-form-label">New password</label>
                </div>
                <div class="col-auto mx-4">
                  <input type="password" name="newpassword" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
                </div>
                @error('newpassword')
                    <small style="color: red;">{{$message}}</small>
                @enderror
            </div>

            <div class="row g-3 m-2 align-items-center">
                <div class="col-auto">
                  <label for="inputPassword6" class="col-form-label">Confirm Password</label>
                </div>
                <div class="col-auto">
                  <input type="password" name="confirmpassword" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
                </div>
                @error('confirmpassword')
                    <small style="color: red;">{{$message}}</small>
                @enderror
            </div>

            <input type="submit" class="btn btn-primary px-5 py-2 m-3"  value="Save">
        </div>
    </form>
</div>
@endsection
