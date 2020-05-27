
	<main id="main-wrapper-page">
		<ul id="breadcrumb" class="grid">
			<li><a href="$BaseHref"></a></li>
			<% loop $Breadcrumbs %>
			    <li><a href="$Link">$Title</a></li>
			<% end_loop %>
		</ul>
		<%-- $ShareEventForm --%>
		<div id="professionalShare" class="grid">
			<div class="inner">
				<h1>$Title</h1>
				<div class="editor-content">
					$Content
				</div>
				<% if $CurrentMember %> 
				<% if $ShareStudiesForm %>
				<div class="share_event_tabs">
					<%-- <ul class="tab" id="share_event_tabs">
						<li class="tab-link active" data-tab="tab-1">Case study Details</li>
					</ul> --%>

					<form $ShareStudiesForm.AttributesHTML >
						<%-- Temporary Fields --%>
						<% control $ShareStudiesForm %>
							<% loop $Fields %>
							    <% if Message %>
						     		<p id="Form_ShareStudiesForm_error" class="message $MessageType" style="color: red;">$Message</p>
						  		<% else %>
						      		<p id="Form_ShareStudiesForm_error" class="message $MessageType"  style="display: none; color: red;"></p>
							    <% end_if %>
							<% end_loop %>
						<% end_control %>

						<div class="tab-content  current" id="tab-1">
							<span>$Message</span>
							<label>Title of Study<br>$ShareStudiesForm.Fields.fieldByName(Title)</label>
							<label>Research Team<br>$ShareStudiesForm.Fields.fieldByName(Author)</label>

							<label>Institution<br>$ShareStudiesForm.Fields.fieldByName(Institution)</label>

							<label>Case Study Type<br>$ShareStudiesForm.Fields.fieldByName(Category)</label>
							<label>Ethics Approval Number<br>$ShareStudiesForm.Fields.fieldByName(EthicsApprovalNumber)</label>
							<%-- <h4>Case Study Category</h4>
							<div class="check">
								<div class="checkLeft">
								$ShareStudiesForm.Fields.fieldByName(Category)
								</div>
							</div> --%>
							<div class="flex">
								<label>Project Start Date<br>$ShareStudiesForm.Fields.fieldByName(ProjectStartDate)</label>
								<label>Project End Date<br>$ShareStudiesForm.Fields.fieldByName(ProjectEndDate)</label>
							</div>
							<label>Funding Source<br>$ShareStudiesForm.Fields.fieldByName(FundingSource)</label>
							<label>Location<br>$ShareStudiesForm.Fields.fieldByName(Location)</label>
							<label>ContactDetails<br>$ShareStudiesForm.Fields.fieldByName(ContactDetails)</label>

							<label>Description<br>$ShareStudiesForm.Fields.fieldByName(Description)</label>
							<label>Participants<br>$ShareStudiesForm.Fields.fieldByName(Participants)</label>
							<label>Whats Involved<br>$ShareStudiesForm.Fields.fieldByName(WhatsInvolved)</label>

							<% with $ShareStudiesForm.Fields.fieldByName(File) %>
								$FieldHolder
							<% end_with %>
							<br>
							$ShareStudiesForm.Fields.fieldByName(SecurityID)
							$ShareStudiesForm.Actions.fieldByName(action_submit)
						</div>

					</form>
				</div>
				<% else %>
					$Content
				<% end_if %>
				<% else %>
				<p>Please login in order to share your studies.</p>
				<a href="Security/Login">Login</a>
				<% end_if %>
			</div>
		</div>
	</main>
