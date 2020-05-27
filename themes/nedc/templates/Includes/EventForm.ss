	<div id="eventForm" class="modal_box" style="">
		<div id="professionalShare">
			<div class="title">
				<h3>Register to this event</h3>
				<a class="modal_close"><i class="fa fa-close"></i></a>
			</div>
			<%-- $EventRegistrationForm --%>
			<form $EventRegistrationForm.AttributesHTML >
				$EventRegistrationForm.Fields.fieldByName(EventID)
				<div class="flex">
					<label>First Name *$EventRegistrationForm.Fields.fieldByName(FirstName)</label>
					<label>Surname * $EventRegistrationForm.Fields.fieldByName(Surname)</label>
				</div>
				<div class="flex">
					<label>Email Address *$EventRegistrationForm.Fields.fieldByName(Email)</label>
					<label>Organisation * $EventRegistrationForm.Fields.fieldByName(Organisation)</label>
				</div>
				<div class="flex">
					<label>City/Post code * $EventRegistrationForm.Fields.fieldByName(PostCode)</label>
					<label>State * $EventRegistrationForm.Fields.fieldByName(State)</label>
				</div>

				<label>Which session(s) are you interested in attending? (tick all applicable)" *$EventRegistrationForm.Fields.fieldByName(ChooseSession)</label>
				<label>Please specify any food or/and accessibility requirements you may have" * $EventRegistrationForm.Fields.fieldByName(FoodRequirements)</label>
				$EventRegistrationForm.Fields.fieldByName(SecurityID)
				$EventRegistrationForm.Actions.fieldByName(action_submitRegistration)
			</form>
		</div>
	</div>
