<template>
     <div class="flex flex-col space-y-4"> 
           <h3 class="text-sm text-gray-500" v-if="user !== null">Welcome {{ user.name }} ,</h3>
           <h3 class="text-sm text-gray-500">What would you like to do today? </h3>
<!--           <img src="https://xsgames.co/randomusers/avatar.php?g=male" alt="" class="rounded-2xl shadow w-10 my-5">-->
           <!-- <i class="fa-solid fa-user text-2xl rounded-2xl"></i> -->
<!--           <h3 class="text-2xl font-bold">{{ user.name }}</h3>-->
     </div>
</template>

<script>
export default {
    name: 'Profile',
    props:['user'],

    data() {
        return {
            
        };
    },

    mounted() {
        
    },

    methods: {
        
    },
};
</script>

<style scoped>

</style>