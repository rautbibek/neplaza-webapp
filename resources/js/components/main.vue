<template>
    <v-app>
        <v-main>
            <system-bar></system-bar>
            <top-bar></top-bar>
            <nav-bar></nav-bar>
            <div style="min-height:400px">
                <router-view></router-view>
            </div>
            <login></login>
            <sign-up></sign-up>
            <email-verify-notif v-if="loggedIn"></email-verify-notif>
            <update-profile></update-profile>
            <scroll></scroll>
            <footer-bar></footer-bar>

        </v-main>
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
