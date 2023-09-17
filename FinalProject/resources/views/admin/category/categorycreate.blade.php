@extends('admin.layout.master')

@section('content')
<div class="d-flex m-3">
    <h2 class="d-inline " ><a href="{{route('admin#categorylist')}}"><i class="fa-solid fa-arrow-left"></i></a></h2>
    <h2 class="mx-3">Create Category</h2>
</div>


<div class="d-flex align-items-center justify-content-center" style="height: 300px; width: 100%;">



    <form style="width: 50%;"  method="post" action="{{route('createCategory')}}">
        @csrf
      <div class="mb-3 form-control-sm " style="width: 100%">
        <label for="loginInputEmail" class="form-label">Name</label>
        <input type="text" name="name" class="form-control " style="width:100%; " id="loginInputEmail" aria-describedby="emailHelp">
        @error('name')
            <small style="color: red;">{{$message}}</small>
        @enderror
      </div>
      <div class="mb-3 form-control-sm col" style="width: 100%">
        <label for="loginInputPassword" class="form-label">Description</label>
        <input type="text" name="description" class="form-control" style="width:100%; " id="loginInputPassword">
        @error('description')
            <small style="color: red;">{{$message}}</small>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary">Create</button>

      <a href="{{route('admin#categorylist')}}">
        <button type="button" class="btn btn-secondary mx-3">Discard</button>
      </a>

    </form>
  </div>
@endsection
