<template>
     <div class="flex flex-col space-y-4"> 
            <h3 class="text-sm text-gray-500">Your remaining balance </h3>
            <div class="flex items-center space-x-5" v-if="user !== null">
                <h3 class="text-2xl text-gray-500" v-if="showbalance">***** GBP </h3>
                <h3 class="text-2xl text-gray-500" v-else>{{ user.balance}} GBP </h3>
                <button class="text-blue-500 text-xs " @click="toggle_databalance">Show</button>
            </div>
            <div class="flex flex-col mt-10 justify-between "  >
                <button class="rounded px-2 py-1 text-white bg-green-600" @click="showtransaction_history=!showtransaction_history"> <i class="fa-solid fa-clock-rotate-left"></i> Click to Show/Hide Transaction History</button>
                <div class="flex flex-col p-5" v-if="showtransaction_history">


                  <table class="w-full text-xs text-left text-gray-500 dark:text-gray-400 p-5">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                      <th scope="col" class="px-6 py-3">
                       Timestamp
                      </th>
                      <th scope="col" class="px-6 py-3">
                        Transaction Amount
                      </th>
                      <th scope="col" class="px-6 py-3">
                        Note Dispensed
                      </th>
                      <th scope="col" class="px-6 py-3">
                        Denomination
                      </th>
<!--                      <th scope="col" class="px-6 py-3">-->
<!--                        Denomination Value-->
<!--                      </th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" v-for="( trans , index) in transaction">
                      <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ convert_timestamp_to_human_readable(trans.date_time) }}


                      </th>
                      <td class="px-6 py-4">
                        {{ trans.transaction_amount }}
                      </td>
                      <td class="px-6 py-4">
                        {{ trans.transaction_note_dispensed }}
                      </td>
                      <td class="px-6 py-4">
                        {{ trans.denomination }}
                      </td>

                    </tr>
                    </tbody>
                  </table>

                </div>

            </div>
     </div>
</template>

<script>
export default {
    name: 'Balance',
    props:['user','transaction'],
    data() {
        return {
            showbalance: false,
            showtransaction_history: false

           
            
        };
    },

    mounted() {
        
    },

    methods: {
      convert_timestamp_to_human_readable(unix_timestamp){
        var date = new Date(unix_timestamp * 1000);
        var hours = date.getHours();
        var minutes = "0" + date.getMinutes();
        var seconds = "0" + date.getSeconds();
        var formattedDaTeTime =`${date.toISOString().slice(0, 10)} ${hours}:${minutes.substr(-2)}:${seconds.substr(-2)}`
        return formattedDaTeTime
      },
        toggle_databalance(){
            this.showbalance = !this.showbalance
        }
        
    },
};
</script>

<style scoped>

</style>