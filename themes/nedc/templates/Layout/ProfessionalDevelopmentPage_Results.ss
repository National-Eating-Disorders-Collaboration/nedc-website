
	<main id="main-wrapper-page">
		<% include BreadCrumbs %>
		<% loop getParam %>
		    <p>$getParam</p>
		<% end_loop %>
		<div id="professionalEvent">
			<div class="grid">
				<h1>Upcoming events in
					<select name="State" id="au_states_events" >
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
				</h1>
				<div class="slider">
					<% include Carousel %>
					<% if $getLatestEvent %>
						    <% loop $getLatestEvent %>
								<div class="tagEvent">
									<div class="flex">
										<div>
											<% if $isOwn %>
												<span>NEDC Event</span>
											<% end_if %>
											<h2><a href="$Link">$Title</a></h2>
										</div>
										<div>
											<span>$Month</span>
											<span>$Day</span>
										</div>
									</div>
									<p>$About.FirstSentence</p>
								</div>
				   		<% end_loop %>
					<% end_if %>
				</div>
				<div class="filter">
					<span>Filter by</span>
					<a class="sort_by" data-url="all" >All Events</a>
					<a class="sort_by" data-url="nedc" >NEDC Events</a>
					<a class="sort_by" data-url="other" >Other</a>
				</div>
				<div class="wrapEvent">
					<div>
						<% if Results %>
						<% loop Results %>
							<div class="event">
								<div>
									<% if isOwn %>
									   <span>NEDC Event</span>
									<% end_if %>
									<h3>$Title</h3>
									<p class="state">
										<% if State %>
									    	<% loop State %>
									        	$Title <% if Last %> <% else %>,<% end_if %>
									    	<% end_loop %>
										<% end_if %>
									</p>
									<p>$About.LimitWordCount(20)</p>
									<a class="arrow" href="$Link" title="">Read more</a>
								</div>
								<div>
									<p>$Address</p>
									<% if EventTimeDate %>
									    <% loop EventTimeDate.limit(3) %>
											<p class="time">$Date.Long
												<br>
												$StartTime.Nice - $EndTime.Nice
											</p>
									    <% end_loop %>
									    <a href="$Link" title="">View all </a>
									<% end_if %>
								</div>
							</div>
						<% end_loop %>
						<% else %>
							<p>No Results.</p>
						<% end_if %>
						<% include Pagination %>
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
		</div>
	</main>
