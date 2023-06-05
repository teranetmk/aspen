<form name="loginform" id="loginform" class="loginform" method="post" action="<?= home_url('wp-login.php') ?>">
	<p class="login-username">
		<label for="user_login">Email <span class="star_required">*</span></label>
		<input type="text" name="log" id="user_login" class="input" value="" size="20">
	</p>
	<p class="login-password">
		<label for="user_pass">Password <span class="star_required">*</span></label>
		<input type="password" name="pwd" id="user_pass" class="input" value="" size="20">
	</p>

    <p class="trouble"><a href="https://community.aspenrxhealth.com/help" target="_blank">Trouble logging in?</a></p>
	
	<p class="login-submit">
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary" value="Login">
		<input type="hidden" name="redirect_to" value="<?= home_url() ?>">
	</p>

	<p class="register">Not a member?<br><a href="https://community.aspenrxhealth.com/register" target="_blank">Create an account</a></p>
</form>

<style>
.loginform {
    padding-left: 5%;
    padding-right: 5%;
}
.loginform label {
	float:left;
	font-size:12px;
	margin-top:28px;
	margin-bottom:12px;
}
.loginform span.star_required {
    color: #E24444;
}
.loginform input {
	width:100%;
	border-radius:10px;
	padding:10px;
	border: solid 1px #C2C5C6;
}
.loginform .trouble {
	text-align: right;
    margin-top: 16px;
    margin-bottom: 16px;
}
.loginform .trouble a {
    color: #e24444;
	font-size:14px;
	font-weight:500;
}

.loginform input[type="submit"] {
    background: #328FCE;
    color: #ffffff;
    border: none;
    border-radius: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
    font-size: 18px;
    font-weight: 500;
}
.loginform .register {
	font-size:18px;
	font-weight:700;
	margin-top:30px;
	color:#55595f;
}
</style>
