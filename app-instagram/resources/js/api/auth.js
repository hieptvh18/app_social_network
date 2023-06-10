import Instance from "./instance";
import axios from "axios";

const baseURLApi = 'http://127.0.0.1:8000/api/v1';

export const getUser = async (headers) =>{
    const url = '/accounts/user';
    const options = {
        method: 'GET',
        headers: headers,
        data: {},
        url:baseURLApi+url
    }
   
    return await axios(options);
}

export const loginUsername = (formData)=>{
    let url = '/accounts/login' ;
    return Instance.post(url,formData);
}

export const register = (formData) =>{
    let url = 'accounts/register';
    return Instance.post(url,formData);
}

export const logout = (options) =>{
    let url = '/accounts/logout';
    return axios(options);
}