<!DOCTYPE html>
<html lang="en">
<head>
    @include('blocks.head')
    @yield('style')
</head>
  <body>
    <div class="web-wrapper row">
      <!-- sidebar menu -->
      <aside class="sidebar-menu col-3 bg-info">
        <div class="logo">
          <a href="">Instagram</a>
        </div>
        <ul class="nav-menu">
          <li><a href="{{route('page.home')}}"><i class="fas fa-home-alt"></i>Home</a></li>
          <li><a href=""><i class="fas fa-search"></i>Search</a></li>
          <li><a href="">Explore</a></li>
          <li><a href=""><i class="fab fa-facebook-messenger"></i>Message</a></li>
          <li><a href=""><i class="far fa-heart"></i>Notification</a></li>
          <li><a href="{{route('page.profile')}}">Profile</a></li>
        </ul>
      </aside>
      <!-- main content insta -->
      <main class="page-content col-9" style="position: absolute; right: 0; top: 0;">
        @yield('pages.main-content')
      </main>
    </div>

    {{-- script js link --}}
    @include('blocks.head')
  </body>
</html>
