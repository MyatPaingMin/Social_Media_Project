@extends('admin.layout.master')

@section('content')
<div class="row" style="width: 800px;">
<div class="m-3 col d-flex justify-content-end" >
    <a href="{{route("createPostPage")}}">
        <button class="btn btn-primary">Create</button>
    </a>

{{--
    <div class="input-group mx-3" style="width: 200px;">
        <span class="input-group-text" id="basic-addon1">Sort By : </span>
        <select class="form-select form-select-sm" id="sortBy" aria-label="Small select example">
            <option value="id">ID</option>
            <option value="lastUpdate">lastUpdate</option>
            <option value="interest">Interest</option>
        </select>
    </div>
--}}
<div class="input-group mx-3" style="width: 200px; height: 40px;">
    <span class="input-group-text" id="basic-addon1">Sort By : </span>
    <select class="form-select form-select-sm" id="sortBy" onchange="loadSearch()" aria-label="Small select example">
        <option value="id">ID</option>
        <option value="updated_at">lastUpdate</option>
        <option value="interest">Interest</option>
    </select>
</div>

<div class="input-group mx-3" style="width: 200px; height: 40px;">
    <span class="input-group-text" id="basic-addon1">Category : </span>
    <select class="form-select form-select-sm" id="category" onchange="loadSearch()" aria-label="Small select example">
        <option value="" selected>All</option>
        <option value="3">Celebrity</option>
        <option value="6">Music</option>
    </select>
</div>

    <div>
        <input type="text" class="form-control" name="searchkey" id="searchkey" value="{{request('searchkey')}}" aria-label="Recipient's username" aria-describedby="button-addon2">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2" onclick="loadSearch()">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>
{{-- route('admin#listpost') --}}

</div>
</div>
<div class="d-flex justify-content-center align-items-center" style="width: 500px;">
    <table class="table my-2 table-primary text-center" style="width: 100%;">
        <thead class="table-dark" style="width: 500px;">
          <tr>
            <th class="col">ID</th>
            <th class="col">Image</th>
            <th class="col-2">Title</th>
            <th class="col">Description</th>
            <th class="col">Category</th>
            <th class="col">Post creater</th>
            <th class="col">View Count</th>
            <th class="col">Last update</th>
            <th class="col">

            </th>
          </tr>
        </thead>
        <tbody style="width: 500px;" id="tableBody">
            @foreach($posts as $post)
                <tr>
                  <td>{{$post['id']}}</td>
                  @if($post['image'])
                    <td><img src="{{asset('storage/post/'.$post['image'])}}" width="50px"  height="50px" ></td>
                  @else
                    <td><img src="{{asset('storage/post/default.png')}}" width="50px"  height="50px" ></td>
                  @endif
                  {{-- <td><img src="{{File::get(public_path().$post['image'])}}" width="50px"  height="50px" alt=""></td> --}}
                  <td>{{$post['title']}}</td>
                  <td>{{$post['description']}}</td>
                  <td>{{$post['category_name']}}</td>
                  <td>{{$post['creater_name']}}</td>
                  <td>{{$post['view_count']}}</td>
                  <td>{{$post['updated_at']}}</td>
                  <td class="d-flex">
                    <a href="{{route('seePost',$post['id'])}}" class="mx-2 btn btn-danger">
                        <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="{{route('deletePost',$post['id'])}}" class="mx-2 btn btn-danger">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                    <a href="{{route('updatePostPage',$post['id'])}}" class="mx-2 btn btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                  </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

        const loadSearch = () => {
            console.log("Loaded");
            console.log($('#sortBy').val());
            console.log($('#searchkey').val());

            $.ajax({
                url: 'http://127.0.0.1:8000/admin/ajax/loadsearch',
                type: 'GET',
                data: {
                  searchkey: $('#searchkey').val(),
                  sortBy: $('#sortBy').val(),
                  category : $('#category').val()
                },
                success: function(response){
                    console.log(response);
                    let posts = '';
                    for (let i = 0; i < response.length; i++) {
                        const element = response[i];
                        posts += `
                                <tr>
                                    <td>${element.id}</td>
                                    ${element.image ?
                                        `<td><img src="{{asset('storage/post/')}} + ${element.image}" width="50px" height="50px"></td>` :
                                        `<td><img src="{{asset('storage/post/default.png')}}" width="50px" height="50px"></td>`
                                    }
                                    <td>${element.title}</td>
                                    <td>${element.description}</td>
                                    <td>${element.category_name}</td>
                                    <td>${element.creater_name}</td>
                                    <td>${element.view_count}</td>
                                    <td>${element.updated_at}</td>
                                    <td class="d-flex">
                                      <a href="{{url('admin/post/seePost')}}/${element['id']}" class="mx-2 btn btn-danger">
                                          <i class="fa-solid fa-eye"></i>
                                      </a>
                                      <a href="{{url('admin/post/deletePost')}}/${element['id']}" class="mx-2 btn btn-danger">
                                          <i class="fa-solid fa-trash"></i>
                                      </a>
                                      <a href="{{url('admin/post/updatePostPage')}}/${element['id']}" class="mx-2 btn btn-primary">
                                          <i class="fa-solid fa-pen-to-square"></i>
                                      </a>
                                    </td>
                                </tr>
                            `;
                    }
                    $('#tableBody').html(posts);
                }
            })
        }
</script>
