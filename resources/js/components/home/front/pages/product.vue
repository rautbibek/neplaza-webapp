<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right">
                    <router-link :to="`/`">Home</router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    All Ads
                </li>
            </ol>
        </nav>
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <!-- extra menu -->
        <div class="d-sm-none">
            <div class="cover-image">
                <h3 class="text-center">All Ads</h3>
            </div>
            <v-container class="cover-container create-ad">
                <v-expansion-panels>
                    <v-expansion-panel
                        v-for="(category, index) in categories"
                        :key="index"
                    >
                        <v-expansion-panel-header>
                            <v-icon
                                style="display:block;"
                                :to="`/category/${category.slug}`"
                                left
                                medium
                                >{{ category.icons }}</v-icon
                            >{{ category.name }}
                        </v-expansion-panel-header>
                        <v-expansion-panel-content class="panel-content">
                            <ul class="list-group">
                                <router-link
                                    :to="`/category/${category.id}/${cat.slug}`"
                                    class="list-group-item list-group-item-action"
                                    v-for="(cat, index) in category.scategory"
                                    :key="index"
                                >
                                    {{ cat.name }}
                                </router-link>
                            </ul>
                        </v-expansion-panel-content>
                    </v-expansion-panel>
                </v-expansion-panels>
            </v-container>
        </div>
        <!-- end of extra menu -->
        <div class="">
            <v-container>
                <v-layout row wrap class="px-1">
                    <v-flex
                        xs6
                        sm6
                        md4
                        lg3
                        xl2
                        v-for="(ads, index) in all_ads"
                        :key="index"
                    >
                        <card-lazy :ads="ads"></card-lazy>
                    </v-flex>
                </v-layout>
                <div class="text-center ma-5" v-if="nextUrl">
                    <v-btn
                        :loading="loading"
                        outlined
                        tile
                        color="#2F3B59"
                        class=""
                        @click.prevent="more(nextUrl)"
                    >
                        Load More
                        <template v-slot:loader>
                            <span>Loading...</span>
                        </template>
                        <v-icon right>cached</v-icon>
                    </v-btn>
                </div>
            </v-container>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            isActive: false,
            loading: false,
            overlay: false,
            all_ads: [],
            categories: {},
            color: "white",
            background: "#270f0ea1",
            nextUrl: null
        };
    },
    methods: {
        favorite() {
            if (this.$loggedIn) {
                this.color = "red";
                this.background = "white";
            } else {
                EventBus.$emit("changeDialog", true);
            }
        },

        fetch(url) {
            this.overlay = true;
            this.loading = true;
            axios.get(url).then(({ data }) => {
                this.all_ads.push(...data.data);
                this.nextUrl = data.next_page_url;
                this.loading = false;
                this.overlay = false;
            });
        },
        more(nextUrl) {
            this.loading = true;
            axios.get(nextUrl).then(({ data }) => {
                this.all_ads.push(...data.data);
                this.nextUrl = data.next_page_url;
                this.loading = false;
            });
        }
    },

    created() {
        this.fetch(`front/all/product`);
        axios.get(this.subcategory_url).then(response => {
            this.categories = response.data;
        });
    },
    computed: {
        subcategory_url() {
            return `/menu/subCategory`;
        }
    }
};
</script>
<style scoped>
.v-expansion-panel-header > *:not(.v-expansion-panel-header__icon) {
    flex: none;
}
</style>
