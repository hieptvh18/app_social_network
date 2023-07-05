<template>
    <div>
      <div >
        <p>Upload an image to Firebase:</p>
        <input type="file" @change="previewImage" accept="image/*" >                
      </div>
      <div>
        <p>Progress: {{uploadValue.toFixed()+"%"}}
        <progress id="progress" :value="uploadValue" max="100" ></progress>  </p>
      </div>
      <div v-if="imageData!=null">                     
          <img class="preview" :src="picture">
          <br>
        <button @click="onUpload">Upload</button>
      </div>   
    </div>
  </template>
<style scoped="">
img.preview {
    width: 200px;
}
 
</style>
<script>
import { getStorage, ref, uploadBytesResumable, uploadBytes,getDownloadURL  } from "firebase/storage";

export default {
  name: 'Upload',
  data(){	  
	return{
      imageData: null,  
      picture: null,
      uploadValue: 0
	}
  },
  methods:{
    previewImage(event) {
      this.uploadValue=0;
      this.picture=null;
      this.imageData = event.target.files[0];
    },
 
    onUpload() {
        const file = this.imageData;
        const storage = getStorage();
        const storageRef = ref(storage, 'posts/' + file.name);
        const uploadTask = uploadBytesResumable(storageRef, file);

        uploadTask.on('state_changed', 
            (snapshot) => {
                // Get task progress, including the number of bytes uploaded and the total number of bytes to be uploaded
                const progress = (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
                this.uploadValue = progress;

                switch (snapshot.state) {
                    case 'paused':
                        console.log('Upload is paused');
                        break;
                    case 'running':
                        console.log('Upload is running');
                        break;
                }
            }, 
            (error) => {
                // Handle unsuccessful uploads
            }, 
            () => {
                // For instance, get the download URL: https://firebasestorage.googleapis.com/...
                getDownloadURL(uploadTask.snapshot.ref).then((downloadURL) => {
                    this.picture = downloadURL;
                    // save url image to database
                });
            }
        );
    }
  
  }
}
</script>