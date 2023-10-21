import axios from 'axios';

export const baseURLApi = 'http://127.0.0.1:8000/api/v1';

const Instance = axios.create({
    baseURL:baseURLApi
});

export default Instance;

 // get token login -> parse logout api
 const token = window.localStorage.getItem('tokenLogin');
 const headers = {
     'Authorization':'Bearer '+token,
     'X-Requested-With':'XMLHttpRequest',
     'Accept':'application/json'
   };

 export const header = headers;

