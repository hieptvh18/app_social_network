import Instance from "./instance";
import axios from "axios";
import { header,baseURLApi } from "./instance";

// get data current user login
export const getListPostByFollowing = async () =>{
    const url = '/posts/get_by_following';
    const options = {
        method: 'GET',
        headers: header,
        data: {},
        url:baseURLApi+url
    }
   
    return await axios(options);
}
