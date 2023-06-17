<template>
<span class="" data-toggle="modal" data-target="#modalSearchUser">
    Search
</span>

<!-- Modal -->
<div class="modal" id="modalSearchUser" tabindex="-1" role="dialog" aria-labelledby="modalSearchUser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSearchUser">Search User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="inpt-search">
                    <input @keyup="searchUser" name="search_user" type="search" placeholder="Username..." class="form-control">
                </div>
                <LoaderResult v-if="loading"/>
               <ul class="search-result" v-if="!loading && resultSearch">
                    <li v-for="(user,index) in resultSearch" class="result-search__item" v-bind:key="index"><router-link :to="{name:'profile',params:{username:user.username}}">{{ user.name }}</router-link></li>
               </ul>
               <div v-if="!loading && !resultSearch" class="search-result__blank">Nothing result!</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Next</button>
            </div>
        </div>
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
            loading:ref(false)
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

