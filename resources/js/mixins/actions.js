import Axios from "axios"

export default {
    data() {
        return {
            //
        }
    },
    methods: {
        softDelete(id) {
            axios.put(`/trash/ad/${id}`)
                .then()
                .catch();
        },
        permanentDelete() {
            axios.put(`/trash/ad/${id}`)
                .then()
                .catch();
        },

        soldOut(id) {
            axios.put(`/sold/ad/${id}`)
                .then()
                .catch();
        },
    }
}