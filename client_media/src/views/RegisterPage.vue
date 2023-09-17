<template>
     <div class="d-flex flex-column align-items-center justify-content-center" style="height: 1000px; width: 100%;">
        <h3>Register Page</h3>
        <div class="alert" v-if="!userStatus">
            Credentials does not match
        </div>
        <form>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Name</label>
              <input type="name" v-model="name" class="form-control" @focus="removeError()" id="exampleInputEmail1" aria-describedby="emailHelp">
              <small class="text-danger">{{errorelements['name']}}</small>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email</label>
              <input type="email" v-model="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <small class="text-danger">{{errorelements['email']}}</small>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">DOB</label>
              <input type="date" v-model="dob" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <small class="text-danger">{{errorelements['dob']}}</small>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Gender</label>
              <input type="text" v-model="gender" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <small class="text-danger">{{errorelements['gender']}}</small>
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Password</label>
              <input type="text" v-model="password" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <small class="text-danger">{{errorelements['password']}}</small>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
              <input type="text" v-model="confirmpass" class="form-control" id="exampleInputPassword1">
              <small class="text-danger">{{errorelements['confirmpass']}}</small>
            </div>
            
            <button type="button" class="btn btn-primary" @click="registerUser()">Register</button>
        </form>
        
        <p @click="loginPage()">
            Old user. Login
        </p>
    </div>
</template>

<script>
import axios from "axios";

    export default{
        name: 'registerPage',
        data(){
            return{
                name : '',
                email : '',
                dob : '',
                gender : '',
                password : '',
                confirmpass : '',

                errorelements : {
                    name : '',
                    email : '',
                    dob : '',
                    gender : '',
                    password : '',
                    confirmpass : '',
                },
            }
        },
        methods:{
            helloFunction(){
                console.log('hello');
            },  
            headerAuth(){
                let tokenauth = this.gettokenData == null ? "Bearer empty" : "Bearer " + this.gettokenData.slice(1, -1);
                let output = { headers: {
                        Authorization: tokenauth
                    }};
                return output;
            },
            removeError(){
                for (let key in this.errorelements){
                    this.errorelements[key] = '';
                }
            },
            loginPage(){
                this.$router.push({
                    name: 'loginPage'
                });
            },
            registerUser(){
                console.log('user is registering');

                axios
                .post('http://127.0.0.1:8000/api/user/create',{
                    name: this.name,
                    email: this.email,
                    dob: this.dob,
                    gender: this.gender,
                    password: this.password,
                    confirmpass: this.confirmpass,
                })
                .then((response)=>{
                    console.log(response.data);
                    if(response.data.status == 'success'){
                        this.$store.dispatch("loginUser",response.data.user);
                        this.$store.dispatch("loginToken",response.data.token);

                        localStorage.setItem('userData',JSON.stringify(response.data.user));
                        localStorage.setItem('tokenData',JSON.stringify(response.data.token));

                        this.$router.push({
                            name: 'home'
                        })
                    }
                })
                .catch((error)=>{
                    console.log(error.response);
                    if(error.response.status == 422){
                        console.log(error.response.data.errors);
                        let elements = error.response.data.errors;
                       for(let key in elements){
                            this.errorelements[key] = elements[key][0];
                            console.log(elements[key][0]);
                       }
                       console.log(this.errorelements);
                    }
                })
            },

        },
        mounted(){
            this.helloFunction();

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
                console.log('Register Page');
            })
            
        }
    }
</script>

<style lang="stylus" scoped>

</style>