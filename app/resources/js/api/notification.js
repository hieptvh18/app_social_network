import Instance from "./instance";
import axios from "axios";
import { header,baseURLApi } from "./instance";

// get data current user login
export const fetchNotifications = async (userId) =>{
    const url = '/notification/'+userId;
    const options = {
        method: 'GET',
        headers: header,
        data: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

// get count notification is_read = 0
export const fetchNotificationsUnread = async () =>{
    const url = '/fetch-notification/count-unread/';
    const options = {
        method: 'GET',
        headers: header,
        data: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

// notifi delete
export const deleteNotification = async (id) =>{
    const url = '/notification/delete/'+id;
    const options = {
        method: 'DELETE',
        headers: header,
        params: {},
        url:baseURLApi+url
    }

    return await axios(options);
}
