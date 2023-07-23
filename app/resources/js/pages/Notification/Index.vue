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
                            class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header"
                            v-if="notifications.length"
                            v-for="(val,index) in notifications"
                            :key="index"
                        >
                            <div class="dropdown-list-image mr-3">
                                <img
                                    class="rounded-circle"
                                    src="https://bootdey.com/img/Content/avatar/avatar3.png"
                                    alt=""
                                />
                            </div>
                            <div class="font-weight-bold mr-3">
                                <div class="text-truncate">
                                    DAILY RUNDOWN: WEDNESDAY
                                </div>
                                <div class="small">
                                    {{ val.message }}
                                </div>
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
                                            @click="updateStatus"
                                        >
                                            <i class="mdi mdi-close"></i> Turn
                                            Off
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
import {fetchNotifications,deleteNotification} from '../../api/notification';

export default {
    data() {
        return {
            currentUser:window.userLogginIn,
            notifications:[]
        };
    },
    methods: {
        async fetchNotifications(){
             const response = await fetchNotifications(this.currentUser.id);
             console.log(response);
             if(response.data.success){
                this.notifications = response.data.notifications;
             }
        },
        async deleteNoti(id){
            const response = await deleteNotification(id);
            console.log(response);
            if(response.data.success){
                console.log('delete noti id = '+id);
                this.fetchNotifications();
            }
        },
        updateStatus(){
            console.log('update status notification');
        }
    },
    created() {
        const self = this;
        this.fetchNotifications();
        // init realtime notifi
        Echo.private("notifications").listen(
            "PushNotifications",
            (data) => {
                console.log("listen event notifi when comment post==========");
                console.log(data);
                console.log(this.notifications);
                this.notifications.unshift(data);
            }
        );
    },
    beforeUnmount() {
        //  leave channel notifi
        try{
            Echo.leave('notifications')
        }catch(er){
            console.log('leave channel notifi err is: '+ er);
        }
    },
};
</script>
