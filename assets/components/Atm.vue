<template>
    <div class="flex flex-col  w-full"> 
            <h3 class="text-sm text-gray-500 mb-5">Quick Withdraw </h3>
            <div class="grid grid-cols-2 gap-4">
                <button class="rounded shadow-2xl border-2 border-custom-gray px-3 py-2 text-2xl hover:border-green-500" @click="add_balance(10)" >
                    £10
                </button>

                <button class="rounded shadow-2xl border-2 border-custom-gray px-3 py-2 text-2xl hover:border-green-500" @click="add_balance(20)">
                    £20
                </button>

                <button class="rounded shadow-2xl border-2 border-custom-gray px-3 py-2 text-2xl hover:border-green-500" @click="add_balance(50)" >
                    £50
                </button>

                <button class="rounded shadow-2xl border-2 border-custom-gray px-3 py-2 text-2xl hover:border-green-500" @click="add_balance(100)" >
                    £100
                </button>
            </div>

            <div class="flex space-x-4 justify-between mt-10 items-center">

               <div>
                <button class="text-xs text-white bg-green-500 px-3 py-2 rounded" @click="add_balance(10)">Add (+10)</button>
               </div>
               

                <div class="flex flex-col space-y-1">
                    <h1 class="text-3xl text-center font-bold text-green-500"> £{{ amount }} </h1>
                </div>
                
               
                <div>
                    <button class="text-xs text-white bg-red-500 px-3 py-2 rounded" @click="remove_balance(10)">Remove (-10)</button>
                </div>
                
                
            </div>
            <small class="italic text-red-500  xs">Note: You can only add/remove in multiples of £10</small>

            <button class="rounded px-2 py-1 text-white bg-blue-600 mt-10 mb-10" @click="withdraw()"> <i class="fa-solid fa-money-bills"></i>  Cash Withdraw</button>
            <small class="italic text-green-500  text-center text-2xl">{{  transaction_message }}</small>
            <small class="italic text-red-500  xs">{{  error_message }}</small>
     </div>
</template>

<script>

export default {
    name: 'Atm',
    props:['id','balance'],

    data() {
        return {
            amount: 0,
          info: null,
          error_message: '',

          transaction_message: ''
            
        };
    },

    mounted() {
      //   console.log("Atm view mounted state called")
      //
      //
      // this.$http
      //     .get('http://localhost:8000/api/v1/user')
      //     .then(response => (this.info = response))
    },

    methods: {
    withdraw(){

         this.$http
            .post('http://localhost:8000/api/v1/user_withdraw',{id:this.id, amount: this.amount})
            .then(response => {
              if(response.data.status){
                this.transaction_message = "Transaction successful"
                location.reload();
              }
            }).catch(error => {
           this.transaction_message = "Transaction Failed"
         })


},
      add_balance(amount){

        this.amount = this.amount + amount

        if(this.amount>this.balance){
          this.error_message = 'You cant withdraw funds above your current balance'
          this.amount = this.balance

        }else{
          this.error_message = ''
        }
      },
      remove_balance(amount){
        if(this.amount >= amount){
          this.error_message = ''
          this.amount = this.amount - amount
        }

      }
    },
};
</script>

<style scoped>

</style>