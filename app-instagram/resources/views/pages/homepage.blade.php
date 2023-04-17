@extends('layouts.main')
@section('pages.main-content')
<div class="d-flex content">
    <section id="main" class="content__left justify-content-end col-9">
      <div class="story-header d-flex mb-3">
        <div class="story-header__item mr-2">
          <div class="avatar active">
              <img src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg" alt="">
          </div>
          <div class="friend-name">thu_thao2</div>
        </div>

        <div class="story-header__item">
          <div class="avatar active">
              <img src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg" alt="">
          </div>
          <div class="friend-name">thu_thao2</div>
        </div>

        
      </div>
      <div class="list-post">
        <div class="list-post__items">
          <div class="item mb-2 bg-success">
            <div class="item__top">
              <div
                class="item-profile-box d-flex justify-content-between p-2 align-items-center"
              >
                <div class="item-profile d-flex align-items-center">
                  <div class="profile-avatar mr-2">
                    <img
                      src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg"
                      alt=""
                    />
                  </div>
                  <div class="profile-name">
                    <a href="./profile-following.html">marchland_official</a>
                  </div>
                </div>
                <div class="bars">...</div>
              </div>
            </div>
            <div class="item__content">
              <div class="content-photos">
                <div class="photos__gallery">
                  <img
                    width="100%"
                    src="https://images.unsplash.com/photo-1575936123452-b67c3203c357?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aW1hZ2V8ZW58MHx8MHx8&w=1000&q=80"
                    alt=""
                  />
                </div>
                <div class="photos__content p-2">
                  <div class="photos__icon d-flex">
                    <div class="icon__likes mr-3">
                      <i class="far fa-heart"></i>
                    </div>
                    <div class="icon-comment">
                      <i class="fa-regular fa-comment"></i>
                    </div>
                  </div>
                  <div class="photos__caption">
                    <span class="font-weight-bold"
                      >marchland_official</span
                    >
                    So beautiful...
                  </div>
                  <a href class="show-comment text-secondary">more</a>
                  <div class="photos__created-at text-secondary">
                    2 days ago
                  </div>

                  <div class="photos__comment mt-3">
                    <form action="">
                      <div class="form-group d-flex">
                        <input
                          type="text"
                          placeholder="Add a comment..."
                          name="comment"
                          class="form-control"
                          id=""
                        />
                        <button class="btn btn-light">Post</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="item__footer"></div>
          </div>

          <div class="item mb-2 bg-success">
            <div class="item__top">
              <div
                class="item-profile-box d-flex justify-content-between p-2 align-items-center"
              >
                <div class="item-profile d-flex align-items-center">
                  <div class="profile-avatar mr-2">
                    <img
                      src="https://upload.wikimedia.org/wikipedia/en/thumb/d/d6/Avatar_%282009_film%29_poster.jpg/220px-Avatar_%282009_film%29_poster.jpg"
                      alt=""
                    />
                  </div>
                  <div class="profile-name">
                    <a href="">marchland_official</a>
                  </div>
                </div>
                <div class="bars">...</div>
              </div>
            </div>
            <div class="item__content">
              <div class="content-photos">
                <div class="photos__gallery">
                  <img
                    width="100%"
                    src="https://images.unsplash.com/photo-1575936123452-b67c3203c357?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8aW1hZ2V8ZW58MHx8MHx8&w=1000&q=80"
                    alt=""
                  />
                </div>
                <div class="photos__content p-2">
                  <div class="photos__icon d-flex">
                    <div class="icon__likes mr-3">
                      <i class="far fa-heart"></i>
                    </div>
                    <div class="icon-comment">
                      <i class="fa-regular fa-comment"></i>
                    </div>
                  </div>
                  <div class="photos__caption">
                    <span class="font-weight-bold"
                      >marchland_official</span
                    >
                    So beautiful...
                  </div>
                  <a href class="show-comment text-secondary">more</a>
                  <div class="photos__created-at text-secondary">
                    2 days ago
                  </div>

                  <div class="photos__comment mt-3">
                    <form action="">
                      <div class="form-group d-flex">
                        <input
                          type="text"
                          placeholder="Add a comment..."
                          name="comment"
                          class="form-control"
                          id=""
                        />
                        <button class="btn btn-light">Post</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="item__footer"></div>
          </div>
        </div>
      </div>
    </section>
    <section id="content__right" class="content__right col-3 p-2">
      <div class="content__right-profile row mb-3">
        <div class="profile-left col-9 d-flex align-items-center">
          <a href="{{route('page.profile')}}" class="avatar mr-2">
              <img src="https://flxt.tmsimg.com/assets/194024_v9_bb.jpg" alt="">
          </a>
          <div class="switch">
            <div class="username">tranvhh</div>
            <span class="fullname text-secondary"
              >Tran Van Hoang Hiep</span
            >
          </div>
        </div>
        <a href="" class="profile-switch col-3"> Switch </a>
      </div>
      <div class="content__right-following mb-3">
        <div class="following-title row">
          <div class="col-6">Suggestions for you</div>
          <a href="" class="col-6">See All</a>
        </div>
        <ul class="following-list">
          <li><a href="" class="mr-2">tranthai123</a><span>Follow</span></li>
          <li><a href="" class="mr-2">tranthai123</a><span>Follow</span></li>
          <li><a href="" class="mr-2">tranthai123</a><span>Follow</span></li>
          <li><a href="" class="mr-2">tranthai123</a><span>Follow</span></li>
          <li><a href="" class="mr-2">tranthai123</a><span>Follow</span></li>
        </ul>
      </div>
      <div class="copy-right text-secondary">© 2023 INSTAGRAM FROM META</div>
    </section>
  </div>
  @endsection