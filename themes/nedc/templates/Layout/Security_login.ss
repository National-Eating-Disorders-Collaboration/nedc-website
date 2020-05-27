
	<main id="main-wrapper-page">
		<div id="loginRegister" class="grid">
		<% if $CurrentMember %>
			 <p>You are logged in. Redirecting to dashboard...</p>
			<script>
				setTimeout(function(){
					window.location.href = 'member/dashboard';
				}, 2000);
			</script>
		<% else %>
		<% if $Form %>
		<h1>Log in</h1>
		<figure class="attention">
			<p>IMPORTANT: We are migrating! If you are a current member of NEDC, please create <a href="Security/Lostpassword">new password</a> to update your profile.</p>
		</figure>
		<br>
		$Content
		$Form
<%-- 			<form $Form.AttributesHTML>
				<span>$Message</span>
				$Form.Fields.fieldByName(AuthenticationMethod)
				<label>Your Email$Form.Fields.fieldByName(Email)</label>
				<label>Password $Form.Fields.fieldByName(Password)</label>
				<div class="flexCheck">
					<label>$Form.Fields.fieldByName(Remember)Remember me</label>
					<div>
						$Form.Actions.fieldByName(action_dologin)
						<a class="forgot" href="/Security/lostpassword" title="">Forgot your username or password?</a>
					</div>
					$Form.Fields.fieldByName(SecurityID)
					$Form.Fields.fieldByName(BackURL)
				</div>
			</form> --%>
			<span>Don’t have an account?<a href="register" title="">Sign up</a></span>
		<% end_if %>
		<% end_if %>
		</div>
	</main>
