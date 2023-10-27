
<template>
   <div class="">
        <ModalLoading/>
   </div>
</template>

<script>
    import { ref } from "vue";
    import { loginSocial } from "../../api/auth";
    import ModalLoading from "../../components/ModalLoading.vue";
    
    export default {
        data() {
            return {
               
            };
        },
        methods: {
            
        },
        created(){
            let code = this.$route.query.code;
            let provider = this.$route.params.provider;
            // call api callback with code
            const resp = loginSocial(provider,{
                'code':code
            });

            resp.then((res)=>{
                window.localStorage.setItem(
                            "tokenLogin",
                            res.data.data.token
                        );
                        window.location.href = "/";
            }).catch(er=>{
                console.log('login fail'+er);
            })
        }
    };
    </script>
