import Instance from "./instance";
import axios from "axios";

import {baseURLApi} from './instance';

 // get token login -> parse logout api
const token = window.localStorage.getItem('tokenLogin');
const headers = {
    'Authorization':'Bearer '+token,
    'X-Requested-With':'XMLHttpRequest'
  };
  const headersUploadFile = {
    headers:{
        "Content-Type": "multipart/form-data",
        'Authorization':'Bearer '+token,
        // 'X-Requested-With':'XMLHttpRequest'
    }
  };
// get data current user login
export const getUserByUsername = async (username) =>{
    const url = '/user/get-user';
    const options = {
        method: 'GET',
        headers: headers,
        params: {username:username},
        url:baseURLApi+url
    }

    return await axios(options);
}

export const getUserById = async (id) =>{
    const url = '/user/'+id;
    const options = {
        method: 'GET',
        headers: headers,
        params: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

// get List friend
export const getListFriend = async () =>{
    const url = '/message/users';
    const options = {
        method: 'GET',
        headers: headers,
        params: {},
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

// get list recommend following in homepage
export const getRecomendFollowing = async () =>{
    const url = '/recommend-follows';
    const options = {
        method: 'GET',
        headers: headers,
        params: {},
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

// following
export const uploadAvatar = async(formData)=>{
    const url = '/user/upload-avatar';
    let config = headersUploadFile;
    let data = formData;

    return await axios.post(baseURLApi+url,data,config);
}

// following
export const updatePassword = async(formData)=>{
    const url = '/user/change-pass';
    const options = {
        method: 'PUT',
        headers: headers,
        params: formData,
        url:baseURLApi+url
    }

    return await axios(options);
}
