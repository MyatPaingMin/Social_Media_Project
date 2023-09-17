<template>

    <div class="d-flex flex-column align-items-center justify-content-center" style="height: 500px; width: 100%;">
        <div class="alert" v-if="!userStatus">
            Credentials does not match
        </div>
        <form>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email</label>
              <input type="email" v-model="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="text" v-model="password" class="form-control" id="exampleInputPassword1">
            </div>
            
            <button type="button" class="btn btn-primary" @click="loginUser()">Login</button>
        </form>
        
        <p @click="registerPage()">
            New user. Register
        </p>

    <!-- <form style="width: 100%; height: 100%;" enctype="multipart/form-data">

      <div class="mb-3 form-control-sm " style="width: 100%">
        <label for="formtitle" class="form-label">Email</label>
        <input type="text" v-model="email" class="form-control" style="width:100%; " id="formtitle">
      </div>

      <div class="mb-3 form-control-sm " style="width: 100%">
        <label for="formtitle" class="form-label">Password</label>
        <input type="text" v-model="password" class="form-control" style="width:100%; " id="formtitle">
      </div>

      <div class="mb-3 form-control-sm " style="width: 100%">
        <input type="button" class="form-control btn-primary" @click="loginUser()" value="Login" style="width:100%; " id="formtitle">
      </div>
    </form> -->
    </div>

</template>


<script scoped>

    import axios from 'axios'
    import {mapGetters} from 'vuex'

    export default{
        name: 'LoginPage',
        data(){
            return {
                userStatus : true,
                email: '',
                password: '',
                token : 'T-O-K-E-N'
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

            loginUser(){
                this.userStatus = true;

                axios
                    .post('http://127.0.0.1:8000/api/user/check',{
                        email : this.email,
                        password : this.password
                    })
                    .then((response) => {
                        console.log(response);

                        if(response.data.token != null){
                            this.$store.dispatch("loginUser",response.data.userData);
                            this.$store.dispatch("loginToken",response.data.token);

                            localStorage.setItem('userData',JSON.stringify(response.data.userData));
                            localStorage.setItem('tokenData',JSON.stringify(response.data.token));
                            // console.log(response.data.userData);  
                            console.log("saved");
                            this.check();
                        }else{
                            console.log("User does not exist.");
                            this.userStatus = false;
                        }
                        this.token =  response.data.token;
                    })
                    .catch((error)=>{
                        console.log(error);
                    });
            },
            check(){
                console.log(this.gettokenData);
                console.log(this.getuserData);
                this.$router.push({
                    name : 'home'
                })
                // console.log(this.token);
            },
            userToken(){
                console.log(this.gettokenData);
            },
            registerPage(){
                this.$router.push({
                    name : 'registerPage'
                })
            }
        },
         computed: {
            ...mapGetters(["gettokenData","getuserData"]),
        },
        mounted(){
            this.$store.dispatch("loginUser",localStorage.getItem('userData'));
            this.$store.dispatch("loginToken",localStorage.getItem('tokenData'));

            axios
            .get('http://127.0.0.1:8000/api/tokenCheck',this.headerAuth())
            .then(()=>{
                this.$router.push({
                    name: 'home'
                })
            })
            .catch(()=>{
                console.log('Login Page');
            })
        }
    }

</script>