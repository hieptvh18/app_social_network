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
export const getUser = async () =>{
    const url = '/accounts/user';
    const options = {
        method: 'GET',
        headers: headers,
        data: {},
        url:baseURLApi+url
    }
   
    return await axios(options);
}
// login with username & password
export const loginUsername = (formData)=>{
    let url = '/accounts/login' ;
    return Instance.post(url,formData);
}

export const register = (formData) =>{
    let url = 'accounts/register';
    return Instance.post(url,formData);
}
// api logout account
export const logout = () =>{
    let url = '/accounts/logout';
    let options = {
        method: 'POST',
        headers: headers,
        data: {},
      }
    options.url = baseURLApi + url;
    return axios(options);
}