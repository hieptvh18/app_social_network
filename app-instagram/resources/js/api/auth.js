import Instance from "./instance";

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

export const logout = () =>{
    let url = 'accounts/logout';
    return Instance.get(url);
}