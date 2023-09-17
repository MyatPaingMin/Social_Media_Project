<template>
    <main>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/fontawesome.min.css" integrity="sha512-siarrzI1u3pCqFG2LEzi87McrBmq6Tp7juVsdmGY1Dr8Saw+ZBAzDzrGwX3vgxX1NkioYNCFOVC0GpDPss10zQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <div class="main-menu d-none d-md-block">
            <nav>
                <ul id="navigation" class="d-flex ms-5">
                    <li><a @click="homePage()" class="mx-2">Post List</a></li> | 
                    <li><a @click="postPage()" class="mx-2" v-if="tokenStatus">News Feed</a></li> | 
                    <li>
                        <a @click="loginout()" class="mx-2" v-if="tokenStatus">Logout</a>
                        <a @click="loginout()" class="mx-2" v-else>Login</a>
                    </li>
                </ul>
            </nav>
        </div>

        <div style="width: 100%" class="row" v-if="tokenStatus">    

        <div class="card col-6 offset-3 mb-5" style="width: 18rem;" v-for="(post,index) in posts" :key="index">
            <div>        
            <div style="width: 100%; height: 80px; " class="d-flex align-items-center border border-1 rounded-3 my-3">
                <img :src="post.profile" style="width: 50px; height: 50px;" class="mx-2 rounded-circle border border-1 bg-secondary">
                <h5 class="mx-3">{{post.name}} <span class="text-secondary"> {{post.updated_at}}</span>  <i class="fa-solid fa-eye"></i> {{post.view_count}}</h5>
            </div>
            <div style="width:100%">
                <div class="d-flex">
                    <h4 class="card-title text-justify">{{post.title}}</h4>
                    <button  @click="postDetailPage(post.id)" class="btn-primary">Detail</button>
                </div>
                
                <!-- <p class="card-text text-justify">{{post.description}}</p> -->
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

                <div class="col-4 offset-1" style="width: 100px;" @click="commentSection(post.id)">{{post.comment_count}} comment</div>
            </div>
          </div> 
        </div>

        </div>

        <button v-if=" postcount > postLimit" @click="morePost()" class="btn-primary" >More<i class="fa-solid fa-arrow-down"></i></button>

        </div>
        <div v-else>
                Unauthorized ... 
        </div>
      
    </main>
</template>

    

<script scoped>

    import axios from 'axios'
    import {mapGetters} from 'vuex'

    export default{
        name: 'postPage',
        data(){
            return {
                userID : '',
                postLimit : 3,
                postcount : 0,
                posts : [],
                tokenStatus : false,
            }
        },
        methods:{
            headerAuth(){
                let tokenauth = this.gettokenData == null ? "Bearer empty" : "Bearer " + this.gettokenData.slice(1, -1);
                let output = { headers: {
                        Authorization: tokenauth
                    }};
                return output;
            },

            postReload(postID,userID){
                axios
                    .get('http://127.0.0.1:8000/api/postReload/'+ postID + '/' + userID , this.headerAuth())
                    .then((response)=>{
                        for (let i = 0; i < this.posts.length; i++) {
                            if(this.posts[i].id == postID){
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
                                this.posts[i] = response.data;
                                console.log(response.data);
                            }
                        }
                    })
                    .catch((error)=>{
                        if(error.response.status == 200){
                            console.log('Unauthorized')
                        }
                    })
            },
            reactpost(postID,reactNum){
                let userID = JSON.parse(this.getuserData).id;
                console.log(userID);
                axios
                    .post('http://127.0.0.1:8000/api/reactpost',{
                        userid : userID,
                        postid : postID,
                        react : reactNum
                    },this.headerAuth())

                    .then((response)=>{
                        if(response.data == 'success'){
                            this.postReload(postID,userID);
                        }
                    })
                    .catch((error)=>{
                        if(error.response == 200){
                            console.log('Unauthorized')
                        }
                    })
            },
            homePage(){
                console.log('Home');
                this.$router.push({
                    name : 'home'
                })
            },
            loginout(){
                this.tokenStatus = false;
                this.$router.push({
                    name : 'loginPage'
                })
                this.$store.dispatch('loginToken',null);
                console.log(this.gettokenData);
            },
            postPage(){
                this.$router.push({
                    name : 'posts'
                })
            },
            postDetailPage(id){
                console.log('userID is ');
                console.log(this.userID);
                this.$router.push({
                    name: 'postDetail',
                    params: {
                        // userID : this.userID,
                        id : id
                    }
                })
            },
            checkToken(){
                if(this.gettokenData){
                    this.tokenStatus = true;
                }else{
                    this.tokenStatus = false;
                }
            },
            commentSection(postID){
                this.$router.push({
                    name : 'comment',
                    params : {
                        id: postID
                    }
                });
            },
            postList(){
                axios
                .get('http://127.0.0.1:8000/api/postList/'+ JSON.parse(this.getuserData).id + '/' + this.postLimit, this.headerAuth())
                .then((response)=>{
                    for (let i = 0; i < response.data.length; i++) {
                        if(response.data[i].image == null){
                            response.data[i].image = 'http://127.0.0.1:8000/storage/post/default.png';
                        }else{
                            response.data[i].image = 'http://127.0.0.1:8000/storage/post/'+ response.data[i].image;
                        }
                    }

                     for (let i = 0; i < response.data.length; i++) {
                        if(response.data[i].profile == null){
                            if(response.data[i].gender == 'male'){
                                response.data[i].profile = 'http://127.0.0.1:8000/storage/user/default/femaleDefault.jpg';
                            }else if(response.data[i].gender == 'female'){
                                response.data[i].profile = 'http://127.0.0.1:8000/storage/user/default/maleDefault.jpg';
                            }else{
                                response.data[i].profile = 'http://127.0.0.1:8000/storage/user/default/personDefault.jpg';
                            }
                        }else{
                            response.data[i].profile = 'http://127.0.0.1:8000/storage/user/'+ response.data[i].profile;
                        }
                    }
                    
                    this.posts = response.data;
                })
                .then(()=>{
                    console.log(this.posts);
                })
                .catch((error)=>{
                    if(error.response.status == 200){
                        console.log('Unauthorized')
                    }
                });
            },
            morePost(){
                this.postLimit = this.postLimit + 3;
                this.postList();
            }
        },
        computed:{
            ...mapGetters(['getuserData','gettokenData'])
        },
        mounted(){
            // console.log([this.gettokenData,this.getuserData]);
            this.$store.dispatch("loginUser",localStorage.getItem('userData'));
            this.$store.dispatch("loginToken",localStorage.getItem('tokenData'));
            console.log(localStorage.getItem('userData'));
            this.userID = JSON.parse(this.gettokenData).id;

            axios
            .get('http://127.0.0.1:8000/api/currentUser', this.headerAuth())
            .then((response)=>{
                console.log(response);
            });
            
            axios
            .get('http://127.0.0.1:8000/api/tokenCheck', this.headerAuth())
            .then(()=>{
                this.checkToken();
                this.postList();
            })
            .catch((error)=>{
                console.log('Error start');
                console.log(error);
                console.log('Error end');
                if(error.response.status == 401){
                    this.$router.push({
                        name : 'loginPage'
                    });
                }
            });

            axios
            .get('http://127.0.0.1:8000/api/totalPosts',this.headerAuth())
            .then((response)=>{
                console.log(response);
                this.postcount = response.data;
            })
            .catch((error)=>{
                console.log(error);
                if(error.response.status == 401){
                    this.$router.push({
                        name : 'loginPage'
                    });
                }
            });
            
        }
    }

</script>