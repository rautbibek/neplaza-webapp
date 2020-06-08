<template>
    <div>
        <v-col cols="12" sm="12" md="8" xs="12" class="p-4">
                                    <v-text-field style="border-radius:0px; margin-bottom:20px"
                                        type="number"
                                        v-model="testing"
                                        label="testing *"
                                        placeholder="Testing"
                                        
                                        outlined
                                        clearable
                                    ></v-text-field>
                                </v-col>
    </div>
</template>
<script>
export default {
    data(){
        return{
            testing:''
        }
    }
}
</script>