<template>
  <v-card min-height="400px">
    <nav aria-label="breadcrumb ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item pull-right">
          <router-link :to="`/`">Home</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
          404 page not found
        </li>
      </ol>
    </nav>
    <v-container>
      <div class="container">
        <v-card dense tile flat max-width="344" class="mx-auto">
          <v-img src="/image/404.svg"></v-img>
          <p class="text-center mt-5 mb-5" style="font-size: 16px">
            Sorry, the page you visited does not exist.
          </p>

          <div class="text-center">
            <v-btn router to="/" dark tile color="#2f3b59">
              Back to home
            </v-btn>
          </div>
        </v-card>
      </div>
    </v-container>
  </v-card>
</template>