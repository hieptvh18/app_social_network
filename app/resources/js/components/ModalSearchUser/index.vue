<template>
<span @click="toggleModal">
    Search
</span>

<!-- Modal -->
<div class="modal-search-box" :class="{'hide':!isShowModal,'active':isShowModal}">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSearchUser">Search User</h5>
                <button type="button" class="close" @click="toggleModal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="inpt-search">
                    <input @keyup="searchUser" name="search_user" type="search" placeholder="Username..." class="form-control">
                </div>
                <LoaderResult v-if="loading"/>
               <ul class="search-result" v-if="!loading && resultSearch">
                    <li v-for="(user,index) in resultSearch" class="result-search__items mb-2" v-bind:key="index">
                        <router-link :to="{name:'profile',params:{username:user.username}}">
                            <div class="result-search__item">
                                <div>
                                    <img :src="user.avatar" :alt="user.name"/>
                                </div>
                                <div>
                                    <b>{{user.username}}</b>
                                    <div class="text-secondary">{{user.name}}</div>
                                </div>
                            </div>
                        </router-link>
                    </li>
               </ul>
               <div v-if="!loading && !resultSearch" class="search-result__blank">Nothing result!</div>
            </div>
        </div>
</template>

<style scoped src="./index.css"></style>
<script>
import LoaderResult from '../LoaderResult.vue';
import {searchUserByUsername} from '../../api/user';
import { ref } from 'vue';


export default {
    name: '',
    components: {LoaderResult},

    data() {
        return {
            resultSearch:true,
            loading:ref(false),
            isShowModal:ref(false)
        }
    },
    // method is binding method to DOM
    methods: {
        searchUser(e){
            this.loading = true;

            let keySearch = e.target.value;
            let formdata = new FormData();
            formdata.username = keySearch;
            const searchUserResult = searchUserByUsername(formdata)
                .then(response=>{
                    console.log(response);
                    const dataResult = response.data.data;
                    if(response.data.success){
                        this.loading = false;
                        if(dataResult.length > 0){
                            this.resultSearch = dataResult;
                        }else{
                            this.resultSearch = '';
                        }
                    }else{
                        this.resultSearch = '';
                    }
                })
                .catch(err=>console.log(err))
                .then(()=>this.loading = false)
        },

        toggleModal(){
            this.isShowModal ? this.isShowModal = false : this.isShowModal = true;
        }
    },

    setup(){
        // var loading = ref(true);
        // return {
        //     loading
        // }
    },
    computed:{
        //  searchUser(){
        //     console.log('asdas');
        // }
    }
};
</script>

