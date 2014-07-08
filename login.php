<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<?php
require_once('login_nav.php');
?>
<div class="container">

    <div class="row omb_row-sm-offset-3">
        <div class="col-xs-12 col-sm-6">	
            <form class="omb_loginForm" action="index.php" autocomplete="off" method="POST">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="username" placeholder="email address">
                </div>
                <span class="help-block"></span>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input  type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <span class="help-block" style="display:none">Password error</span>

                <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top:20px;">Login</button>
            </form>
        </div>
    </div>
    <div class="row omb_row-sm-offset-3">
        <div class="col-xs-12 col-sm-3">
            <label class="checkbox">
                <input type="checkbox" value="remember-me">Remember Me
            </label>
        </div>
        <div class="col-xs-12 col-sm-3">
            <p class="omb_forgotPwd">
                <a href="#">Forgot password?</a>
            </p>
        </div>
    </div>	    	
</div>