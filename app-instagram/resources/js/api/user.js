import Instance from "./instance";
import axios from "axios";

const baseURLApi = 'http://127.0.0.1:8000/api/v1';

 // get token login -> parse logout api
const token = window.localStorage.getItem('tokenLogin');
const headers = {
    'Authorization':'Bearer '+token,
    'X-Requested-With':'XMLHttpRequest' 
  };

// get data current user login
export const getUserByUsername = async (formData) =>{
    const url = '/user/get-user';
    const options = {
        method: 'GET',
        headers: headers,
        params: formData,
        url:baseURLApi+url
    }
    console.log(options);
   
    return await axios(options);
}
