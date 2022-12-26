<template>
  <div id="vue-backend-app">
    <h1>Backend App</h1>

    <router-view />
  </div>
</template>

<script>
export default {
  name: 'App',
  created() {
    // jQuery.ajax({
    //   url: wpstarter.ajaxurl,
    //   type: "POST",
    //   data: {
    //       action: 'my_action',
    //       name: "Shahadat",
    //   },
    //   success: function(response)
    //   {                    
    //       console.log(response);
    //   }
    // });
  }
}
</script>

<style>

</style>
