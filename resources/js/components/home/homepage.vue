<template>
    <div>
        <carousel class="d-none d-sm-flex"></carousel>
        <mobileNav class="d-flex d-sm-none"></mobileNav>
        <premium></premium>
        <urgent-sell></urgent-sell>
        <data-content></data-content>
    </div>
</template>
<script>
import mobileNav from './mobileNav';
    export default{
        components:{
             mobileNav,
         },
    }
</script>
