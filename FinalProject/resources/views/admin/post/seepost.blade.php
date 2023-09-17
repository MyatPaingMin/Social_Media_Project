@extends('admin.layout.master')

@section('content')
<div class="d-flex m-3">
    <h2 class="d-inline " ><p onclick="history.back()"><i class="fa-solid fa-arrow-left"></i></p></h2>
    <h2 class="mx-3">Post</h2>
</div>
        {{-- Post Start --}}
        <div class="border border-1 p-4 m-0 rounded">
            <div class="row py-2 border-bottom m-0 p-0">
                <div class="col-8 text-start m-0 p-0">
                    <div class="d-flex my-2">
                        @if($post->profile != NULL)
                             <img src="{{asset('storage/user/'.$post->profile)}}" alt=""  class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                        @else
                            @if($post->gender == 'female')
                                <img src="{{asset('storage/user/default/femaleDefault.jpg')}}" alt="" class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                            @elseif($post->gender == 'male')
                                <img src="{{asset('storage/user/default/maleDefault.jpg')}}" alt="" class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                            @else
                                <img src="{{asset('storage/user/default/personDefault.jpg')}}" alt="" class="rounded-circle bg-secondary mx-3" style="width: 40px; height: 40px;">
                            @endif
                        @endif
                        <h4>{{$post->creater}}</h4>
                    </div>
                    <span class="mx-5">{{$post->updated_at}}</span>
                    <span class=""><i class="fa-solid fa-eye"></i> {{$post->view_count}}</span>
                </div>
                <div class="col text-end">
                    <i class="fa-solid fa-ellipsis"></i>
                </div>
            </div>

            <br>

            <div class="text-center">
                <div class="row text-start">
                    <h4>{{$post->title}}</h4>
                    <p>{{$post->description}}</p>
                </div>
                <img src="{{asset('storage/post/'.$post->image)}}" class="object-fit-contain bg-secondary" style="width: 90%; height: 300px;">
            </div>

            <hr>

            <div class="row">
                <div class="col text-center mb-2">
                    {{$post->react_count}} reacts
                </div>
                <div class="col text-center mb-2">
                    {{$post->comment_count}} comments
                </div>
            </div>
            <hr>
        <div class="row">

        <div class="col-8">
            <h3>Comments</h3>

            <div id="commentSection">
                @foreach($comments as $comment)
                <div class="d-flex offset-1">
                    <div  class="m-1 px-3 rounded-4" style="background-color: rgb(220, 220, 220);">
                        <div class="d-flex mt-2">
                            <img src="{{asset('storage/user/'.$comment->commenter_profile)}}" alt="" style="width:30px; height:30px;" class="rounded-circle bg-secondary me-3">
                            <p>{{$comment->commenter_name}}</p>
                        </div>
                        <div class="d-flex">

                            <p class="ms-1" >{{$comment->text}}</p>
                            <div class="ms-3">
                                <div class="ms-3">
                                    <div>
                                        <button  class="btn-secondary" style="width:50px;height:20px;font-size: 10px;" >Hide</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="btn-primary moreComment" >More</button>

        </div>

        <div class="col-3 ms-4">
            <h3>Reactions</h3>
            <div id="reactSection">
                @foreach($reactions as $reaction)
                    <div style="width: 250px; height: 80px; " class="d-flex align-items-center border border-1 rounded-3 my-3">
                        <img src="" style="width: 50px; height: 50px;" class="mx-2 rounded-circle border border-1 bg-secondary">
                        <h5 class="mx-3">{{$reaction->reacter_name}} </h5>
                        @if($reaction->react == 1)
                            <p class="fs-4 text-success">Like</p>
                        @elseif($reaction->react == 2)
                            <p class="fs-4 text-danger">Dislike</p>
                        @endif
                    </div>
                @endforeach
                {{-- <button class="btn-primary" id="moreReact">More</button> --}}
            </div>
        </div>
    </div>
    </div>
    {{-- Post End --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

    var commentCount = 6;
    var reactCount = 2;
    var postID = {!! json_encode($post['id']) !!};
    var commentCount = {!! json_encode($post['comment_count']) !!};

    console.log(postID);
    console.log(commentCount);

    //     function hideComment(commentID){
    //         console.log(commentID);
    //     }

        $('.moreComment').click(function(){
            console.log($('.moreComment').id);
            commentCount += 2;
            $.ajax({
                type : 'get',
                url : 'http://127.0.0.1:8000/admin/ajax/comment/'+ postID + '/' + commentCount,
                success : function(response){
                    console.log(response);
                    resultcomments = '';
                    for (let i = 0; i < response.length; i++) {
                        let comment = response[i];

                        resultcomments += `
                        <div class="d-flex offset-1">
                        <div  class="m-1 px-3 rounded-4" style="background-color: rgb(220, 220, 220);">

                            <div class="d-flex mt-2">
                                <img src="{{asset('storage/user')}}/${comment.commenter_profile}" alt="" style="width:30px; height:30px;" class="rounded-circle bg-secondary me-3">
                                <p>${comment.commenter_name}</p>
                            </div>
                            <div class="d-flex">

                                <p class="ms-1" >${comment.text}</p>
                                <div class="ms-3">
                                    <div class="ms-3">
                                        <div>
                                            <button  class="btn-secondary" style="width:50px;height:20px;font-size: 10px;" >Hide</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                            `;
                    }

                    $('#commentSection').html(resultcomments);

                    if(response.length <= commentCount){
                        console.log('hello');
                        $('.moreComment').hide();
                    }
                }
            })
        })



    //     $('#moreReact').click(function(){
    //         reactCount += 5;
    //         $.ajax({
    //             type : 'get',
    //             url : 'http://127.0.0.1:8000/admin/ajax/react/' + postID +'/'+ reactCount,
    //             success : function(response){
    //                 console.log(response);

    //                 if(response.totalreact <= reactCount){
    //                     $('#moreReact').display('none');
    //                 }
    //             }
    //         })
    //     })

</script>


@endsection
