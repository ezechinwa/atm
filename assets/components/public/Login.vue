<template>
      <div class="flex flex-col border-2 border-custom-gray shadow-2xl p-10 rounded-2xl">
<!--        <div class="header flex items-center justify-between">-->
<!--            <div class="flex">-->
<!--                          <img class="w-40" src="../../../public/images/pureretirement.png" alt="">-->
<!--            </div>-->
<!--          <h2 class="text-sm font-bold">{{ date }}</h2>-->
<!--        </div>-->

        <div class="main_content grid grid-cols-1 space-x-10 mt-10 mx-auto">

          <div class="w-full max-w-xs">

            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">

              <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                  Email
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" placeholder="Email Address" v-model="this.email">
              </div>
              <div class="flex items-center justify-between"  v-if="!show_loading">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="button" @click="login">
                  Sign In
                </button>
                <router-link class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" to="/app/register">Register</router-link>
<!--                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="#">-->
<!--                  Register-->
<!--                </a>-->
              </div>
              <p class="text-green-500 text-lg italic text-center mt-10 mb-10" v-else>{{ message }}</p>
              <p class="text-red-500 text-xs italic text-center mt-10 mb-10" v-if="show_error">{{ error_message}}</p>
            </form>
            <p class="text-center text-gray-500 text-xs">
              &copy;2023. All rights reserved.
            </p>
          </div>

        </div>

        </div>

</template>

<script>
export default {
    name: 'Login',
  created(){
    window.setInterval(() => {
      this.date = new Date().toLocaleString()
    }, 1000); // interval set to one sec.

  },

    data() {
        return {
          date: new Date().toLocaleString(),
          email: null,
          show_error: false,
          show_loading: false,
          message: 'Loading... Please wait',
          error_message: ''
        };
    },

    mounted() {
     console.log("API_BASEURL",this.API_BASEURL)
    },

    methods: {
        login(){
          console.log("login clicked")
          if(this.email !== null){
            this.show_loading = true
            this.$http
                .post(  `${this.API_BASEURL}/api/v1/user_login`, {email : this.email})
                .then(response => {
                  this.show_loading = false
                  this.show_error = false

                    if(response.data.status){
                     // console.log("status true", response.data.user)
                      this.$router.push(`/app/dashboard/${response.data.user.user_id}`)
                    }
                    else{
                      // console.log("status false", response.data)
                      this.show_error = true
                      this.error_message = "Email address not found"
                    }
                })
                .catch(error => {
                  this.show_error = true
                  this.error_message = "An error occurred, please try again later"
                })
          }

        }
    },
};
</script>

<style lang="scss" scoped>

</style>