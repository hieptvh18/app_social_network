import {
    getStorage,
    ref as refFirebase,
    uploadBytes,
    getDownloadURL,
} from "firebase/storage";


export const validateUsername = (username) => {
    if(!username) return false;

    let usernamePattern = /^\w{4,14}$/; // not space, 4-14 character
    if (!usernamePattern.test(username)) {
        return false;
    }

    return true;
};

export const validateEmail = (email)=>{
    if(!email) return false;
    
    let emailPattern =/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;

    if(!emailPattern.test(email)) {
        return false
    }

    return true
};

export const validatePhoneNumber = (phone)=>{
    if(phone){
        let phoneParttern = /(((\+|)84)|0)(3|5|7|8|9)+([0-9]{8}$)\b/;
        if(!phoneParttern.test(phone)){
            return false
        }
    }
    return true;
}

// upload image to firebase storage
export const uploadingToCloud = (file) => {
    const storage = getStorage();
    const storageRef = refFirebase(storage, "stories/" + file.name);
    const uploadTask2 = uploadBytes(storageRef, file);

    return new Promise((resolve, reject) => {
        uploadTask2.then((snapshot) => {
            getDownloadURL(snapshot.ref).then((downloadURL) => {
                let imageUrl = downloadURL;
                // save success-> re load component page
                resolve(imageUrl);
            });
        })
        .catch(er=>{
            console.log('error when uploading to firebase storage');
            reject(er);
        });
    });
}
