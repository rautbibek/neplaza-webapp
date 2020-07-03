<template>
    
    <v-container
        class="fill-height"
        fluid
      >
        <v-row
          align="center"
          justify="center"
        >
          <v-tooltip right>
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                large
                target="_blank"
                v-on="on"
              >
                WELCOME TO DASHBOARD
              </v-btn>
            </template>
            <span>Source</span>
          </v-tooltip>
        </v-row>
      </v-container>
</template>