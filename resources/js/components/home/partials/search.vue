<template>
                <div class="form-row">
                      <div class="col-10">
                        <input type="text" class="form-control" placeholder="Type your search keyword">
                      </div>
                      <div class="col-2">
                        <button class="btn" style="background-color:#2F3B59; color:white; margin-left:-10px">
                          <v-icon style="color:white">search</v-icon>
                        </button>
                      </div>
                </div>
</template>

<style scoped>
  .form-control{
    height: 40px;
    border-radius:0px;
    margin:0px;
    padding:0px;
    border:2px solid #2F3B59;    
  }
  .form-control:focus{
      box-shadow:none;
  }
  .btn{
    height: 40px;
    border-radius:0px;
    border-radius:2px solid #2F3B59;
  }
   .btn:focus{
      box-shadow:none;
  }



</style>