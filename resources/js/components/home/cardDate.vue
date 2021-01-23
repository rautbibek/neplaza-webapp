<template>
    <div>
        <v-row no-gutters>
            <v-col cols="6" >
                <v-chip style=""
                draggable
                small
                color="#f2f2f2"
                text-color="dark"
                >
                <v-avatar left>
                    <v-icon small>mdi-alarm-check</v-icon>
                </v-avatar>
                {{ads.created_date}}
                </v-chip>
            </v-col>
            <v-col cols="6" >
                <v-chip
                small
                color="#f2f2f2"
                text-color="dark"
                >
                <v-avatar left >
                    <v-icon small>mdi-account-circle</v-icon>
                </v-avatar>

                    <span
                    class="d-inline-block text-truncate"
                    style="max-width: 70px;"
                    >
                    {{ads.product_property.user_name}}
                    </span>
                </v-chip>
            </v-col>
        </v-row>
    </div>
</template>
<script>
export default {
    props:['ads'],
    data(){
        return{
            //
        }
    }
}
</script>
