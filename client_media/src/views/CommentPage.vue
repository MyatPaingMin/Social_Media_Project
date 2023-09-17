<template>
    <div>
        <h1 class="text-danger">Comment page is no longer used.</h1>
        <h3 class="d-flex ms-5">
            <span class="mx-5" @click="postPage()"><i class="fa-solid fa-arrow-left text-primary"></i></span> Comments
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
                            <p class="ms-1">{{comment.text}}</p>
                            <div class="ms-3">
                                <button  class="btn-secondary" style="width:50px;height:20px;font-size: 10px;" @click="replyComment(comment.id)">Reply</button>
                                <button v-if="comment.commenter_id == this.userID" class="btn-danger" style="width:50px;height:20px;font-size: 10px;" @click="deleteComment(comment.id)">Delete</button>
                                <button v-if="comment.commenter_id == this.userID" class="btn-primary" style="width:50px;height:20px;font-size: 10px;">Edit</button>
                            </div>
                        </div>
                    </div>

                     <div class="px-3 py-1 rounded-4" style="margin: 10px; margin-start:100px; background-color: rgb(220, 220, 220);" v-else>
                        <div class="d-flex">
                            <img :src="comment.commenter_profile" alt="" style="width:30px; height:30px;" class="rounded-circle bg-secondary me-3">
                            <p>{{comment.commenter}}</p>
                        </div>
                        <div class="d-flex">
                            <p >{{comment.text}}</p>
                            <div class="ms-3" v-if="comment.commenter_id == this.userID">
                                <button  class="btn-danger" style="width:50px;height:20px;font-size: 10px;" @click="deleteComment(comment.id)">Delete</button>
                                <button  class="btn-primary" style="width:50px;height:20px;font-size: 10px;">Edit</button>
                            </div>
                        </div>
                    </div>

                </div>

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
</template>

<script scoped>

    import axios from 'axios'
    import {mapGetters} from 'vuex'

    export default{
        name : 'commentPage',
        data() {
            return {
                id: this.$route.params.id,
                commentloading : false,
                commentposting : false,
                comments : [],
                userID : '',
                usercomment: '',
                parent: '',
            }
        },
        methods:{
            commented(){
                this.commentposting = true;
                axios
                    .post('http://127.0.0.1:8000/api/createComment',{
                        postID : this.id,
                        userID : this.getuserData.id,
                        text : this.usercomment,
                        parent : this.parent
                    })
                    .then((response)=>{
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
            loadComment(){
                this.commentloading =  true;
                axios
                    .get('http://127.0.0.1:8000/api/comment/'+ this.id)
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
            postPage(){
                this.$router.push({
                    name : 'posts'
                })
            },
            deleteComment(id){
                axios
                    .delete('http://127.0.0.1:8000/api/deleteComment/' + id)
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
            }
        },
        computed:{
            ...mapGetters(['getuserData','gettokenData'])
        },
        mounted(){
            this.userID = this.getuserData.id;
            this.loadComment();
        }
    }
</script>
