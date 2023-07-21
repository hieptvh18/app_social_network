import Instance from "./instance";
import axios from "axios";
import { header,baseURLApi } from "./instance";

// get data current user login
export const fetchMessagePrivate = async (receiver) =>{
    const url = '/chat/fetch-message/'+receiver;
    const options = {
        method: 'GET',
        headers: header,
        data: {},
        url:baseURLApi+url
    }
   
    return await axios(options);
}

// save post data
export const sendMessage = async (data) =>{
    const url = '/chat/save';
    const options = {
        method: 'POST',
        headers: header,
        params: data,
        url:baseURLApi+url
    }
   
    return await axios(options);
}

