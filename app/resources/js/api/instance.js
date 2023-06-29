import axios from 'axios';

const Instance = axios.create({
    baseURL:'http://127.0.0.1:8000/api/v1'
});

export default Instance;

 // get token login -> parse logout api
 const token = window.localStorage.getItem('tokenLogin');
 const headers = {
     'Authorization':'Bearer '+token,
     'X-Requested-With':'XMLHttpRequest' 
   };
 
 export const header = headers;

 export const baseURLApi = 'http://127.0.0.1:8000/api/v1';