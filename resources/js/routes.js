import HomeComponent from './components/home/homepage.vue';
import CategoryComponent from './components/home/front/pages/category.vue';
import SubCategoryComponent from './components/home/front/pages/subcategory.vue';
import ProductComponent from './components/home/front/pages/product.vue';
import UrgentSellComponent from './components/home/front/pages/allUrgent.vue';
import AllFeaturedAdsComponent from './components/home/front/pages/allFeatureAds.vue';
import CreateAdsComponent from './components/home/back/createAds.vue';
//myads related posts
import MyAdsComponent from './components/home/back/myads.vue';
import MyFeatureAdsComponent from './components/home/back/myAds/featured.vue';
import MyDeletedAdsComponent from './components/home/back/myAds/deleted.vue';
import MySoldAdsComponent from './components/home/back/myAds/soldout.vue';
import MyUrgentAdsComponent from './components/home/back/myAds/urgent.vue';
import FavAdsComponent from './components/home/back/myFav.vue';
//end of myads


import SettingComponent from './components/home/back/setting/setting.vue';
import ChangePasswordComponent from './components/home/back/setting/changePassword.vue';
import ConfirmEmailComponent from './components/home/back/setting/emailSetting.vue';
import AccountSettingComponent from './components/home/back/setting/accountSetting.vue';


import ProfileComponent from './components/home/back/profile.vue';
import CreateController from './components/home/back/createController.vue';
import EditController from './components/home/back/editController.vue';
import EditImage from './components/home/back/form/edit/editImages.vue';

import AdDetail from './components/home/detail/adDetail.vue';


// search
import SearchData from './components/home/front/pages/searchData.vue';
import SellerComponent from './components/home/front/pages/seller.vue';
import SellerDesignComponent from './components/home/front/pages/sellerDesign.vue';

//chat
import ChatComponent from './components/chat/chatApp.vue';


//404 console.error();
import PageNotFound from './components/404.vue';




export const routes = [{
        path: '*',
        component: PageNotFound
    },
    {
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
        path: '/urgent/sell',
        component: UrgentSellComponent
    },

    {
        path: '/feature/ads',
        component: AllFeaturedAdsComponent
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
        path: '/user/email/setting',
        component: ConfirmEmailComponent
    },

    {
        path: '/user/account/setting',
        component: AccountSettingComponent
    },

    {
        path: '/user/change/password',
        component: ChangePasswordComponent
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
    },
    //ad detail

    {
        path: '/ad/detail/:id/:slug',
        component: AdDetail,
        meta:{
            title: '',metaTags: [
            {
              name: 'title',
              content: ''
            },
            {
              property: 'description',
              content: ''
            }
          ]
        }

    },

    //search
    {
        path: '/search/*',
        component: SearchData,
    },

    //seller
    {
        path: '/seller/:id/:username',
        component: SellerComponent,
    },
    {
        path: '/sellerDesign/:id/:username',
        component: SellerDesignComponent,
    },

    //chat
    {
        path: '/message',
        component: ChatComponent,
    }
]
