@extends('layouts.main')

@section('style')
<link rel="stylesheet" href="{{asset('assets/css/profile.css')}}">
@endsection

@section('pages.main-content')
<div class="profile m-5">
    <div class="content-profile d-flex align-items-center">
        <div class="content-profile__img">
            <img src="https://aem.dropbox.com/cms/content/dam/dropbox/warp/en-us/developers/tech-research-lab.svg" alt="">
        </div>
        <div class="content-profile-main ml-4">
            <div class="content-profile-top d-inline">
                <span class="name mr-3">tranvhh</span>
                <button class="btn btn-light mr-3"><a href="{{route('page.edit-profile','tvhh')}}">Edit profile</a></button>
                <button><i class="fa fa-cog"></i></button>
            </div>
            <div class="content-profile-count d-flex mb-3">
                <span class="count-post mr-3"><span class="font-weight-bold">1</span> post</span>
                <div class="count-follower mr-3"><span class="font-weight-bold">133</span> followers</div>
                <div class="count-following"><span class="font-weight-bold">133</span> following</div>
            </div>
            <div class="content-profile-fullname">
                <span>Tran Hoang Hiep</span>
                <span>hihi...</span>
            </div>
        </div>
    </div>
    <div class="content-stories mt-5 pb-5">
        <div class="story-headers d-flex mb-3">
            <div class="story-headers__item mr-4">
              <div class="avatar active">
                  <img src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg" alt="">
              </div>
              <div class="story-name">thu_thao2</div>
            </div>

            <div class="story-headers__item mr-4">
              <div class="avatar active">
                  <img src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg" alt="">
              </div>
              <div class="story-name">thu_thao2</div>
            </div>

            <!-- add new story -->
            <div class="story-headers__item text-center">
                <div class="avatar add-new d-flex justify-content-center align-items-center">
                    <i class="fa-solid fa-plus"></i>
                </div>
                <div class="story-name font-weight-bold">new</div>
              </div>
            
          </div>
    </div>
    <div class="content-gallery">
        <div class="gallery__header">Posts</div>
        <div class="gallery__items d-flex">
            <div class="gallery__item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQj0P5UaXPM-iOOHh9o9JrktCiqXnfpzlCsqA&usqp=CAU" alt="">
            </div>
            <div class="gallery__item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQj0P5UaXPM-iOOHh9o9JrktCiqXnfpzlCsqA&usqp=CAU" alt="">
            </div>
        </div>
    </div>
</div>
@endsection