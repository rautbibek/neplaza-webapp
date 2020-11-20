<template>
  <!-- navabr of the template -->
  <nav>
    <!-- system bar -->
    <v-system-bar height="35">
      <div class="d-sm-none">
        <router-link to="/">
           <span  style="background:#2F3B59; border:1px solid #2F3B59; border-radius:57%;" class="p-1 text-white">N</span>ep<span style="color:red">la</span>za
        </router-link>
      </div>
      <div class="d-none d-sm-flex">
      Welcome to Neplaza &nbsp;| &nbsp;
      <img src="/image/flag.png"  height="12" class="mt-1" alt="nepal">
        &nbsp; Nepal
      </div>
      <v-spacer></v-spacer>
      <v-btn text >
        <v-icon left>phone</v-icon>
        <span>+977-9863756278</span>
      </v-btn>

    </v-system-bar>
  </nav>
</template>
