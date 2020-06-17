import HomeComponent from './components/home/homepage.vue';
import CategoryComponent from './components/home/front/pages/category.vue';
import SubCategoryComponent from './components/home/front/pages/subcategory.vue';
import ProductComponent from './components/home/front/pages/product.vue';
import CreateAdsComponent from './components/home/back/createAds.vue';
//myads related posts
import MyAdsComponent from './components/home/back/myads.vue';
import MyFeatureAdsComponent from './components/home/back/myAds/featured.vue';
import MyDeletedAdsComponent from './components/home/back/myAds/deleted.vue';
import MySoldAdsComponent from './components/home/back/myAds/soldout.vue';
import MyUrgentAdsComponent from './components/home/back/myAds/urgent.vue';
import FavAdsComponent from './components/home/back/myFav.vue';
//end of myads


import SettingComponent from './components/home/back/setting.vue';
import ProfileComponent from './components/home/back/profile.vue';
import CreateController from './components/home/back/createController.vue';
import EditController from './components/home/back/editController.vue';
import EditImage from './components/home/back/form/edit/editImages.vue';

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

    //myads related post

    {
        path: '/user/myads',
        name: 'myads',
        component: MyAdsComponent
    },

    {
        path: '/myads/feature',
        name: 'myFeature',
        component: MyFeatureAdsComponent
    },

    {
        path: '/myads/deleted',
        name: 'myDeleted',
        component: MyDeletedAdsComponent
    },

    {
        path: '/myads/soldout',
        name: 'mySoldout',
        component: MySoldAdsComponent
    },

    {
        path: '/myads/urgent',
        name: 'myUrgent',
        component: MyUrgentAdsComponent
    },

    {
        path: '/user/favorite',
        name: 'myFavorite',
        component: FavAdsComponent
    },

    //end of myads component



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
    },

    {
        path: '/edit/:id/ad/',
        component: EditController,
    },

    {
        path: '/edit/ad/:id/image',
        component: EditImage,
    }

]