// App.vue is component root of vue

<template>
    <div class="container">
        <div>
            <router-view v-slot="{ Component, route }">
                <transition name="fade">
                    <component :is="Component" :key="route.path" />
                </transition>
            </router-view>
        </div>
    </div>
</template>

<style>
    .fade-enter-active, .fade-leave-active {
      transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
      opacity: 0
    }
</style>

<script>

    export default{
    }
</script>

