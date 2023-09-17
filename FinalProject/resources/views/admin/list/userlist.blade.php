@extends('admin.layout.master')

@section('content')
{{-- {{dd($users->toArray())}} --}}

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
            @foreach($users as $user)
                <tr>
                  <td>{{$user['id']}}</td>
                  <td>{{$user['name']}}</td>
                  <td>{{$user['email']}}</td>
                  <td>{{$user['gender']}}</td>
                  <td>{{$user['DOB']}}</td>
                  <td>{{$user['phone']}}</td>
                  <td class="d-flex">
                    <a href="{{route('userDelete',$user['id'])}}" class="mx-2 btn btn-danger">
                        <i class="fa-solid fa-trash"></i>
                    </a>

                    <div class="dropdown" style="width: 30px;">
                            @if($user['status'] == NULL)
                        <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ban"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{route('userBan',[$user['id'],1])}}">1 day</a></li>
                            <li><a class="dropdown-item" href="{{route('userBan',[$user['id'],2])}}">1 week</a></li>
                            <li><a class="dropdown-item" href="{{route('userBan',[$user['id'],3])}}">1 month</a></li>
                            <li><a class="dropdown-item" href="{{route('userBan',[$user['id'],4])}}">6 month</a></li>
                        </ul>
                            @else

                            <a href="{{route('banDetail',$user['id'])}}" class="text-white">


                                <button type="button" title="Banned already" class="btn btn-danger position-relative">
                                    <i class="fa-solid fa-ban"></i>
                                    @if($user['over'])
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                      over
                                      {{-- <span class="visually-hidden">unread messages</span> --}}
                                    </span>
                                    @endif
                                </button>
                            </a>
                            @endif

                      </div>
                    {{-- <form action="{{route('userBan',$user['id'])}}" method="POST">
                      <div class="form-check ">
                          <input class="form-check-input dropdown-item" type="radio" name="banPeriod" selected id="flexRadioDefault6" checked>
                          <label class="form-check-label" for="flexRadioDefault6">
                            None
                          </label>
                      </div>
                      <div class="form-check dropdown-item">
                          <input class="form-check-input" type="radio" name="banPeriod" id="flexRadioDefault1">
                          <label class="form-check-label" for="flexRadioDefault1">
                            3 hour
                          </label>
                      </div>
                      <div class="form-check dropdown-item">
                          <input class="form-check-input" type="radio" name="banPeriod" id="flexRadioDefault2" checked>
                          <label class="form-check-label" for="flexRadioDefault2">
                            1 day
                          </label>
                      </div>
                      <div class="form-check dropdown-item">
                          <input class="form-check-input" type="radio" name="banPeriod" id="flexRadioDefault3" checked>
                          <label class="form-check-label" for="flexRadioDefault3">
                            1 week
                          </label>
                      </div>
                      <div class="form-check dropdown-item">
                          <input class="form-check-input" type="radio" name="banPeriod" id="flexRadioDefault4" checked>
                          <label class="form-check-label" for="flexRadioDefault4">
                            1 month
                          </label>
                      </div>
                      <div class="form-check dropdown-item">
                          <input class="form-check-input" type="radio" name="banPeriod" id="flexRadioDefault5" checked>
                          <label class="form-check-label" for="flexRadioDefault5">
                            6 month
                          </label>
                      </div>
                      <input type="submit" value="Ban" class="btn btn-danger px-3 py-2">
                    </form> --}}

                    <div class="mx-2 text-danger position-relative banCross" id="{{$user['id']}}">
                        {{-- @if($user['ban'] == 0) --}}

                        {{-- @else --}}
                            {{-- <i class="fa-solid fa-ban" id="banCross"></i> --}}
                        {{-- @endif --}}

                        <div class="position-absolute bg-white border border-1 border-primary rounded" id="banChoice" style="width: 400px;top: 50px; right: 0px; display: none;">

                        </div>
                        <div class="" id="hi">
                      </div>
                    </div>
                    <a href="{{route('userDetail',$user['id'])}}" class="mx-2 btn btn-dark">
                        <i class="fa-solid fa-circle-info"></i>
                    </a>
                  </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>


</script>
@endsection


