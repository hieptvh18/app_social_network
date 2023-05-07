
<template>
 <div class="content-form-edit-profile p-4">
    <form action="" method="POST">
        <div class="avatar">
            <div class="box-avatar">
                <img src="https://aem.dropbox.com/cms/content/dam/dropbox/warp/en-us/developers/tech-research-lab.svg" alt="">
            </div>
        </div>
        <div class="username">
            <span>tranvhh</span>
            <a href="">Change profile photo</a>
        </div>

        <div class="form-group d-flex">
            <label for="" class="col-1">Name</label>
            <div class="ml-3">
                <input type="text" name="name" disabled class="form-control-sm" value="Tran Van Hoang Hiep">
                <br>
                <small>You are using the same name on Instagram and Facebook. Go to Facebook to change your name. Change Name
                </small>
            </div>
        </div>

        <div class="form-group d-flex">
            <label for="" class="col-1">Username</label>
            <div class="ml-3">
                <input type="text" name="username" class="form-control-sm" value="Tran Van Hoang Hiep">
                <br>
                <small>In most cases, you'll be able to change your username back to tranvhh for another 14 days.
                </small>
            </div>
        </div>

        <div class="form-group d-flex">
            <label for="" class="col-1">Bio</label>
            <div class="ml-3">
                <textarea name="bio" id="" cols="30" rows="4" class="form-con"></textarea>
                <br>
                <small>In most cases, you'll be able to change your username back to tranvhh for another 14 days.
                </small>
            </div>
        </div>

        <div class="form-group d-flex">
            <label for="" class="col-1">Email</label>
            <div class="ml-3">
                <input type="email" name="email" class="form-control-sm" value="hiep@gmail.com">        
            </div>
        </div>

        <div class="form-group d-flex">
            <label for="" class="col-1">Phone</label>
            <div class="ml-3">
                <input type="text" name="phone" class="form-control-sm" value="0921312313">        
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div class="text-secondary">© 2023 Instagram from Meta</div>
</div>
</template>

<script>
    import Index from './index.css';
    export default {
      components:{Index}
    }
</script>