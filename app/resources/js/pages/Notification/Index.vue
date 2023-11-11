<template>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css"
        integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc="
        crossorigin="anonymous"
    />

    <div class="container">
        <div class="row">
            <div class="col-12 right">
                <div class="box shadow-sm rounded bg-white mb-3">
                    <div class="box-title border-bottom p-3">
                        <h6 class="m-0">Notifications</h6>
                    </div>
                    <div class="box-body p-0">
                        <div
                            v-if="notifications.length"
                            v-for="(val,index) in notifications"
                            :key="index"
                            style="cursor: pointer"
                            class="p-3 d-flex align-items-center border-bottom osahan-post-header"
                            :class="!val.is_read ? 'bg-light' : ''"
                        >
                            <div class="dropdown-list-image mr-3">
                                <img
                                    class="rounded-circle"
                                    :src="val.user ? val.user.avatar : val.avatar"
                                    alt=""
                                />
                            </div>
                            <div class="font-weight-bold mr-3">
                                <div class="text-truncate">

                                </div>
                                <div @click="handleViewNotification(val,$event)" class="small" style="font-size: 16px !important;" v-html="val.message"></div>
                            </div>
                            <span class="ml-auto mb-auto">
                                <div class="btn-group">
                                    <button
                                        type="button"
                                        class="btn btn-light btn-sm rounded"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-right"
                                    >
                                        <button
                                            class="dropdown-item"
                                            type="button"
                                            @click="deleteNoti(val.id)"
                                        >
                                            <i class="mdi mdi-delete"></i>
                                            Delete
                                        </button>
                                        <button
                                            class="dropdown-item"
                                            type="button"
                                            @click="updateUnread(val)"
                                        >
                                            <i class="mdi mdi-close"></i> Mark as unread
                                        </button>
                                    </div>
                                </div>
                                <br />
                                <div class="text-right text-muted pt-1">{{ val.created_at }}</div>
                            </span>
                        </div>
                        <!-- <div
                            class="p-3 d-flex align-items-center osahan-post-header"
                        >
                            <div class="dropdown-list-image mr-3">
                                <img
                                    class="rounded-circle"
                                    src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                    alt=""
                                />
                            </div>
                            <div class="font-weight-bold mr-3">
                                <div class="mb-2">
                                    We found a job at askbootstrap Ltd that you
                                    may be interested in Vivamus imperdiet
                                    venenatis est...
                                </div>
                                <button
                                    type="button"
                                    class="btn btn-outline-success btn-sm"
                                >
                                    View Jobs
                                </button>
                            </div>
                            <span class="ml-auto mb-auto">
                                <div class="btn-group">
                                    <button
                                        type="button"
                                        class="btn btn-light btn-sm rounded"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <div
                                        class="dropdown-menu dropdown-menu-right"
                                    >
                                        <button
                                            class="dropdown-item"
                                            type="button"
                                        >
                                            <i class="mdi mdi-delete"></i>
                                            Delete
                                        </button>
                                        <button
                                            class="dropdown-item"
                                            type="button"
                                        >
                                            <i class="mdi mdi-close"></i> Turn
                                            Off
                                        </button>
                                    </div>
                                </div>
                                <br />
                                <div class="text-right text-muted pt-1">4d</div>
                            </span>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped src="./style.css"></style>
<script>
import {fetchNotifications,deleteNotification,updateNotification} from '../../api/notification';

export default {
    data() {
        return {
            currentUser:window.userLogginIn,
            notifications:[]
        };
    },
    methods: {
        async fetchNotifications(){
             const response = await fetchNotifications();
             console.log(response);
             if(response.data.success){
                this.notifications = response.data.notifications;
             }
        },
        async deleteNoti(id){
            const response = await deleteNotification(id);
            if(response.data.success){
                console.log('delete noti id = '+id);
                this.fetchNotifications();
            }
        },
        async updateUnread(notification){
            let body = {
                'message':notification.message,
                'is_read':false,
                'user_id':notification.user_id
            };
            const response = await updateNotification(notification.id,body);
            if(response.data.success){
                this.fetchNotifications();
            }
        },
        async handleViewNotification(notification,e){
            e.preventDefault();

            const url = e.target.getAttribute('href');

            // set is read
            let body = {
                'message':notification.message,
                'is_read':true,
                'user_id':notification.user_id
            };
            const resp = await updateNotification(notification.id,body);
            window.location.href = url;
        }
    },
    created() {
        this.fetchNotifications();
        const currentUserId = window.userLogginIn.id;
        // init realtime notifi
        try{
            Echo.private("notifications." + currentUserId)
                .listen(".PushNotifications",
                (data) => {
                    console.log(data);
                    this.notifications.unshift(data);
                }
            );
        }catch (er){
            console.log(er)
        }
    },
    beforeUnmount() {
        //  leave channel notifi
        try{
            Echo.leave('notifications.'+window.userLogginIn.id)
        }catch(er){
            console.log('leave channel notifi err is: '+ er);
        }
    },
};
</script>
