<template>
    <main class="content">
    <div class="p-0">

		<div class="card">

			<div class="row g-0" style="height: 100%;">
				<!-- list friend -->
				<div class="col-12 col-lg-5 col-xl-3 border-right" style="height: 100%;">
					<h4 class="h4 ml-4 mt-2">Messages</h4>

					<div class="px-4 d-none d-md-block">
						<div class="d-flex align-items-center">
							<div class="flex-grow-1">
								<input type="text" class="form-control my-3" placeholder="Search...">
							</div>
						</div>
					</div>

					<router-link v-for="(user,index) in listFriends" :to="{name:'chatdetail',params:{id:user.id}}" class="list-group-item list-group-item-action border-0" :key="index">
						<div class="badge bg-success float-right">5</div>
						<div class="d-flex align-items-start">
							<img :src="user.avatar" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
							<div class="flex-grow-1 ml-3">
								{{user.name}}
								<div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
							</div>
						</div>
					</router-link>

					<hr class="d-block d-lg-none mt-1 mb-0">
				</div>

				<div class="col-12 col-lg-7 col-xl-9">
					<div v-if="!showRouterView" class="chat-default-box">
						<div class="chat-default text-center" >
							<div class="default-chat__title">Your Messages</div>
							<div class="">
								Send private photos and messages to a friend or group
							</div>
						</div>
					</div>
					<router-view v-if="showRouterView"></router-view>
				</div>
			</div>
		</div>
	</div>
</main>
</template>

<style scoped src="./index.css"></style>

<script setup>
import axios from 'axios';
import { ref } from 'vue';
import { useRoute } from "vue-router";
import {getListFriend} from "../../api/user";

const listFriends = ref([]) ;

const showRouterView = ref(false);
const route = useRoute();
let id = route.params.id;

if(id) showRouterView.value = true;
else showRouterView.value = false;

getListFriend()
    .then(res=>{
        if(res.data.success) listFriends.value = res.data.data;
    })
    .catch(er=>{
        console.log(er);
    })
</script>
