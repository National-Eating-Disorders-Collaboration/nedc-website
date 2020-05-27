	<div id="login" class="modal_box">
		<div id="loginRegister">
			<div class="title">
				<h2>Login to register</h2>
				<a class="modal_close"><i class="fa fa-close"></i></a>
			</div>
			<% if $LoginForm %>
				<form $LoginForm.AttributesHTML>
					$LoginForm.Fields.fieldByName(AuthenticationMethod)
					<label>Your Email$LoginForm.Fields.fieldByName(Email)</label>
					<label>Password $LoginForm.Fields.fieldByName(Password)</label>
					<div class="flexCheck">
						<label>$LoginForm.Fields.fieldByName(Remember)Remember me</label>
						<div>
							$LoginForm.Actions.fieldByName(action_dologin)
							<a class="forgot" href="/Security/lostpassword" title="">Forgot your username or password?</a>
						</div>
						$LoginForm.Fields.fieldByName(SecurityID)
						<% if $Success %>
							$LoginForm.Fields.fieldByName(BackURL)
						<% end_if %>
					</div>
					<p>Don’t have an account?<a href="register" style="color: #3AACD9;" title="" > Sign up</a></p>
				</form>
			<% end_if %>
		</div>
	</div>
