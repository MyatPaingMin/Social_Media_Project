
<template>

    <main>
          <!-- Main-menu -->
    <div>
        <div class="main-menu d-none d-md-block">
            <nav>
                <ul id="navigation" class="d-flex ms-5">
                    <li><a @click="homePage()" class="mx-2">Post List</a></li> | 
                    <li><a @click="postPage()" class="mx-2" v-if="tokenStatus">News Feed</a></li> | 
                    <li>
                        <a @click="logout()" class="mx-2" v-if="tokenStatus">Logout</a>
                        <a @click="logout()" class="mx-2" v-else>Login</a>
                    </li>
                </ul>
            </nav> 
        </div>
    </div>
    <!-- Mobile Menu -->

        <!--  Recent Articles start -->
        <div  v-if="tokenStatus && !unauthorized">
        <div class="recent-articles">
            <div class="container">
                <div class="recent-wrapper">

                    <!-- nac start -->
                    <ul class="nav justify-content-end ">
                        <div class="d-flex bg-secondary flex-direction-column">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#" @click="categoryChoose(0)">All</a>
                            </li>
                            <li class="nav-item" v-for="(category,index) in categorylist" :key="index">
                                <a class="nav-link active" aria-current="page" href="#" @click="categoryChoose(category.id)">{{category.category_name}}</a>
                            </li>
                        </div>      
                    </ul>
                    <!-- nav end -->

                    <br>

                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" v-model="searchkey">
                        <button class="btn btn-outline-success" type="button" @click="searchMethod()">Search</button>
                    </form>
                    <br>


                    <!-- section Tittle -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-tittle mb-30"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                    
                            <div class="recent-active dot-style d-flex dot-style" v-if="loadingData == false && postlist.length != 0">                                
                                
                                    <div class="single-recent mb-100" v-for="(post,index) in postlist" :key="index" >
                                        <div @click="postDetailMethod(post.id)">
                                        <div class="what-img">
                                            <img :src="post.image" alt="" style="width:150px;height:200px;"/>
                                        </div>
                                        <div class="what-cap">
                                            <span class="color1">{{post.title}}</span>
                                            <h4>
                                                <a href="#">{{post.description.substring(0,8)+" ..."}}</a>
                                            </h4>
                                        </div>
                                        </div>
                                    </div>
                                
                                
                                
                            </div>
                            <div v-else-if="postlist.length == 0">
                                No post to show.
                            </div>
                            <div v-else>
                                        Loading ...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        </div>
        <!-- <div v-else-if="!tokenStatus">
            Unauthorized
        </div> -->
        <div v-if="unauthorized == true">
            401 Unauthorized token
        </div>
        <!-- End pagination  -->
    </main>

</template>

<script>

    import axios from 'axios'
    import {mapGetters} from 'vuex'
    export default{ 
        name : "HomePage",
        data(){
            return {
                message : 'Hello world',
                searchkey: '',
                category: 0,
                loadingData : false,
                postlist : [],
                categorylist : [],
                tokenStatus : false,
                unauthorized : false,
            }
        },
         computed: {
            ...mapGetters(["gettokenData","getuserData"]),
        },
        methods: {
            
            headerAuth(){
                let tokenauth = this.gettokenData == null ? "Bearer empty" : "Bearer " + this.gettokenData.slice(1, -1);
                let output = { headers: {
                        Authorization: tokenauth
                    }};
                return output;
            },
            // unauthorizedMsg(error){
            //     if(error.response.status == 401){
            //         this.unauthorized = true;
            //     }
            // },
            getPost(){
                
                axios.get("http://127.0.0.1:8000/api/allpost", this.headerAuth())
                .then((response)=>{
                    console.log('Hello');
                    this.postChange(response);
                    console.log(this.postlist);
                })
                .catch((error)=>{
                    console.log(error);
                    if(error.response.status == 401){
                        this.unauthorized = true;
                    }
                })
            },
            getCategory(){
                axios.get("http://127.0.0.1:8000/api/allCategory", this.headerAuth()).then((response)=>{
                    this.categorylist = response.data.categories;
                    // for(let i = 0; i < response.data.categories.length; i++){
                    //     let element = response.data.categories[i];
                    //     console.log(element);
                    // }
                })
            },
            searchMethod(){
                // console.log(this.searchkey);
                this.loadingData= true;
                axios
                    .post("http://127.0.0.1:8000/api/postSearch",{
                            searchkey : this.searchkey
                        },this.headerAuth())
                    .then((response)=>{
                        console.log(this.searchkey);
                        console.log(response.data.posts);
                        this.postChange(response);
                        this.loadingData = false;
                    })
                    .catch((error)=>{
                        if(error.response.status == 401){
                            this.unauthorized = true;
                        }
                    })
            },
            postChange(response){
                console.log(response);
                for(let i = 0; i < response.data.posts.length; i++){
                        if(response.data.posts[i].image == null){
                            response.data.posts[i].image = 'http://127.0.0.1:8000/storage/post/default.png';
                        }else{
                            response.data.posts[i].image = 'http://127.0.0.1:8000/storage/post/'+response.data.posts[i].image;
                        }
                }
                this.postlist = response.data.posts;
            },
            categoryChoose(catID){
                this.category = catID;
                console.log(catID);

                this.loadingData = true;
                axios
                    .post("http://127.0.0.1:8000/api/categorySearch",{
                            category : this.category
                        }, this.headerAuth())
                    .then((response)=>{
                        console.log(response.data.posts);
                        this.postChange(response);
                        this.loadingData = false;
                    })
                    .catch((error)=>{
                        if(error.response.status == 401){
                            this.unauthorized = true;
                        }
                    })
            },
            postDetailMethod(postID){
                console.log(postID); 
                this.$router.push({
                    name: "postDetail",
                    params: {
                        id : postID
                    }
                })
            },
            checkToken(){
                console.log(this.gettokenData + '_token');
                if(this.gettokenData){
                    this.tokenStatus = true;
                }else{
                    this.tokenStatus = false;
                }
            },
            homePage(){
                console.log('Home');
                this.$router.push({
                    name : 'home'
                })
            },
            logout(){
                this.tokenStatus = false;
                axios
                .get('http://127.0.0.1:8000/api/logoutUser',this.headerAuth())
                .then((response)=>{
                    console.log(response.data);
                    this.$router.push({
                        name : 'loginPage'
                    })
                    this.$store.dispatch('loginToken',null);
                    localStorage.removeItem('tokenData');
                    localStorage.removeItem('userData');
                    console.log(this.gettokenData);
                    console.log('Logging out')
                })
            },
            postPage(){
                this.$router.push({
                    name : 'posts'
                })
            }
        },
        mounted(){
            this.$store.dispatch("loginUser",localStorage.getItem('userData'));
            this.$store.dispatch("loginToken",localStorage.getItem('tokenData'));

            axios
            .get('http://127.0.0.1:8000/api/tokenCheck', this.headerAuth())
            .then(()=>{
                this.checkToken();
                this.getPost();
                this.getCategory();
            })
            .catch((error)=>{
                console.log(error);
                if(error.response.status == 401){
                    this.$router.push({
                        name : 'loginPage'
                    });
                }
            })
        }
    }
    
</script>