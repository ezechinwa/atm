<template>
    <div class="mx-auto flex flex-col  p-10 w-full mt-10 mb-10 bg-custom_gray rounded shadow-2xl">
        <div class="header flex items-center justify-between">
          <div class="flex">
                        <img class="w-40" src="../public/images/pureretirement.png" alt="">
            <!-- <p> PureRetirement Bank</p> -->
          </div>

          <h2 class="text-sm font-bold">{{ date }}</h2>
        </div>
              <router-view></router-view>


<!--        <div class="flex flex-col border-2 border-custom-gray shadow-2xl p-10 rounded-2xl"> -->

<!--                <div class="header flex items-center justify-between"> -->
<!--                       <div class="flex"> -->
<!--                        <img class="w-40" src="../public/images/pureretirement.png" alt="">-->
<!--                         &lt;!&ndash; <p> PureRetirement Bank</p> &ndash;&gt;-->
<!--                       </div>-->

<!--                       <h2 class="text-sm font-bold">{{ date }}</h2> -->
<!--                </div>-->

<!--                <div class="main_content grid grid-cols-2 space-x-10 mt-10 "> -->
<!--                        <div class="bg-white rounded-2xl shadow flex flex-col p-10 space-y-4">-->
<!--                            <profile user_name="Williams Chinwa Jnr" /> -->
<!--                            <balance />-->
<!--                        </div>-->

<!--                        <div class="bg-white rounded-2xl shadow flex p-10">-->
<!--                          <atm />-->
<!--                        </div>-->

<!--                </div>-->
<!--        </div>-->

       </div> 
</template>

<script> 
 export default {
  created(){
    window.setInterval(() => {
      this.date = new Date().toLocaleString()
    }, 1000); // interval set to one sec. 
    
  },
    data() {
    return {
      date: new Date().toLocaleString()
        // name: "Hello Williams"
    }
}
  
}

</script>


<style scoped> 
   


</style>