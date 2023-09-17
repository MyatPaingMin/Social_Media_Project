@extends('admin.layout.master')

@section('content')
<div class="row">
<div class="m-3 col d-flex justify-content-end" >
    <a href="{{route("createCategoryPage")}}">
        <button class="btn btn-primary">Create New</button>
    </a>

    <div class="input-group mx-3" style="width: 200px;">
        <span class="input-group-text" id="basic-addon1">Sort By : </span>
        <select class="form-select form-select-sm" id="sortBy" aria-label="Small select example">
            <option value="id">ID</option>
            <option value="lastUpdate">lastUpdate</option>
            <option value="interest">Interest</option>
        </select>
    </div>

    <form class="input-group" style="width: 200px;" action="{{route('admin#categorylist')}}" method="GET">
        <input type="text" class="form-control" name="searchkey" value="{{request('searchkey')}}" aria-label="Recipient's username" aria-describedby="button-addon2">
        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>

</div>
<div class="col d-flex justify-content-center align-items-center" >
    <table class="table mx-2 my-2 table-primary text-center">
        <thead class="table-dark">
          <tr>
            <th class="col">ID</th>
            <th class="col-2">Name</th>
            <th class="col">Description</th>
            <th class="col">People Interest</th>
            <th class="col">Last update</th>
            <th class="col"></th>
          </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                  <td>{{$category['id']}}</td>
                  <td>{{$category['category_name']}}</td>
                  <td>{{$category['category_description']}}</td>
                  <td>0</td>
                  <td>{{$category['updated_at']}}</td>
                  <td class="d-flex">
                    <a href="{{route('deleteCategory',$category['id'])}}" class="mx-2 btn btn-danger">
                        <i class="fa-solid fa-trash"></i>
                    </a>

                    <a href="{{route('updateCategoryPage',$category['id'])}}" class="mx-2 btn btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                  </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function(){
        $('#sortBy').change(function(){
            console.log(this.value);
            $.ajax({
                type: 'GET',
                url: 'http://127.0.0.1:8000/admin/categoryOrder',
                data: {
                    'order' : this.value
                },
                datatype: 'json',
                success: function(response){
                    console.log('correcet');
                    $allCategory = '';
                    response.forEach(category => {
                        $allCategory += `
                            <tr>
                                <td>${category['id']}</td>
                                <td>${category['category_name']}</td>
                                <td>${category['category_description']}</td>
                                <td>0</td>
                                <td>${category['updated_at']}</td>
                                <td class="d-flex">
                                  <a href="{{route('deleteCategory',${category['id']})" class="mx-2 btn btn-danger">
                                      <i class="fa-solid fa-trash"></i>
                                  </a>

                                  <a href="{{route('updateCategoryPage',${category['id']})" class="mx-2 btn btn-primary">
                                      <i class="fa-solid fa-pen-to-square"></i>
                                  </a>
                                </td>
                            </tr>
                        `;
                    });
                    $('tbody').html($allCategory);
                }
            })

        })
    })
</script>
@endsection


