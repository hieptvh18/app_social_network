import Instance from "./instance";
import axios from "axios";

export const getUser = () =>{
    const url = '/accounts/user';
    return Instance.get(url);
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