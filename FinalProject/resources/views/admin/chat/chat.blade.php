@extends('admin.layout.master')

@section('content')

{{-- This page is under construction. --}}
<div class="d-flex align-items-center pt-2" style="height: 50px;">
    <a href="{{route('admin#chatPage')}}" class="fs-3 me-3">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <img src="" alt="" class="rounded-circle bg-secondary me-3" style="height: 50px; width: 50px;">
    <h4>{{$otheruser['name']}}</h4>
</div>
<hr>
<div style="width: 750px; height: 440px;" class="overflow-auto" id="chatBox">
    {{-- @foreach($chats as $chat)
    <div style="w-100">
        @if($chat['sender_id'] == Auth::user()['id'])
            <div class="bg-primary rounded-2">
                {{$chat['message']}}
            </div>
        @else
            <div class="bg-secondary rounded-2">
                {{$chat['message']}}
            </div>
        @endif
    </div>
    @endforeach --}}
</div>
<br><hr>
<div>
    {{-- <form action="{{route('admin#sendmessage',$otheruser['id'])}}" method="POST"> --}}
        Type here : <input type="text" id="message">
        <button onclick="sendMessage()" class="btn border border-secondary rounded-1">
            <i class="fa-solid fa-paper-plane text-primary"></i>
        </button>
    {{-- </form> --}}


</div>


@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var otherUserId = {!! json_encode($otheruser['id']) !!};
    var currentUserId = {{auth()->user()->id}};

    console.log(currentUserId);

    // $(document).ready(function(){

        function messageReload(){
            console.log('Message reload');
            $.ajax({
                type : 'get',
                url : 'http://127.0.0.1:8000/admin/ajax/chatlist/'+ otherUserId,
                success : function(response){
                //   console.log('chatliststart');
                //   console.log(response);
                    seenMessage();
                  $chats = '';
                  for (let i = 0; i < response.length; i++) {
                    const element = response[i];
                    if(element.sender_id == currentUserId){
                        // console.log('User Current');
                        if(element.deleted == 1){
                            $chats += `
                                <div class = "mt-2 text-end">
                                    <div class="border border-3 border-secondary py-1 px-3 rounded-2" style="height: 50px; display: inline-block;">
                                        <small class="d-block ">${element.created_at}</small>
                                        Unsent message
                                    </div>
                                </div>
                                `;
                        }else{
                            $chats += `
                                <div class = "mt-2 text-end">
                                    <div class="bg-primary py-1 px-3 rounded-2" style="height: 50px; display: inline-block;">
                                        <small class="d-block ">${element.created_at} | <i class="fa-solid fa-trash text-danger fs-5" title="delete message" onclick="deleteMessage(${element.id})"></i></small>
                                        ${element.message}
                                    </div>
                                </div>
                                `;

                        }

                        if(element.seen == true){
                            $chats += `
                            <div class='w-100 text-end'>
                                <small>Seen</small>
                            </div>`
                        }

                    }
                    else{
                        if(element.deleted == 1){
                            $chats += `
                                <div class = "mt-2">
                                    <div class="border border-3 border-secondary py-1 px-3 rounded-2" style="height: 50px; display: inline-block;">
                                        <small class="d-block ">${element.created_at}</small>
                                        Unsent message
                                    </div>
                                </div>
                                `;
                        }else{
                            $chats += `
                                <div class = "mt-2">
                                    <div class="bg-secondary px-3 rounded-2" style="height: 50px; display: inline-block;">
                                        <small class="d-block ">${element.created_at}</small>
                                        ${element.message}
                                    </div>
                                </div>
                                `;
                        }
                    }
                  }
                //   console.log($chats);
                  $('#chatBox').html($chats);
                //   console.log('chatlistend');
                },
                error: function (xhr, status, error) {
                    // Handle errors here
                    console.error(xhr.responseText);
                    console.error(status);
                    console.error(error);
                }
            })
        };




        function sendMessage(){
            let message = $('#message').val();
            // console.log(message);
            $.ajax({
                type : 'post',
                url : 'http://127.0.0.1:8000/admin/ajax/sendMessage/' + otherUserId,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Get the CSRF token from the meta tag
                },
                data: {
                    message: message
                },
                success : function(response){
                //   console.log(response);
                  if(response == 'success'){
                    // $('#message').val() = '';
                    messageReload();
                    // messageReload();
                    // scrollDown();
                  }
                }
            });
        };

        messageReload();

        function seenMessage(){
            $.ajax({
                type : 'get',
                url : 'http://127.0.0.1:8000/admin/ajax/seenmessage',
                success : function(response){
                //   console.log(response);
                }
            });
        }

        function deleteMessage(message){
            $.ajax({
                type : 'get',
                url : 'http://127.0.0.1:8000/admin/ajax/deletemessage/'+ message,
                success : function(response){
                    console.log('deleted');
                    messageReload();
                }
            });
            // console.log(message);
        }


        // function myFunction(){
        //     console.log("Hello world");
        // }
        setInterval(messageReload, 1000);


        // setInterval(messageReload, 1000);

    // })
</script>
