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

					<router-link :to="{name:'chatdetail',params:{username:'hieptvh'}}" class="list-group-item list-group-item-action border-0">
						<div class="badge bg-success float-right">5</div>
						<div class="d-flex align-items-start">
							<img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1" alt="Vanessa Tucker" width="40" height="40">
							<div class="flex-grow-1 ml-3">
								Hiep tran van
								<div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
							</div>
						</div>
					</router-link>
					<a href="#" class="list-group-item list-group-item-action border-0">
						<div class="badge bg-success float-right">2</div>
						<div class="d-flex align-items-start">
							<img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="rounded-circle mr-1" alt="William Harris" width="40" height="40">
							<div class="flex-grow-1 ml-3">
								William Harris
								<div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
							</div>
						</div>
					</a>
					<a href="#" class="list-group-item list-group-item-action border-0">
						<div class="d-flex align-items-start">
							<img src="https://bootdey.com/img/Content/avatar/avatar3.png" class="rounded-circle mr-1" alt="Sharon Lessman" width="40" height="40">
							<div class="flex-grow-1 ml-3">
								Sharon Lessman
								<div class="small"><span class="fas fa-circle chat-online"></span> Online</div>
							</div>
						</div>
					</a>
					<a href="#" class="list-group-item list-group-item-action border-0">
						<div class="d-flex align-items-start">
							<img src="https://bootdey.com/img/Content/avatar/avatar4.png" class="rounded-circle mr-1" alt="Christina Mason" width="40" height="40">
							<div class="flex-grow-1 ml-3">
								Christina Mason
								<div class="small"><span class="fas fa-circle chat-offline"></span> Offline</div>
							</div>
						</div>
					</a>
					<a href="#" class="list-group-item list-group-item-action border-0">
						<div class="d-flex align-items-start">
							<img src="https://bootdey.com/img/Content/avatar/avatar5.png" class="rounded-circle mr-1" alt="Fiona Green" width="40" height="40">
							<div class="flex-grow-1 ml-3">
								Fiona Green
								<div class="small"><span class="fas fa-circle chat-offline"></span> Offline</div>
							</div>
						</div>
					</a>

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

const showRouterView = ref(false);
const route = useRoute();
let username = route.params.username;

if(username) showRouterView.value = true;
else showRouterView.value = false;


</script>