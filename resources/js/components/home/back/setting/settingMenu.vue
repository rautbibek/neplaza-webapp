<template>
    <v-card
        class="mx-auto"
        tile>
        <v-list dense>
        <v-subheader>Setting Menu</v-subheader>
        <v-list-item-group v-model="item" color="primary">
            <v-list-item
                v-for="(item, i) in items"
                :key="i"
                router :to="item.url"
            >
            <v-tooltip left>
                <template v-slot:activator="{ on, attrs }">
                    <v-list-item-icon v-bind="attrs"
                    v-on="on">
                    <v-icon v-text="item.icon"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                    <v-list-item-title v-text="item.text"></v-list-item-title>
                    </v-list-item-content>
                    </template>
                    <span>{{item.text}}</span>
                </v-tooltip>
            </v-list-item>
        </v-list-item-group>
        </v-list>
    </v-card>
</template>
<script>
export default {
    data(){
        return{
            item: 1,
            items: [
                {
                    text: 'Contact Setting', 
                    icon: 'phone',
                    url : '/user/setting'
                },
                {
                    text: 'Change Password',
                    icon: 'vpn_key',
                    url : '/user/change/password'
                },

                {
                    text: 'Change Or Vefiry Email',
                    icon: 'email',
                    url : '/user/email/setting'
                },
                {
                    text: 'Account Setting',
                    icon: 'mdi-account-circle',
                    url : '/user/account/setting'
                }
            ],
        }
    },
    mounted(){
        if(!this.loggedIn){
                EventBus.$emit('changeDialog', true);
                this.$router.push("/");
                return;
            }
    }
}
</script>
