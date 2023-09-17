<template>

<main>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css" integrity="sha512-siarrzI1u3pCqFG2LEzi87McrBmq6Tp7juVsdmGY1Dr8Saw+ZBAzDzrGwX3vgxX1NkioYNCFOVC0GpDPss10zQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    This is Detail page.

    <span class="mx-5" @click="postPage()"><i class="fa-solid fa-arrow-left text-primary"></i></span>
    <div style="width: 100%" class="row" v-if="tokenStatus == true">    

        <div class="card col-6 offset-3 mb-5" style="width: 18rem;">
            <div  style="width: 100%; height: 80px; " class="d-flex align-items-center border border-1 rounded-3 my-3">
                <img :src="post.profile" style="width: 50px; height: 50px;" class="mx-2 rounded-circle border border-1 bg-secondary">
                <h5 class="mx-3">{{post.name}} <span class="text-secondary"> {{post.updated_at}}</span>  <i class="fa-solid fa-eye"></i> {{post.view_count}}</h5>
            </div>
            <div style="width:100%">
                <h4 class="card-title text-justify">{{post.title}}</h4>
                <p class="card-text text-justify">{{post.description}}</p>
            </div>
          <img :src="post.image" class="card-img-top bg-secondary object-fit-contain" style="width: 100%; height: 300px;" alt="...">
          <div class="card-body">
            
            <div class="row" style="height: 50px;">
                <div class="col-5 offset-1" style="width: 100px;" >

                    <span class="material-symbols-outlined text-primary mx-1" @click="reactpost(post.id,'like')" v-if="post.user_react == 1">
                        thumb_up
                    </span>
                    <span class="material-symbols-outlined mx-1" @click="reactpost(post.id,'like')" v-else>
                        thumb_up
                    </span>

                    <span class="material-symbols-outlined text-primary mx-1" @click="reactpost(post.id,'dislike')" v-if="post.user_react == 2">
                        thumb_down
                    </span>
                    <span class="material-symbols-outlined mx-1" @click="reactpost(post.id,'dislike')" v-else>
                        thumb_down
                    </span>

                    <span class="mx-4">{{post.react_count}} reacts</span>
                </div>

                <div class="col-4 offset-1" style="width: 100px;">{{post.comment_count}} comment</div>
            </div>
          </div> 
        </div>
    </div>


    <div class="row" style="margin: 0px 450px;">
        <div class="col-8">

        <div>
        <h3 class="mt-3">
             Comments
        </h3>
        <!-- onclick="history.back()" -->
        <div v-if="comments.length || commentloading || commentposting">
            <div v-if="commentloading">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <div v-else>
                <div class="d-flex offset-1" v-for="(comment,index) in comments" :key="index">
                    <div  class="m-1 px-3 rounded-4" style="background-color: rgb(220, 220, 220);" v-if="comment.parent == null">
                        <div class="d-flex mt-2">
                            <img :src="comment.commenter_profile" alt="" style="width:30px; height:30px;" class="rounded-circle bg-secondary me-3">
                            <p>{{comment.commenter}}</p>
                        </div>
                        <div class="d-flex">
                            <input type="text" v-model="editCmt" v-if="editing == true && editID == comment.id">
                            <p class="ms-1" v-else>{{comment.text}}</p>

                            <div class="ms-3">
                                <div class="ms-3" v-if="comment.commenter_id == userID">
                                    <div v-if="editing == true && editID == comment.id">
                                        <button  class="btn-secondary" style="width:50px;height:20px;font-size: 10px;" @click="cancelEdit()">Cancel</button>
                                        <button  class="btn-success" style="width:50px;height:20px;font-size: 10px;" @click="updateComment()">Save</button>
                                    </div>
                                    <div v-else>
                                        <button  class="btn-danger" style="width:50px;height:20px;font-size: 10px;" @click="deleteComment(comment.id)">Delete</button>
                                        <button  class="btn-primary" style="width:50px;height:20px;font-size: 10px;" @click="editComment(comment.text,comment.id)">Edit</button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="px-3 py-1 rounded-4" style="margin: 10px; margin-start:100px; background-color: rgb(220, 220, 220);" v-else>
                        <div class="d-flex mt-2">
                            <img :src="comment.commenter_profile" alt="" style="width:30px; height:30px;" class="rounded-circle bg-secondary me-3">
                            <p>{{comment.commenter}}</p>
                        </div>
                        <div class="d-flex">
                            <input type="text" v-model="editCmt" v-if="editing == true && editID == comment.id">
                            <p class="ms-1" v-else>{{comment.text}}</p>

                            <div class="ms-3">
                                <div class="ms-3" v-if="comment.commenter_id == userID">
                                    <div v-if="editing == true && editID == comment.id">
                                        <button  class="btn-secondary" style="width:50px;height:20px;font-size: 10px;" @click="cancelEdit()">Cancel</button>
                                        <button  class="btn-success" style="width:50px;height:20px;font-size: 10px;" @click="updateComment(comment.text,comment.id)">Save</button>
                                    </div>
                                    <div v-else>
                                        <button  class="btn-danger" style="width:50px;height:20px;font-size: 10px;" @click="deleteComment(comment.id)">Delete</button>
                                        <button  class="btn-primary" style="width:50px;height:20px;font-size: 10px;" @click="editComment(comment.text,comment.id)">Edit</button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <button v-if="post.comment_count > commentLimit" class="btn-primary" @click="moreComment()">More</button>

            </div>
        </div>
        <div class="text-primary" v-else>
            <br>
            <br>
                <h3 class="text-secondary">No comments to show.</h3>
            <br>
            <br>
        </div>
        

        <div class='d-block'>
            <div class="spinner-border text-primary" role="status" v-if="commentposting">
              <span class="visually-hidden">Loading...</span>
            </div>
            <div v-else>
                <input type="text" class="" v-model="usercomment">
                <button type="button" class="btn-secondary" style="width:50px;height:20px;font-size: 10px;"  @click="commented()">Comment</button>
            </div>
            <br><br>
        </div>

    </div>
        </div>
        <div class="col-3 ms-4">
            <h3>Reactions</h3>
            <div v-if="reactLoading == false">
                <div v-for="(reaction,index) in reactions" :key="index"  style="width: 250px; height: 80px; " class="d-flex align-items-center border border-1 rounded-3 my-3">
                    <img :src="reaction.profile" style="width: 50px; height: 50px;" class="mx-2 rounded-circle border border-1 bg-secondary">
                    <h5 class="mx-3">{{reaction.name}} </h5>
                    <p v-if="reaction.react == 1" class="fs-4 text-success">Like</p>
                    <p v-if="reaction.react == 2" class="fs-4 text-danger">Dislike</p>
                </div>
                <button v-if="post.react_count > reactLimit" class="btn-primary" @click="moreReact()">More</button>
            </div>
            <div v-else>
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</main>

