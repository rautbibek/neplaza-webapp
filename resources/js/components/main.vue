<template>
    <v-app>
        <v-content>
            <system-bar></system-bar>
            <top-bar></top-bar>
            <nav-bar></nav-bar>
            <div style="min-height:400px">
                <router-view></router-view>
            </div>
            <login></login>
            <update-profile></update-profile>
            <scroll></scroll>
            <footer-bar></footer-bar>
            
        </v-content>
    </v-app>
</template>
<script>
export default {
    data(){
        return{
            //
        }
    }
}
</script>  