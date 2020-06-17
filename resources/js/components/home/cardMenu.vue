<template>
    <div>
        <v-menu bottom left>
            <template v-slot:activator="{ on: menu, attrs }">
                <v-tooltip bottom>
                <template v-slot:activator="{ on: tooltip }">
                    <v-btn 
                    class="mt-3 ml-3"
                    absolute
                    x-small
                    dark
                    fab
                    v-bind="attrs"
                    v-on="{ ...tooltip, ...menu }"
                    right

                    >
                    <v-icon >edit</v-icon>
                </v-btn>
                </template>
                <span>Settings</span>
                </v-tooltip>
            </template>
            <v-list dense>
                <v-subheader>SETTING</v-subheader>
                <v-list-item-group  color="primary">
                    <v-list-item route :to="`/edit/${ads.id}/ad`">
                        <v-list-item-icon>
                            <v-icon small>edit</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Edit Detail</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-item route :to="`/edit/ad/${ads.id}/image`">
                        <v-list-item-icon>
                            <v-icon small>image</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Edit Image</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="softDelete(ads.id)">
                        <v-list-item-icon>
                            <v-icon small>delete</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>Delete Ad</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item @click="soldOut(ads.id)">
                        <v-list-item-icon>
                                <v-icon small>money</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Sold Out</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                </v-list-item-group>
                </v-list>
        </v-menu>      
    </div>
</template>
<script>
//import action from "../../mixins/actions";
export default {
    props:['ads'],
    methods:{
        softDelete(id){
            axios.put(`/trash/ad/${id}`)
                .then(response =>{
                    this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                })
                .catch();
        },
        soldOut(id) {
            axios.put(`/sold/ad/${id}`)
                .then(response =>{
                    this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        EventBus.$emit('loadAd', true);
                })
                .catch();
        },
    }
}
</script>