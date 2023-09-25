<template>
    <div class="">
        <swiper
            class="stories-menu-slider"
            :slides-per-view="swiperOptions.slidesPerView"
        >
            <swiper-slide
                class="stories-menu-slider__item create"
                :key="'11111'"
                :style="{ backgroundColor: white }"
            >
                <router-link :to="{name:'storycreate'}">New</router-link>
            </swiper-slide>
            <swiper-slide
                class="stories-menu-slider__item"
                v-for="(story, index) in stories.stories"
                :key="story.id"
                :style="{ backgroundImage: 'url(' + story.bg + ')' }"
                @click="openStory(index)"
            >
                <div class="stories-menu-slider__item-author">
                    {{ story.username }}
                </div>
            </swiper-slide>
        </swiper>
        
    </div>
</template>

<script setup>
import { ref,onBeforeMount } from "vue";
import { useStoriesStore } from "../../../../../store/stories";
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/css";

const stories = useStoriesStore();

const swiperOptions = ref({
    slidesPerView: "auto",
});

const openStory = (index) => {
    stories.storyIndex = index;
    stories.isStoriesActive = true;
};



onBeforeMount(() => {
    // stories.fetchMyStories();
})
</script>

<style lang="scss" scoped>
.stories-menu-slider {
    overflow: visible;
    margin: 20px 0 30px 0;

    &__item {
        padding: 0.5rem;
        width: 5rem;
        height: 5rem;
        border-radius: 50%;
        border: 2px solid orange;
        cursor: pointer;
        background-size: cover;

        &.create a{
          width: 100%;
          height: 100%;
          color: #000;
          display: flex;
          align-items: center;
          justify-content: center;

          &:hover{
            opacity: 0.8;
          }
        }

        @include r($md) {
            width: 35rem;
            height: 35rem;
        }

        @include r($sm) {
            width: 40rem;
            height: 40rem;
        }

        &:not(:last-child) {
            margin-right: 2rem;
        }

        &-img {
            flex: 1;
        }
        &-author {
            margin-top: 70px;
            text-align: center;
        }
        &-title {
            @include text20;

            @include r($sm) {
                font-size: 16px;
            }
        }
    }
}
</style>