</template>
<script>
import axios from 'axios'
import {mapGetters} from 'vuex'
    export default{
        data(){
            return {
                name: "DefaultPage",
                id : this.$route.params.id ,
                userID : 1,
                tokenStatus: true,
                commentloading : false,
                commentposting : false,
                commentLimit: 2,
                reactLimit: 1,
                reactLoading : false,
                editing : false,
                editCmt : '',
                editID : '',
                comments : [],
                reactions : [],
                post : ''
            }
        },
        methods : {
            headerAuth(){
                let tokenauth = this.gettokenData == null ? "Bearer empty" : "Bearer " + this.gettokenData.slice(1, -1);
                let output = { headers: {
                        Authorization: tokenauth
                    }};
                return output;
            },
            unauthorizedMsg(error){
                if(error.response.status == 401){
                    this.unauthorized = true;
                }
            },
            back(){
                // history.back();
                this.$router.push({
                    name: "posts"
                })
            },
            commentSection(a){
                console.log(a);
            },
            postPage(){
                this.$router.push({
                    name : 'posts'
                })
            },
            reactpost(postID,reaction){
                console.log(postID, reaction);
                let userID =  this.getuserData.id;
                console.log(userID);
                axios
                    .post('http://127.0.0.1:8000/api/reactpost',{
                        userid : userID,
                        postid : postID,
                        react : reaction
                    }, this.headerAuth())

                    .then((response)=>{
                        console.log(response);
                        this.postReload(postID,userID);
                    })
                    .catch((error)=>{
                        console.log(error);
                    })
            },
            checktoken(){
                if(this.gettokenData){
                    console.log(this.gettokenData);
                    this.tokenStatus = true;
                }else{
                    this.tokenStatus = false;
                    console.log('Empty');
                }
            },
            loadComment(){
                this.userID = this.getuserData.id;
                this.commentloading =  true;
                axios
                    .get('http://127.0.0.1:8000/api/comment/'+ this.id + '/' + this.commentLimit, this.headerAuth())
                    .then((response)=>{
                        console.log('DATA');
                        console.log(response.data);
                        this.comments = response.data;
                        this.commentloading = false;
                    })
                    .catch((error)=>{
                        console.log(error);
                    });
            },
            
            commented(){
                this.commentposting = true;
                axios
                    .post('http://127.0.0.1:8000/api/createComment',{
                        postID : this.id,
                        userID : this.userID,
                        text : this.usercomment,
                        parent : this.parent
                    }, this.headerAuth())

                    .then((response) => {
                        if(response.status == 200){
                            this.usercomment = '';
                            this.parent = '';
                            this.commentposting = false;
                            this.loadComment();
                        }
                    })
                    .catch((error)=>{
                        console.log(error);
                    });
            },
            replyComment(commentparent){
                this.parent = commentparent;
            },
            deleteComment(id){
                axios
                    .delete('http://127.0.0.1:8000/api/deleteComment/' + id, this.headerAuth())
                    .then((response)=>{
                        if(response.status == 200){
                            console.log('success');
                
                            for (let i = 0; i < this.comments.length; i++) {
                                if(this.comments[i].id == id){
                                    let index = this.comments.indexOf(this.comments[i]);
                                    this.comments.splice(index,1);
                                }
                            }
                            alert('Comment deleted');
                        }
                    })
                    .catch((error)=>{
                        console.log(error);
                    })
            },
            loadReact(){
                this.reactLoading = true;
                axios
                    .get('http://127.0.0.1:8000/api/react/'+ this.id + '/' + this.reactLimit, this.headerAuth())
                    .then((response)=>{
                        console.log(response.data);

                        if(response.data.profile == null){
                            if(response.data.gender == 'male'){
                                response.data.profile = 'http://127.0.0.1:8000/storage/user/default/femaleDefault.jpg';
                            }else if(response.data.gender == 'female'){
                                response.data.profile = 'http://127.0.0.1:8000/storage/user/default/maleDefault.jpg';
                            }else{
                                response.data.profile = 'http://127.0.0.1:8000/storage/user/default/personDefault.jpg';
                            }
                        }else{
                            response.data.profile = 'http://127.0.0.1:8000/storage/user/'+ response.data.profile;
                        }
                        this.reactLoading = false;
                        this.reactions = response.data;


                    })
                    .catch((error)=>{
                        console.log(error);
                    })
            },
            postReload(postID,userID){
                axios
                    .get('http://127.0.0.1:8000/api/postReload/'+ postID + '/' + userID , this.headerAuth())
                    .then((response) => {
                        if(response.data.id == postID){
                            // console.log(response.data);
                            if(response.data.image == null){
                                response.data.image = 'http://127.0.0.1:8000/storage/post/default.png';
                            }else{
                                response.data.image = 'http://127.0.0.1:8000/storage/post/'+ response.data.image;
                            }
                            if(response.data.profile == null){
                                if(response.data.gender == 'male'){
                                    response.data.profile = 'http://127.0.0.1:8000/storage/user/default/femaleDefault.jpg';
                                }else if(response.data.gender == 'female'){
                                    response.data.profile = 'http://127.0.0.1:8000/storage/user/default/maleDefault.jpg';
                                }else{
                                    response.data.profile = 'http://127.0.0.1:8000/storage/user/default/personDefault.jpg';
                                }
                            }else{
                                response.data.profile = 'http://127.0.0.1:8000/storage/user/'+ response.data.profile;
                            }
                            this.post = response.data;
                            console.log('response');
                            console.log(response.data);
                            this.loadReact();
                        }
                    })
                    .catch((error)=>{
                        console.log(error);
                    })
            },
            moreComment(){
                this.commentLimit += 10;
                this.loadComment();
            },
            moreReact(){
                this.reactLimit += 10;
                this.loadReact();
            },
            editComment(text,id){
                console.log(text);
                this.editing = true;
                this.editCmt = text;
                this.editID = id;
            },
            cancelEdit(){
                this.editing = false;
                this.editID = '';
                this.editCmt = '';
            },
            updateComment(){
                // console.log(text,id);
                console.log(this.editID,this.editCmt);
                axios
                .post('http://127.0.0.1:8000/api/updateComment/',{
                    commentID : this.editID,
                    text: this.editCmt
                }, this.headerAuth())
                .then(()=>{

                    this.commentloading = true;
                    //loadOnecomment start
                    axios
                        .get('http://127.0.0.1:8000/api/onecomment/'+ this.id + '/' + this.editID, this.headerAuth())
                        .then((output)=>{
                            console.log(this.comments);
                            for (let i = 0; i < this.comments.length; i++) {
                                if(this.comments[i].id == output.data[0].id){
                                    this.comments[i] = output.data[0];
                                }
                            }
                            console.log(output.data[0]);
                        })
                        .catch((error)=>{
                            console.log(error);
                        });
                    //loadOneComment End
                    this.commentloading = false;

                    this.cancelEdit();
                })
                .catch((error)=>{
                    console.log(error);
                })
            }
        },
        computed:{
            ...mapGetters(['getuserData','gettokenData','getuserID'])
        },
        mounted(){
            console.log(JSON.parse(localStorage.getItem('userData')))

            this.$store.dispatch("loginUser",JSON.parse(localStorage.getItem('userData')));
            this.$store.dispatch("loginToken",localStorage.getItem('tokenData'));

            this.userID = this.getuserID;
            console.log('start');
            console.log(this.getuserID);
            console.log(this.getuserData);
            console.log('end');
            
            axios
                .get('http://127.0.0.1:8000/api/tokenCheck', this.headerAuth())
                .then(()=>{
                    this.checktoken();
                    this.loadReact();
                    this.loadComment();
                })
                .then(()=>{
                    axios
                        .get("http://127.0.0.1:8000/api/postReload" + '/' + this.id +  '/' +  this.userID, this.headerAuth())
                        .then((response)=>{
                            console.log(response);
                            // console.log('output');
                            if(response.data.image == null){
                                response.data.image = 'http://127.0.0.1:8000/storage/post/default.png';
                            }else{
                                response.data.image = 'http://127.0.0.1:8000/storage/post/'+ response.data.image;
                            }
                            if(response.data.profile == null){
                                if(response.data.gender == 'male'){
                                    response.data.profile = 'http://127.0.0.1:8000/storage/user/default/femaleDefault.jpg';
                                }else if(response.data.gender == 'female'){
                                    response.data.profile = 'http://127.0.0.1:8000/storage/user/default/maleDefault.jpg';
                                }else{
                                    response.data.profile = 'http://127.0.0.1:8000/storage/user/default/personDefault.jpg';
                                }
                            }else{
                                response.data.profile = 'http://127.0.0.1:8000/storage/user/'+ response.data.profile;
                            }
                            this.post = response.data;
                            
                            console.log(this.post);   
                        })
                        .catch(()=>{
                            console.log('unauthorized.');
                        })
                })
                .catch(()=>{
                    this.$router.push({
                        name: 'loginPage'
                    });
                })

            
            // console.log(this.getuserData.id);
            // console.log(this.getuserData);
        }
    }
</script>