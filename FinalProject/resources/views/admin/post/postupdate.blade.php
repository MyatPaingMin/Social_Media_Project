@extends('admin.layout.master')

@section('content')
<div class="d-flex m-3">
    <h2 class="d-inline " ><a href="{{route('admin#listpost')}}"><i class="fa-solid fa-arrow-left"></i></a></h2>
    <h2 class="mx-3">Update Post</h2>
</div>

{{-- 'posts.id','image','title','description','users.name as creater_name','categories.category_name as category_name','view_count','posts.updated_at') --}}
{{-- {{dd($post)}} --}}
<div class="d-flex align-items-center justify-content-center" style="height: 500px; width: 100%;">
{{-- {{dd($post['image'])}} --}}
<div class="bg-secondary me-5 rounded-2 d-flex justify-center align-center" style="width: 280px; height: 100%;">
    <img src="{{asset('storage/post/'.$post['image'])}}" alt="" class=" object-fit-contain" width="100%" >
</div>
    <form style="width: 50%;"  method="post" action="{{route('updatePost')}}" enctype="multipart/form-data">
        @csrf
        <input type="text" name="id" value="{{$post['id']}}" hidden>

      <div class="mb-3 form-control-sm " style="width: 100%">
        <label for="formtitle" class="form-label">Title</label>
        <input type="text" name="title" value="{{$post['title'],old('title')}}" class="form-control " style="width:100%; " id="formtitle" aria-describedby="emailHelp">
        @error('title')
            <small style="color: red;">{{$message}}</small>
        @enderror
      </div>
      <div class="mb-3 form-control-sm col" style="width: 100%">
        <label for="formdescription" class="form-label">Description</label>
        <input type="text" name="description" value="{{$post['description'],old('description')}}" class="form-control" style="width:100%; " id="formdescription">
        @error('description')
            <small style="color: red;">{{$message}}</small>
        @enderror
      </div>

      <div class="mb-3 form-control-sm " style="width: 100%">
        <label for="formcreater" class="form-label">Creater</label>
        <input type="text" name="creater" value="{{$post['creater']}}" class="form-control " style="width:100%; " id="formcreater" aria-describedby="emailHelp" disabled>
      </div>

      @if(isset($post['updated_by']))
      <div class="mb-3 form-control-sm " style="width: 100%">
        <label for="formupdater" class="form-label">Last updated by</label>
        <input type="text" name="updated_by" value="{{$post['updated_by'],old('updated_by')}}" class="form-control " style="width:100%; " id="formupdater" aria-describedby="emailHelp" disabled>
      </div>
      @endif

      <div class="mb-3 form-control-sm col" style="width: 100%">
        <label for="formphoto" class="form-label">Change Photo</label>
        <input type="file" name="image" value="{{old('image')}}" class="form-control" style="width:100%; " id="formphoto">
        @error('image')
            <small style="color: red;">{{$message}}</small>
        @enderror
      </div>

      {{-- || $post['category_id'] == $category['id'] --}}
      {{-- old('category') == $category['id'] --}}
      <div class="mb-3 form-control-sm col" style="width: 100%">
        <label for="formcategory" class="form-label">Category</label>
        <select class="form-select" value="{{old('category')}}" style="width:100%;" name="category" aria-label="Default select example">
            @foreach($categories as $category)
                <option value="{{$category['id']}}" @if($post['category_id'] == $category['id']) selected  @endif>{{$category['category_name']}}</option>
            @endforeach
        </select>
        @error('category')
            <small style="color: red;">{{$message}}</small>
        @enderror

      </div>


      <button type="submit" class="btn btn-success px-4">Update</button>

      <a href="{{route('admin#listpost')}}">
        <button type="button" class="btn btn-secondary mx-3">Discard</button>
      </a>

    </form>
  </div>
@endsection
