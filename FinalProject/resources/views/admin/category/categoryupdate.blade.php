@extends('admin.layout.master')

@section('content')
<div class="d-flex m-3">
    <h2 class="d-inline " onclick="history.back()"><i class="fa-solid fa-arrow-left"></i></h2>
    <h2 class="mx-3">Update Category</h2>
</div>


<div class="d-flex align-items-center justify-content-center" style="height: 300px; width: 100%;">

    <form style="width: 50%;"  method="post" action="{{route('updateCategory')}}">
        @csrf
        <input type="text" name="id" value="{{$category['id']}}" hidden>
      <div class="mb-3 form-control-sm " style="width: 100%">
        <label for="loginInputEmail" class="form-label">Name</label>
        <input type="text" name="name" value="{{$category['category_name']}}" class="form-control " style="width:100%; " id="loginInputEmail" aria-describedby="emailHelp">
        @error('name')
            <small style="color: red;">{{$message}}</small>
        @enderror
      </div>
      <div class="mb-3 form-control-sm col" style="width: 100%">
        <label for="loginInputPassword" class="form-label">Description</label>
        <input type="text" name="description" value="{{$category['category_description']}}" class="form-control" style="width:100%; " id="loginInputPassword">
        @error('description')
            <small style="color: red;">{{$message}}</small>
        @enderror
      </div>

      <button type="submit" class="btn btn-primary mx-2">Update</button>

      <a href="{{route('admin#categorylist')}}">
        <button type="button" class="btn btn-secondary mx-3">Discard</button>
      </a>

    </form>
  </div>
@endsection
