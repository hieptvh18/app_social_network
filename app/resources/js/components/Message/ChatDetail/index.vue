<template>
    <div class="py-2 px-4 border-bottom d-none d-lg-block">
        <div class="d-flex align-items-center py-1">
            <div class="position-relative">
                <img
                    :src="user.avatar"
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
                <div class="text-muted small" v-if="typing"><em>Typing...</em></div>
            </div>
            <div>
                <div class="btn-group dropleft">
                    <button type="button" class="btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                    <div class="dropdown-menu">
                        <a @click="blockMessage" class="dropdown-item" href="#">Block message</a>
                    </div>
                </div>
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
                    </div>
                    <div class="flex-shrink-1 bg-light rounded py-2 px-3 mr-3">
                        <div class="font-weight-bold mb-1">{{ message.from.id != user.id ? 'You' : message.from.name }}</div>
                        <div class="message-text">
                            {{ message.message }}
                        </div>
                        <div class="text-muted small text-nowrap mt-2">{{ formatDateString(message.created_at) }}</div>
                    </div>
            </div>
        </div>
    </div>

    <div class="flex-grow-0 pb-4 border-top bg-light" style="position: absolute; bottom: 0;right: 0;left: 0;">
        <form @submit.prevent="sendMessages" class="input-group d-flex">
            <EmojiPicker picker-type="input" @keyup="isTyping" @update:text="changeMessage" @select="onSelectEmoji" />
            <button class="btn btn-primary">Send</button>
        </form>
    </div>
</template>

<style src="../../../pages/Message/index.css"></style>
<style src="./style.css"></style>
<style scoped>
.v3-input-emoji-picker{
    width: 90%;
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
            receiverId: useRoute().params.id,
            typing:false
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

                    this.scrollToBottom();
                    document.querySelector('input.v3-emoji-picker-input').value = '';
                }
            }catch(er){
                console.log(er);
            }
        },
        async loadMessage(){
            try{
                const response = await fetchMessagePrivate(this.receiverId);
                if(response.data.success){
                    console.log(response.data.list_message);
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
        blockMessage(){
            console.log('block')
        },
        formatDateString(date){
            const dateFormat = new Date(date);
            const dateString =
                dateFormat.getFullYear() + "/" +
                ("0" + (dateFormat.getMonth()+1)).slice(-2) + "/" +
                ("0" + dateFormat.getDate()).slice(-2) + " " +
                ("0" + dateFormat.getHours()).slice(-2) + ":" +
                ("0" + dateFormat.getMinutes()).slice(-2) + ":" +
                ("0" + dateFormat.getSeconds()).slice(-2);

                return dateString;
        },
        isTyping(){
            let channel = Echo.private('chatroom.' + this.roomId);

            setTimeout(function() {
                if(!this.typing){
                    channel.whisper('typing', {
                        user: window.userLogginIn,
                        typing: true
                    });
                }
            }, 300);
        }

    },
    async created(){
        await this.loadMessage();
        const self = this;

        // init realtime
        try {
            Echo.private('chatroom.' + this.roomId)
                .listen('.MessageSent', (data) => {
                    let message = data.message
                    message.from = data.from
                    this.list_messages.push(message);
                    this.scrollToBottom()
                })
                .listenForWhisper('typing', (e) => {
                    console.log(e)
                    self.typing = e.typing;

                    // remove is typing indicator after 2s
                    setTimeout(function () {
                        self.typing = false
                    }, 2000);
                });

        }catch (er){
            console.log(er)
        }
    },

    beforeUnmount(){
         // leave channel chat
        try{
            Echo.leave('chatroom.' + this.roomId);
        }catch(er){
            console.log('leave channel chat 1-1 err is: '+ er);
        }
    }
}
</script>
