	<main id="main-wrapper-page">
		<% include BreadCrumbs %>

		<div id="professional">
			<div class="grid">
				<h1>$Title</h1>
				<div class="slider">
					<% include Carousel %>
						
					<% if BecomeMember %>
					    <% with BecomeMember %>
					        <% include BecomeMemberBox %>
					    <% end_with %>
					<% end_if %>
				</div>
				<div class="editor-content">
					$Content
				</div>
				<div class="upcoming">
					<div class="events">
						<h2>Upcoming events in
							<select name="State" id="au_states" >
								<option value="" selected="selected">Australia</option>
								<option value="1">NSW</option>
								<option value="2">QLD</option>
								<option value="3">SA</option>
								<option value="4">TAS</option>
								<option value="5">VIC</option>
								<option value="6">WA</option>
								<option value="7">ACT</option>
								<option value="8">NT</option>
							</select>
						</h2>
						<div class="wrap">
							<% if Results %>
							    <% loop Results %>
							    	<div class="time">
										<div>
											<a href="$Link">$Title</a>
											<% if $Category %>
											    <span>$Category</span>
											<% else %>
												<% if $OtherType %>
											    	<span>$OtherType</span>
												<% end_if %>
											<% end_if %>
										</div>
										
										<% if $getCount <= 1 %>
											<% loop $getDates %>
												<div class="dates-one"><span>$Month</span><span>$Day</span></div>
											<% end_loop %>
											<% else %>
											<div class="dates-more">
												<% loop $getDates %>
													<dl>
														<dt>$Day</dt>
														<dd>$Month</dd>
													</dl>
												<% end_loop %>
											</div>
										<% end_if %>
									</div>
							    <% end_loop %>
							   <% else %>
							   <p>No Results.</p>
							<% end_if %>
						</div>
						<div class="event-form">
							$EventForm
						</div>
					</div>
					<% if SideBlocks %>
					<aside>
					<% loop SideBlocks %>
						<h3>$Title</h3>
						<p>$Description</p>
						<% if Link %>
						    <% with Link %>
						        <a class="btn" href="$LinkURL" title="">$Title</a>
						    <% end_with %>
						<% end_if %>
						<% if not Last %>
						    <br><hr><br>
						<% end_if %>
					<% end_loop %>
					</aside>
					<% end_if %>
				</div>
			</div>
			<% include SeeAlsoSections %>
		</div>
	</main>
