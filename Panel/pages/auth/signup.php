<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create new account</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../../assets/css/signup.css">
</head>
<body>
    <!-- <div class="" style="position: absolute;top: 0;left: 0;z-index: -1;background-color: black;width: 100%;height: 100%;opacity: 0.5;"></div> -->
    <div class="registration-form">
        <form action="/api/auth/signup.php" method="POST">
            <div class="form-icon">
                <span><i class="icon icon-user"></i></span>
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="username" id="username" placeholder="Username">
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="text" class="form-control item" name="phone" id="phone" placeholder="Phone Number">
            </div>
            <div class="form-group">
                <input type="password" class="form-control item" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control item" name="confirm_password" id="confirm_password" placeholder="Confirm Password">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-block create-account">Create Account</button>
            </div>

            <div class="d-flex flex-row align-items-center mt-5 px-3">
                <div class="text-white">If you have an account?</div>
                <a href="/" class="ml-auto" style="color: #FFEE58;cursor: pointer;">Sign in here</a>
            </div>
        </form>
        
    </div>
    <script type="text/javascript" src="../../assets/js/jquery-3.5.1.js"></script>
</body>
</html>