<template>
     <main>
          <!-- Main-menu -->
    <div>
        <div class="main-menu d-none d-md-block">
            <nav>
                <ul id="navigation" class="d-flex ms-5">
                    <li><a @click="homePage()" class="mx-2">Home</a></li> | 
                    <li><a @click="postPage()" class="mx-2" v-if="tokenStatus">Posts</a></li> | 
                    <li>
                        <a @click="loginout()" class="mx-2" v-if="tokenStatus">Logout</a>
                        <a @click="loginout()" class="mx-2" v-else>Login</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <!-- Mobile Menu -->
     </main>
</template>

<script scoped>
import axios from 'axios';
import { mapGetters } from 'vuex';
// import { defineComponent } from '@vue/composition-api'

export default{
    name: 'messagePage',
    data(){
        return {
            alluser: [],
            currentcon : [],
            loadinguser : false,
            loadingcon : false,
           
        }    
    },
    methods:{
        loadCurrChat(){
            console.log('hello world');
        },
        loadNoti(){
            console.log('hello world');
        },
        loadUser(){
            console.log('hello world');
        }
    },
    computed:{
        ...mapGetters(['getuserData','gettokenData']);
    },
    mounted(){
        
        this.$store.dispatch("loginUser",localStorage.getItem('userData'));
        this.$store.dispatch("loginToken",localStorage.getItem('tokenData'));
        this.loadCurrChat();
        this.loadUser();
        this.loadNoti();
    }
}
</script>
