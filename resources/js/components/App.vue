<template>
    <div id="nav">
        <b-nav tabs>
            <b-nav-item  ><router-link :to="{name:'incomplete-todo'}"> Incomplet Todos</router-link></b-nav-item>
            <b-nav-item><router-link :to="{name:'completed-todo'}"> Completed Todos</router-link></b-nav-item>
            <!-- </b-navbar-nav> -->
        </b-nav>
        <b-list-group>
            <router-view/>
        </b-list-group>


    </div>
</template>
<script>
export default {

}
</script>
<style scoped>
@import url('/css/app.css');
</style>
