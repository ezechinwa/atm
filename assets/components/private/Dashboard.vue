<template>


  <div class="main_content grid grid-cols-2 space-x-10 mt-10 ">
    <div class="bg-white rounded-2xl shadow flex flex-col p-10 space-y-4">
      <profile :user="user" />
      <balance :user="user" :transaction="user_transactions"/>
    </div>

    <div class="bg-white rounded-2xl shadow flex p-10" v-if="user !== null">
      <atm :balance="user.balance" :id="user_id"/>
    </div>

  </div>
</template>

<script>
export default {
  name: "Dashboard.vue",
  created(){

    // console.log("id",this.$route.params)
    this.user_id = this.$route.params.id

    if(this.user_id == null){
      this.$router.push(`/app/login`)
    }

    this.$http
        .get(  `${this.API_BASEURL}/api/v1/get_userinfo_by_id?id=${this.user_id}`)
        .then(response => {
          if (response.data.status){
            this.user = response.data.user
            this.user_transactions = response.data.transactions
          }

        }).
        catch(error => {

    })

    // http://localhost:8000/api/v1/get_userinfo_by_id?id=1



  },
  data(){
    return{
      user_id: null,
      date: new Date().toLocaleString(),
      user: null,
      user_transactions: []
  }

  }
}
</script>

<style scoped>

</style>