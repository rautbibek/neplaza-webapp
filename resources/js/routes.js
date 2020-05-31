import HomeComponent from './components/home/homepage.vue';
import CategoryComponent from './components/home/front/pages/category.vue';
import SubCategoryComponent from './components/home/front/pages/subcategory.vue';
import ProductComponent from './components/home/front/pages/product.vue';

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
]