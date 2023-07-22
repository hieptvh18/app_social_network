<template>
    <div class="photos__comment mt-3">
        <div class="list-my-comments mb-2">
            <div class="comment-item d-flex" v-if="myComments.length" v-for="(comment,index) in myComments" :key="index">
                <div class="avatar-mni ml-2 mr-2"><img :src="currentUser.avatar" alt="avatar"></div>
                <span class="font-weight-bold mr-2">{{ currentUser.username }}</span>
                <span>{{ comment.message }}</span>
            </div>
        </div>
        <form @submit.prevent="postComment">
            <div class="form-group d-flex">
                <input
                required
                    v-model="message"
                    type="text"
                    placeholder="Add a comment..."
                    name="comment"
                    class="form-control"
                    id=""
                />
                <button class="btn btn-light"><i class="fa-regular fa-paper-plane"></i></button>
            </div>
        </form>
    </div>
</template>
<script>
    import {fetchComments,saveComment} from '../../api/comment'; 
    import {ref} from 'vue';

    export default{
        name:"form-comment",
        data(){
            return{
                message: '',
                myComments:[],
                currentUser:window.userLogginIn
            }
        },
        props:['postId'],
        methods:{
            fetchComments(){
                
            },
            async postComment(){
                const response  = await saveComment({user_id:window.userLogginIn.id,message:this.message,post_id:this.postId});

                if(response.data.success){
                    this.myComments.push(response.data.comment);
                    this.message = '';
                }
            }
        },
        beforeMount(){
            this.fetchComments();
        },
        created(){
            // init realtime notifi
            console.log('created func');
             Echo.private('notifications.' + this.postId)
            .listen('PushNotifications', (data) => {
                console.log('listen event notifi when comment post==========');
            })
        }
    }
</script>
<style scoped>
.avatar-mni{
    width: 20px;
    height: 20px;
    border-radius: 50%;
    overflow: hidden;
}
.avatar-mni img{
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>