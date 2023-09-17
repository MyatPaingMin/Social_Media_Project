@extends('admin.layout.master')

@section('content')
<h4>Waiting for approvement to become admin</h4>
<div class="w-100 d-flex justify-content-center align-items-center" >
    <table class="table m-5 table-primary">
        <thead class="table-dark">
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
        <tbody>
            @foreach($adminPending as $admin)
                <tr>
                  <td>{{$admin['id']}}</td>
                  <td>{{$admin['name']}}</td>
                  <td>{{$admin['email']}}</td>
                  <td>{{$admin['gender']}}</td>
                  <td>{{$admin['dob']}}</td>
                  <td>{{$admin['phone']}}</td>
                  <td>
                    <a class="btn btn-primary" href="{{route('admin#approve',$admin['id'])}}">Accept</a>
                    <a class="btn btn-danger" href="{{route('admin#deny',$admin['id'])}}">Deny</a>
                  </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
