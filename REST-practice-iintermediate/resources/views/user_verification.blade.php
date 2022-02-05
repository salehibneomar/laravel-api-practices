<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>User Verification</title>
  </head>
  <body>
    
    <div style="margin-top: 20px; text-align: center !important;">
        <h3 class="w-100">Hello, {{ $name }}</h3>
        <a href="{{ route('user.verify', ['token'=>$token]) }}" >Verify</a>
    </div>

  </body>
</html>
