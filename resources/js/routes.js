import HomeComponent from './components/home/homepage.vue';
import CategoryComponent from './components/home/front/pages/category.vue';
import SubCategoryComponent from './components/home/front/pages/subcategory.vue';
import ProductComponent from './components/home/front/pages/product.vue';
import CreateAdsComponent from './components/home/back/createAds.vue';
import MyAdsComponent from './components/home/back/myads.vue';
import FavAdsComponent from './components/home/back/myFav.vue';
import SettingComponent from './components/home/back/setting.vue';
import ProfileComponent from './components/home/back/profile.vue';
import CreateController from './components/home/back/createController.vue';

export const routes = [{
        path: '/',
        component: HomeComponent
    },

    {
        path: '/category/:slug',
        component: CategoryComponent
    },

    {
        path: '/category/:id/:slug',
        component: SubCategoryComponent
    },

    {
        path: '/ads',
        component: ProductComponent
    },

    {
        path: '/user/create/ads',
        component: CreateAdsComponent
    },

    {
        path: '/user/myads',
        component: MyAdsComponent
    },

    {
        path: '/user/favorite',
        component: FavAdsComponent
    },

    {
        path: '/user/setting',
        component: SettingComponent
    },

    {
        path: '/user/profile',
        component: ProfileComponent
    },

    {
        path: '/create/ads/:slug',
        component: CreateController,
    }

]