
	<main id="main-wrapper-page">
		<% include HomepageCarousel %>
		<% include HomePageBlocks %>
		<div id="eventNews">
			<div class="grid">
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
						<% if $LatestEvents %>
						    <% loop $LatestEvents %>
						    	<div class="time">
									<div>
										<a href="$Link">$Title</a>
										<% if not $Category %>
											<span>$OtherType</span>
											<% else %>
											<span>$Category</span>
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
						<p>No upcoming events.</p>
						<% end_if %>
					</div>
					<div class="event-form">
						$EventForm
					</div>
				</div>
				<% if News %>
				<div class="news">
					<h5>Latest News</h5>
					    <% loop News.Limit(3) %>
					        <div class="notice">
								<p><a href="$Link">$Title</a></p>
								<span>$Categories</span>
								<span>$Created.Long</span>
							</div>
					    <% end_loop %>
					<a class="more" href="news/" title="">View All News</a>
				</div>
				<% end_if %>
			</div>
		</div>
	</main>
