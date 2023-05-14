<template>
  <span class="" data-toggle="modal" data-target="#modalCreatePost">
    Create Post
  </span>

  <!-- Modal -->
  <div class="modal fade" id="modalCreatePost" tabindex="-1" role="dialog" aria-labelledby="modalCreatePost" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCreatePost">Create new post</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Drag photos and videos here
          <!-- view photos uploading -->
          <div id="uploading">
            <input
            type="file"
            multiple
            accept="image/jpeg"
            @change="onFileChange"
            />

            <div v-for="(image, key) in images" :key="key">
              <div>
                <img class="preview" :ref="'image'" />
                {{ image.name }}
              </div>
            </div>
          </div>
          
          <!-- <div class="view-photos"></div>
          <label for="apply">
            <input type="file" name="" id="apply" accept="image/*,.pdf" multiple>
            Upload
          </label> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Next</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// import Vue from 'vue';
import Index from './index.css';



export default {
  name:'',
  components:Index,
  data(){
    return{
      onFileChange:function(e){
          console.log('change input')
      }
    }
  }
};

</script>