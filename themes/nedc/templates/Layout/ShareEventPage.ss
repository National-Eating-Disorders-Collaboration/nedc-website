
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
				<%-- $ShareEventForm --%>

				<% if $ShareEventForm %>
				<div class="share_event_tabs">
					<ul class="tab" id="share_event_tabs">
						<li class="tab-link active" data-tab="tab-1">1. Event Details</li>
						<li class="tab-link" data-tab="tab-2">2. When & Where</li>
						<li class="tab-link" data-tab="tab-4">3. Upload Files</li>
					</ul>

					<form $ShareEventForm.AttributesHTML novalidate >
						<%-- Temporary Fields --%>
						<% control $ShareEventForm %>
							<% loop $Fields %>
							    <% if Message %>
						     		<p id="Form_ShareEventForm_error" class="message $MessageType" style="color: red;">$Message</p>
						  		<% else %>
						      		<p id="Form_ShareEventForm_error" class="message $MessageType"  style="display: none; color: red;"></p>
							    <% end_if %>
							<% end_loop %>
						<% end_control %>

						<div class="tab-content  current" id="tab-1">
							<span>$Message</span>
							<div class="flex">
								<label>Organization *<br>$ShareEventForm.Fields.fieldByName(Organization)</label>
								<label>Speaker's Name *<br>$ShareEventForm.Fields.fieldByName(Name)</label>
							</div>
							<div class="flex">
								<label>Position<br>$ShareEventForm.Fields.fieldByName(Position)</label>
								<label>Company<br>$ShareEventForm.Fields.fieldByName(Company)</label>
							</div>

							<label>Title of Event *<br>$ShareEventForm.Fields.fieldByName(Title)</label>
							<label>Description *<br>$ShareEventForm.Fields.fieldByName(About)</label>
							<label>Event Audience *<br>$ShareEventForm.Fields.fieldByName(EventAudience)</label>
							<label>Requirements<br>$ShareEventForm.Fields.fieldByName(Requirements)</label>

							<h4>Event Category</h4>
							<div class="check">
								<div class="checkLeft">
								$ShareEventForm.Fields.fieldByName(Category)
								</div>
							</div>

							<div class="other-type">
								<label>Other (Please Specify)<br>$ShareEventForm.Fields.fieldByName(Other)</label>
							</div>

							<div class="flex">
								<label>Free or Paid Event * <br>$ShareEventForm.Fields.fieldByName(FreeOrPaid)</label>
								<label>Ticket Price<br>$ShareEventForm.Fields.fieldByName(Price)</label>
							</div>
							<label>Payment/Registration Form *<br>$ShareEventForm.Fields.fieldByName(ExternalForm)</label>
							<div class="flex">
								<label>Contact Person*<br>$ShareEventForm.Fields.fieldByName(ContactPerson)</label>
								<label>Contact Number *<br>$ShareEventForm.Fields.fieldByName(Contact)</label>
								<label>Contact Email Address *<br>$ShareEventForm.Fields.fieldByName(Email)</label>
							</div>
							<a class="js__next_tab">Next</a>
						</div>

						<%-- Where and When --%>
						<div class="tab-content " id="tab-2">
							<div class="flex">
								<label>Address *<br>$ShareEventForm.Fields.fieldByName(Address)</label>
								<label>State *<br>$ShareEventForm.Fields.fieldByName(State)</label>
							</div>

							<a class="clone"><span>Add Date <i class="fa fa-plus"></i></span></a>

							<div id="date" class="clone_input">
								<a class="remove"><span>Remove</span></a>
								<div class="flex ">
									<label>Date of your Event *<br>$ShareEventForm.Fields.fieldByName(Date[])</label>
									<label>Start Time <br>$ShareEventForm.Fields.fieldByName(StartTime[])</label>
									<label>End Time<br>$ShareEventForm.Fields.fieldByName(EndTime[])</label>
								</div>
							</div>

							<a class="js__next_tab">Next</a>
						</div>
						<%-- Sponsors --%>
						<div class="tab-content " id="tab-4">
							<% with $ShareEventForm.Fields.fieldByName(Images) %>
							    $FieldHolder
							<% end_with %>
							<br>
							<% with $ShareEventForm.Fields.fieldByName(File) %>
								$FieldHolder
							<% end_with %>
							<br>
							$ShareEventForm.Fields.fieldByName(SecurityID)
							$ShareEventForm.Actions.fieldByName(action_submit)
						</div>
					</form>
				</div>
				<% else %>
					$Content
				<% end_if %>
			</div>
		</div>
	</main>
