@extends('admin.layout.master')

@section('content')
<div class="d-flex m-3">
    <h2 class="d-inline"><a href="{{route('admin#home')}}"><i class="fa-solid fa-arrow-left"></i></a></h2>
    <h2 class="mx-3">Create Post</h2>
</div>


<div class="d-flex align-items-center justify-content-center" style="height: 500px; width: 100%;">


    <form style="width: 50%;"  method="post" action="{{route('createPost')}}" enctype="multipart/form-data">
        @csrf
      <div class="mb-3 form-control-sm " style="width: 100%">
        <label for="loginInputEmail" class="form-label">Title</label>
        <input type="text" name="title" value="{{old('title')}}" class="form-control " style="width:100%; " id="loginInputEmail" aria-describedby="emailHelp">
        @error('title')
            <small style="color: red;">{{$message}}</small>
        @enderror
      </div>
      <div class="mb-3 form-control-sm col" style="width: 100%">
        <label for="loginInputPassword" class="form-label">Description</label>
        <input type="text" name="description" value="{{old('description')}}" class="form-control" style="width:100%; " id="loginInputPassword">
        @error('description')
            <small style="color: red;">{{$message}}</small>
        @enderror
      </div>
      <div class="mb-3 form-control-sm col" style="width: 100%">
        <label for="loginInputPassword" class="form-label">Photo</label>
        <input type="file" name="image" value="{{old('image')}}" class="form-control" style="width:100%; " id="loginInputPassword">
        @error('image')
            <small style="color: red;">{{$message}}</small>
        @enderror
      </div>
      <div class="mb-3 form-control-sm col" style="width: 100%">
        <label for="loginInputPassword" class="form-label">Category</label>
        <select class="form-select" style="width:100%;" name="category" aria-label="Default select example">
            <option value="" selected>Choose a category</option>
            @foreach($categories as $category)
                <option value="{{$category['id']}}" @if(old('category') == $category['id']) selected  @endif>{{$category['category_name']}}</option>
            @endforeach
        </select>
        @error('category')
            <small style="color: red;">{{$message}}</small>
        @enderror

      </div>


      <button type="submit" class="btn btn-primary px-4">Post</button>

      <a href="{{route('admin#home')}}">
        <button type="button" class="btn btn-secondary mx-3">Discard</button>
      </a>

    </form>
  </div>
@endsection
