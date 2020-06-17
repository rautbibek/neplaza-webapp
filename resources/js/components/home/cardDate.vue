<template>
    <div>
        <v-row>
            <v-col class="text-left">
                <v-chip style="border-radius:none"
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
            <v-col>
                <v-chip
                small
                color="#f2f2f2"
                text-color="dark"
                >
                <v-avatar left >
                    <v-icon small>mdi-account-circle</v-icon>
                </v-avatar>
                {{ads.user.name}}
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