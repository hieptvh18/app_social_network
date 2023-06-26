<template>
    <div class="content-form-edit-profile p-4" v-if="!loading">
        <div
            class="alert"
            v-if="message.success || message.error"
            :class="{
                'alert-success': message.success,
                'alert-danger': message.error,
            }"
        >
            {{ message.error ? message.error : message.success }}
        </div>
        <div class="avatar">
            <div class="box-avatar">
                <img
                    v-if="avatar"
                    :src="avatar"
                    alt=""
                />
            </div>
        </div>
        <form enctype="multipart/form-data" @submit.prevent="onSubmit">
            <div class="username">
                <span class="font-weight-bold">tranvhh</span>
                <br />
                <a href="#" @click="openModalUpload">Change profile photo</a>
                <input
                    @change="onChange"
                    type="file"
                    name="inpt_upload_avatar"
                    id="inpt-upload-avatar"
                    ref="inpt_upload_avatar"
                    style="display: none;"
                />
            </div>
        </form>

        <div
            class="alert alert-danger"
            v-if="message.errors.length"
            v-for="(error, index) in message.errors"
        >
            {{ error }}
        </div>
        <form @submit.prevent="submitUpdate">
            <input type="hidden" name="id" :value="formData.id" />

            <div class="form-group d-flex">
                <label for="" class="col-1">Name</label>
                <div class="ml-3">
                    <input
                        type="text"
                        name="name"
                        class="form-control-sm"
                        :value="formData.name"
                        disabled
                    />
                    <br />
                    <small
                        >You are using the same name on Instagram and Facebook.
                        Go to Facebook to change your name. Change Name
                    </small>
                </div>
            </div>

            <div class="form-group d-flex">
                <label for="" class="col-1">Username</label>
                <div class="ml-3">
                    <input
                        type="text"
                        name="username"
                        class="form-control-sm"
                        v-model="formData.username"
                    />
                    <br />
                    <small
                        >In most cases, you'll be able to change your username
                        back to tranvhh for another 14 days.
                    </small>
                </div>
            </div>

            <div class="form-group d-flex">
                <label for="" class="col-1">Bio</label>
                <div class="ml-3">
                    <textarea
                        name="bio"
                        id=""
                        cols="30"
                        rows="4"
                        class="form-control"
                        v-model="formData.bio"
                    ></textarea>
                    <br />
                    <small
                        >In most cases, you'll be able to change your username
                        back to tranvhh for another 14 days.
                    </small>
                </div>
            </div>

            <div class="form-group d-flex">
                <label for="" class="col-1">Email</label>
                <div class="ml-3">
                    <input
                        type="email"
                        name="email"
                        v-model="formData.email"
                        class="form-control-sm"
                    />
                </div>
            </div>

            <div class="form-group d-flex">
                <label for="" class="col-1">Phone</label>
                <div class="ml-3">
                    <input
                        type="text"
                        name="phone"
                        class="form-control-sm"
                        v-model="formData.phone"
                    />
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <!-- <router-link :to="{name:'profile',params:{username:userLoggin.username}}">Back to profile</router-link> -->
        </form>
        <div class="text-secondary">© 2023 Instagram from Meta</div>
    </div>
    <ModalLoading v-if="loading || loader" />
</template>

<style scoped src="./index.css"></style>

<script>
import { getUser } from "../../api/auth";
import { ref } from "vue";
import ModalLoading from "../../components/ModalLoading.vue";
import LoaderResult from "../../components/LoaderResult.vue";
import { updateUser, uploadAvatar } from "../../api/user";
import {
    validateUsername,
    validatePhoneNumber,
    validateEmail,
} from "../../helpers/functions";

export default {
    components: { ModalLoading },
    data() {
        return {
            formData: {
                id: "",
                username: "",
                name: "",
                email: "",
                password: "",
                phone: "",
            },
            loading: ref(true),
            loader: ref(false),
            message: {
                success: "",
                error: "",
                errors: [],
            },
            avatar:''
        };
    },
    methods: {
        submitUpdate(e) {
            this.loader = true;
            let formData = this.formData;

            if (!this.validateForm()) return;

            updateUser(formData)
                .then((response) => {
                    if (response.data.success) {
                        this.message.error = "";
                        this.message.success = "Update profile successfully!";
                        this.loader = false;
                    }
                })
                .catch((err) => {
                    console.log(err);
                    if (err.response.status == 422) {
                        this.loader = false;
                        this.message.success = "";
                        this.message.error = Object.values(
                            err.response.data.errors
                        )[0][0];
                    }
                });
        },

        getUserData() {
            getUser()
                .then((response) => {
                    if (response.data.success == true) {
                        let user = response.data.data;
                        this.formData.id = user.id;
                        this.formData.username = user.username;
                        this.formData.name = user.name;
                        this.formData.email = user.email;
                        this.formData.bio = user.bio;
                        this.formData.phone = user.phone;
                        this.avatar = user.avatar
                    }
                })
                .catch((err) => {
                    console.log(err);
                })
                .then(() => (this.loading = false));
        },

        validateForm() {
            if (!validateUsername(this.formData.username)) {
                this.message.error = "Username is invalid!";
                return false;
            }

            if (!validateEmail(this.formData.email)) {
                this.message.error = "Email is invalid!";
                return false;
            }

            if (!validatePhoneNumber(this.formData.phone)) {
                this.message.error = "Phone is invalid!";
                return false;
            }
            return true;
        },

        openModalUpload(e) {
            e.preventDefault();
            this.$refs.inpt_upload_avatar.click();
        },

        onChange (e) {
            let avatar = e.target.files[0];
            let formUploads = new FormData();
            formUploads.append('avatar', avatar);

            uploadAvatar(formUploads)
            .then(response=>{
                console.log(response);
                if(response.data.success){
                    this.message.success = 'Change avatar success!';
                    this.message.errors = [];
                    this.message.error = '';

                    this.avatar = response.data.data.avatar
                }else{
                    this.message.error = 'Upload fail! Server error!';
                }
            })
            .catch(err=>{
                console.log(err);
                if(err.response.data.status = 422){
                    let errorAvatar = err.response.data.errors.avatar;
                    this.message.errors = errorAvatar;
                }
            })
        }
    },
    beforeMount() {
        this.getUserData();
    },
};
</script>
