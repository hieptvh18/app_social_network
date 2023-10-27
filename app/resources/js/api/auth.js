import Instance from "./instance";
import axios from "axios";
import { header,baseURLApi } from "./instance";

const headers = header; 
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

// login with social
export const loginSocial = async (provider,params)=>{
    let url = '/auth/'+provider+'/callback' ;
    const options = {
        method: 'GET',
        headers: headers,
        params: params,
        url:baseURLApi+url
    }
   
    return await axios(options);
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