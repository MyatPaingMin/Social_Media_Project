@extends('admin.layout.master')

@section('content')

<div class="w-100 mt-5 d-flex flex-column justify-content-center align-items-center" >


    <div class="d-flex justify-content-end w-100">
    <form class="d-flex" method="GET" action="{{route('admin#adminlist')}}">
        <input type="text" class="form-control" name="searchkey" value="{{request('searchkey')}}">
        <input type="submit" value="Search" class="btn btn-primary mx-2">
    </form>
    </div>


    <table class="table m-3 table-primary text-center">
        <thead class="table-dark text-center">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col" class="text-center">Email</th>
            <th scope="col">Gender</th>
            <th scope="col">DOB</th>
            <th scope="col">Phone</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody class="text-center">
            @foreach($admins as $admin)
                <tr>
                  <td>{{$admin['id']}}</td>
                  <td>{{$admin['name']}}</td>
                  <td>{{$admin['email']}}</td>
                  <td>{{$admin['gender']}}</td>
                  <td>{{$admin['DOB']}}</td>
                  <td>{{$admin['phone']}}</td>
                  <td>
                    <a href="{{route('adminDetail',$admin['id'])}}" class="text-dark">
                        <i class="fa-solid fa-circle-info"></i>
                    </a>
                  </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
