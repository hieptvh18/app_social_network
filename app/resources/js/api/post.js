import Instance from "./instance";
import axios from "axios";
import { header,baseURLApi } from "./instance";

// get data current user login
export const getListPostByFollowing = async () =>{
    const url = '/posts/get-by-following';
    const options = {
        method: 'GET',
        headers: header,
        data: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

// save post data
export const savePostData = async (data) =>{
    const url = '/posts/save';
    const options = {
        method: 'POST',
        headers: header,
        params: data,
        url:baseURLApi+url
    }

    return await axios(options);
}

// move to trash
export const moveToTrash = async (id) =>{
    const url = '/posts/'+id;
    const options = {
        method: 'DELETE',
        headers: header,
        data: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

// get post by id
export const getPostById = async (id) =>{
    const url = '/posts/'+id;
    const options = {
        method: 'GET',
        headers: header,
        params: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

// like post action
export const likePost = async (id) =>{
    const url = '/post/'+id+'/like';
    const options = {
        method: 'POST',
        headers: header,
        params: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

