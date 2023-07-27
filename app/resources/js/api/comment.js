import Instance from "./instance";
import axios from "axios";
import { header,baseURLApi } from "./instance";

// get data current user login
export const fetchComments = async (postId) =>{
    const url = '/comments/post/'+postId;
    const options = {
        method: 'GET',
        headers: header,
        data: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

// save post data
export const saveComment = async (data) =>{
    const url = '/comments/post/save';
    const options = {
        method: 'POST',
        headers: header,
        params: data,
        url:baseURLApi+url
    }

    return await axios(options);
}

// delete comment
export const deleteComment = async (id) =>{
    const url = '/comments/delete/'+id;
    const options = {
        method: 'DELETE',
        headers: header,
        params: {},
        url:baseURLApi+url
    }

    return await axios(options);
}
