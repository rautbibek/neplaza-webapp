<template>
  <!-- navabr of the template -->
  <nav>
    <!-- system bar -->
    <v-system-bar height="45" class="system-bar">
      <v-divider vertical></v-divider>
      <div class="d-none d-sm-flex system-title">Welcome to Bikri Bazzar</div>
      <v-divider vertical></v-divider>
      <v-spacer></v-spacer>
      <v-divider vertical></v-divider>
      <v-btn text>Login</v-btn>
      <v-divider vertical></v-divider>
      <v-btn text>Register</v-btn>
      <v-divider vertical></v-divider>
    </v-system-bar>
  </nav>
</template>
<style scoped>
.system-bar {
  background-color: #fff;
  border-bottom: 1px solid #dfdfdf;
}
.system-bar > hr {
  margin-top: 0px;
}
.system-bar > hr:first-child {
  margin-left: 15px;
}
.system-bar > button {
  text-transform: capitalize;
}
.system-bar > button:hover {
  background: #fff;
  color: #19916b;
}
.system-title {
  color: #000;
  letter-spacing: 0.03px;
  margin-right: 16px;
  margin-left: 15px;
}
</style>