import Vue from "vue";

const previewImg = () => {
    new Vue({
        el: "#uploading",
        data: {
            images: [],
        },
        methods: {
            onFileChange(e) {
                let vm = this;
                var selectedFiles = e.target.files;
                for (let i = 0; i < selectedFiles.length; i++) {
                    console.log(selectedFiles[i]);
                    this.images.push(selectedFiles[i]);
                }

                for (let i = 0; i < this.images.length; i++) {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        this.$refs.image[i].src = reader.result;

                        console.log(this.$refs.image[i].src);
                    };

                    reader.readAsDataURL(this.images[i]);
                }
            },
        },
    });
};
export default previewImg;
