<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Instagram</title>
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">
    <!-- fontawesome cnd -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
<div id="wrapper">
    <div class="main-content">
      <div class="header">
        <img src="{{asset('assets/images/Instagram_logo.svg.png')}}" />
      </div>
      <div class="l-part">
        <input type="text" placeholder="Username" class="input-1" />
        <div class="overlap-text">
          <input type="password" placeholder="Password" class="input-2" />
          <a href="#">Forgot?</a>
        </div>
        <input type="button" value="Log in" class="btn" />
        
        <button style="margin-top: 5px;" class="btn"><i class="fab fa-facebook-square"></i> Log in with Facebook</button>
      </div>
    </div>
    <div class="sub-content">
      <div class="s-part">
        Don't have an account?<a href="{{route('register')}}">Sign up</a>
      </div>
    </div>
  </div>

</body>
</html>