
<html>
    <body>
		<div style="background-color: #F2F2F2; margin: 0 auto; width: 90%;">
			<div style="width: 100%; margin: 0 auto; height: 90px; background-color:#fff;">
				<img style="max-height: 70px; width: auto; float: left; margin-left: 9px;" src="$BaseHref/themes/nedc/img/logolr.png"/>
			</div>

			<div style="padding: 5%">
		
                <p><%t ForgotPasswordEmail_ss.HELLO 'Hi' %> $FirstName,</p>

                <p><%t ForgotPasswordEmail_ss.TEXT1 'Here is your' %> <a href="$PasswordResetLink"><%t ForgotPasswordEmail_ss.TEXT2 'password reset link' %></a> <%t ForgotPasswordEmail_ss.TEXT3 'for' %> $AbsoluteBaseURL.</p>

                <p>Thanks,</p>
				<p>NEDC Admin</p>

			</div>

		</div>
    </body>
</html>
