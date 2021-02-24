<template>
    <div>
        <carousel class="d-none d-sm-flex"></carousel>
        <mobileNav class="d-flex d-sm-none"></mobileNav>
        <premium></premium>
        <urgent></urgent>
        <dataContent></dataContent>
    </div>
</template>
<script>
import carousel from './front/index_page/carousel';
import urgent from './front/index_page/urgent';
import premium from './front/index_page/premium';
import dataContent from './front/index_page/content';
import mobileNav from './mobileNav';
    export default{
        components:{
             mobileNav,
             carousel,
             dataContent,
             premium,
             urgent,
         },
    }
</script>
