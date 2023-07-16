<template>
    <div class="py-2 px-4 border-bottom d-none d-lg-block">
        <div class="d-flex align-items-center py-1">
            <div class="position-relative">
                <img
                    src="https://bootdey.com/img/Content/avatar/avatar3.png"
                    class="rounded-circle mr-1"
                    alt="{{user.name}}"
                    width="40"
                    height="40"
                />
            </div>
            <div class="flex-grow-1 pl-3">
                <router-link v-if="user.username" :to="{name:'profile',params:{username:user.username}}">
                    <strong>{{user.name}}</strong>
                </router-link>
                <div class="text-muted small"><em>Typing...</em></div>
            </div>
            <div>
                
                <button class="btn btn-light border btn-lg px-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="feather feather-more-horizontal feather-lg"
                    >
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="19" cy="12" r="1"></circle>
                        <circle cx="5" cy="12" r="1"></circle>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div class="position-relative">
        <div class="chat-messages p-4" ref="chat_messages">
            
            <div
                v-if="list_messages.length" v-for="(message,index) in list_messages"
                :key="index"
                class="pb-4"
                :class="{'chat-message-left': message.from.id == user.id, 'chat-message-right': message.from.id != user.id}">
                    <div>
                        <img
                            :src="message.from.avatar"
                            class="rounded-circle mr-1"
                            alt="Chris Wood"
                            width="40"
                            height="40"
                        />
                        <div class="text-muted small text-nowrap mt-2">2:33 am</div>
                    </div>
                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                        <div class="font-weight-bold mb-1">{{ message.from.id != user.id ? 'You' : message.from.name }}</div>
                        {{ message.message }}
                    </div>
            </div>
        </div>
    </div>

    <div class="flex-grow-0 mb-4 border-top" style="position: absolute; bottom: 0;right: 0;left: 0;">
        <form @submit.prevent="sendMessages" class="input-group d-flex">
            <EmojiPicker picker-type="input" @update:text="changeMessage" @select="onSelectEmoji" />
            <button class="btn btn-primary">Send</button>
        </form>
    </div>
</template>

<style src="../../../pages/Message/index.css"></style>
<style scoped>
.v3-input-emoji-picker{
    width: 80%;
}
input.v3-emoji-picker-input{
    width: 100%;
}
</style>

<script setup>
import {ref} from 'vue';
import { useRoute } from "vue-router";
import {getUserById} from "../../../api/user";

var user = ref({});
var loaderChatDetail = ref(true);

// get user data and chat content
const getUserByUserParam = ()=>{
    const route = useRoute();
    const userId = route.params.id;
    // fetch user
    getUserById(userId)
        .then(res=>{
            console.log(res)
            loaderChatDetail.value = false;
            if(res.data.success) user.value = res.data.data;
            else console.log('not found user chat detail');
        })
        .catch(er=> {
            loaderChatDetail.value = false;
            console.log(er)
        })
}
getUserByUserParam();

</script>

<script>
import EmojiPicker from "vue3-emoji-picker";
import "vue3-emoji-picker/css";
import {ref} from "vue";
import {useRoute} from 'vue-router';
import {fetchMessagePrivate, sendMessage} from "../../../api/chat";

export default {
    components:{EmojiPicker},
    data(){
        return{
            list_messages:[],
            input:'', //message
            user: window.userLogginIn,
            roomId:false,
            receiverId: useRoute().params.id
        }
    },
    methods:{
        onSelectEmoji (emoji) {
            this.input += emoji.i;
        },
        changeMessage (message){
            this.input = message;
        },
        async sendMessages(){
            try{
                const response = await sendMessage({receiver:this.receiverId,message:this.input});
             
                if(response.data.success){
                    this.input = '';
                    this.list_messages.push(response.data.message);
                    console.log(this.list_messages);
                    this.scrollToBottom();
                }
            }catch(er){
                console.log(er);
            }
        },
        async loadMessage(){
            try{
                const response = await fetchMessagePrivate(this.receiverId);
                if(response.data.success){
                    this.list_messages = response.data.list_message;
                    this.roomId = response.data.list_message[0].room_id;
                    this.scrollToBottom();
                }

            }catch(er){
                console.log(er);
            }
        },
        scrollToBottom(){
            setTimeout(() => {
                let  scrollHeight = this.$refs.chat_messages.scrollHeight;
                this.$refs.chat_messages.scrollTo({
                    top:scrollHeight,
                    left:0,
                    behavior:"smooth"
                })
            });
        },
        
    },
    async created(){
        await this.loadMessage();
        // init realtime
        Echo.channel('chatroom.' + this.roomId)
            .listen('MessageSent', (data) => {
                console.log('realtime log');
                console.log(data);
                
                let message = data.message
                message.from = data.from
                this.list_messages.push(message);
                this.scrollToBottom()
            })
    }
}
</script>
