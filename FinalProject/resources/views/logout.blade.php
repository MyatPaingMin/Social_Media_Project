<form action="{{route('logout')}}" method="POST">
    @csrf
    <input type="text" value="{{Auth::user()['id']}},{{Auth::user()['name']}}" disabled>
    <input type="submit" value="LOG OUT">
</form>
