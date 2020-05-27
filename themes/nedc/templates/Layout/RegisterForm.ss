
		<main id="main-wrapper-page">
			<div id="loginRegister" class="grid">

			<% if CurrentMember %>
			    <h3>Your are already signed in, go to <a href="member/dashboard">Dashboard</a></h3>

			    <script>
					setTimeout(function(){
						window.location.href = 'member/dashboard';
					}, 2000);
				</script>
				<% else %>
				<%-- $RegisterForm --%>
				<% if RegisterForm %>
					<form $RegisterForm.AttributesHTML>
						<h1>$Title</h1>
						<% loop $RegisterForm %>
							<% loop $Fields %>
							    <% if Message %>
						     		<p id="Form_RegisterForm_error" class="message $MessageType" style="color: red;">$Message</p>
						  		<% else %>
						      		<p id="Form_RegisterForm_error" class="message $MessageType"  style="display: none; color: red;"></p>
							    <% end_if %>
							<% end_loop %>
						<% end_loop %>

						<div class="flexInput">
							<label>First Name* $RegisterForm.Fields.fieldByName(FirstName)</label>
							<label>Last Name*$RegisterForm.Fields.fieldByName(Surname)</label>
						</div>
						<div class="flexInput">
							<label>Age $RegisterForm.Fields.fieldByName(AgeGroupID)</label>
							<label>Gender $RegisterForm.Fields.fieldByName(Gender)</label>
						</div>
						<div class="flexInput">
							<label>Username*$RegisterForm.Fields.fieldByName(Username)</label>
							<label>Password*$RegisterForm.Fields.fieldByName(Password)</label>
						</div>

						<div class="flexInput">
							<label>Your Email*$RegisterForm.Fields.fieldByName(Email)</label>
							<label>Choose Your Postcode*$RegisterForm.Fields.fieldByName(Postcode)</label>

						</div>

						<div class="hide js-postcode-autocomplete">
							$RegisterForm.Fields.fieldByName(City)
							$RegisterForm.Fields.fieldByName(State)
							$RegisterForm.Fields.fieldByName(Country)
						</div>

						<div class="other-profession">
							<label>What is Your Profession?* $RegisterForm.Fields.fieldByName(ProfessionID)</label>
							<label class="other hide">Please specify $RegisterForm.Fields.fieldByName(OtherProfession)</label>
						</div>

						<label>What area do you work in?* $RegisterForm.Fields.fieldByName(ProfessionGroupID)</label>
						<div class="other-interest">
							<label>What interests you in becoming a member of NEDC? $RegisterForm.Fields.fieldByName(InterestID)</label>
							<label class="other hide ">Please specify $RegisterForm.Fields.fieldByName(OtherInterest)</label>
						</div>

						<div class="flexInput">
							<label>$RegisterForm.fields.fieldByName(Captcha).Title *
									$RegisterForm.fields.fieldByName(Captcha)
							</label>
						</div>

						<div class="flexCheck">
							<label>$RegisterForm.Fields.fieldByName(TNC)I agree to Terms & Conditions</label>
							<div>
								$RegisterForm.Actions.fieldByName(action_register)
							</div>
						</div>
						$RegisterForm.Fields.fieldByName(SecurityID)





						<span>Have an account?<a href="Security/login" title="">Log in</a></span>
					</form>
					<% else %>
				  	$Content
					<script>
						setTimeout(function(){
							window.location.href = 'Security/Login';
						}, 5000);
					</script>

				<% end_if %>
			<% end_if %>
			</div>
		</main>
