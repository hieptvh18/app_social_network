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
   
    return await axios(options);
}

// search user by username
export const searchUserByUsername = async (formData) =>{
    const url = '/user/search';
    const options = {
        method: 'GET',
        headers: headers,
        params: formData,
        url:baseURLApi+url
    }
   
    return await axios(options);
}

// update user info
export const updateUser = async(formData)=>{
    const url = '/user/update';
    const options = {
        method: 'PUT',
        headers: headers,
        params: formData,
        url:baseURLApi+url
    }
   
    return await axios(options);
}

// following
export const followUser = async(formData)=>{
    const url = '/user/following';
    const options = {
        method: 'POST',
        headers: headers,
        params: formData,
        url:baseURLApi+url
    }
   
    return await axios(options);
}

// following
export const unFollowUser = async(formData)=>{
    const url = '/user/unfollow';
    const options = {
        method: 'POST',
        headers: headers,
        params: formData,
        url:baseURLApi+url
    }
   
    return await axios(options);
}
