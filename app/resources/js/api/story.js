import Instance from "./instance";
import axios from "axios";
import { header,baseURLApi } from "./instance";

const headers = header;

export const storeStory = async (data) =>{
    const url = '/story/save';
    const options = {
        method: 'POST',
        headers: headers,
        data: data,
        url:baseURLApi+url
    }

    return await axios(options);
}

export const findStory = async (id) =>{
    const url = '/story/'+id;
    const options = {
        method: 'GET',
        headers: headers,
        data: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

export const fetchMyStories = async () =>{
    const url = '/fetch-my-story';
    const options = {
        method: 'GET',
        headers: headers,
        data: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

export const fetchStoriesHomepage = async () =>{
    const url = '/list-story-active';
    const options = {
        method: 'GET',
        headers: headers,
        data: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

export const softDeleteStory = async (id) =>{
    const url = '/story/soft-delete/'+id;
    const options = {
        method: 'DELETE',
        headers: headers,
        data: {},
        url:baseURLApi+url
    }

    return await axios(options);
}

export const forceDeleteStory = async (id) =>{
    const url = '/story/force-delete/'+id;
    const options = {
        method: 'DELETE',
        headers: headers,
        data: {},
        url:baseURLApi+url
    }

    return await axios(options);
}
