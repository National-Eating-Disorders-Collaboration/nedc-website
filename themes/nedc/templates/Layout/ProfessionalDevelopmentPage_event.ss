

	<main id="main-wrapper-page">
		<% include BreadCrumbs %>
		<% with $Event %>

		<div id="professionalDetail">
			<div class="grid">
				<div class="flex">
					<div class="noDesktop">
						<% if $isOwn %>
						    <span class="tag">NEDC Event</span>
						<% end_if %>
						<h1>$Title</h1>
					</div>
					<div class="wrapper">
						<div class="info">
							<% if $isOwn %>
						   		<span class="tag">NEDC Event</span>
							<% end_if %>
							<h1>$Title</h1>
							<% if $Image %>
							    <% with Image %>
							        <img src="$URL" alt="">
							    <% end_with %>
							<% end_if %>
							<% if $About %>
							    <h3>About this event</h3>
								<p>$About</p>
							<% end_if %>
							<% if $Requirements %>
							<br>
							<hr>
							<br>
							    <h3>Requirement</h3>
								<p>$Requirements</p>
							<% end_if %>
							<br>
							<hr>
							<br>
							<h3>Contact Details</h3>
							<div class="people">
								<div>
									<% if $ContactPerson %>
									    <span>Person: $ContactPerson</span>
									<% end_if %>
									<% if $Contact %>
									    <h4>Phone: $Contact</h4>
									<% end_if %>
									<% if $Email %>
									    <h4>Email: <a href="mailto:$Email" class="blue">$Email</a></h4>
									<% end_if %>
									<% if $ContactLink %>
										<% with $ContactLink %>
											<a href="$LinkURL" class="blue">$Title</a>
										<% end_with %>
									<% end_if %>
								</div>
							</div>
							<br>
							<hr>
							<br>
						</div>

						<% if $Speakers %>
							<h3>Speakers</h3>
							<% loop $Speakers %>
							    <div class="people">
							    	<% if $Image %>
							    	    <% with $Image %>
							    			<div class="image-wrapper">
							    				<div class="image" style="background: url($URL) no-repeat;"></div>
							    			</div>
							    	    <% end_with %>
									<% end_if %>
									<div>
										<span>$Name</span>
										<span>$Position, $Company</span>
									</div>
								</div>
							<% end_loop %>
						<% end_if %>
					</div>
					<aside class="move-on-mobile-ipad" data-append=".noDesktop h1">
						<% if $Address %>
					    	<iframe frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBXn0CC-sxhzoSqyQX74hBmOi56ggK_42g &q=$Address" allowfullscreen> </iframe>
						<% end_if %>
						<div>
							<p>$Address</p>
							<% if $EventTimeDate %>
								<% loop $EventTimeDate %>
							    	<p class="time">
							    		$Date.Long
							    		<br>
							    		<span>$StartTime.Nice<% if $EndTime %> - $EndTime.Nice <% end_if %></span>
							    	</p>
								<% end_loop %>
							<% end_if %>
							<% if not $isOwn %>
								<% if $Price == ' ' %>
									<h4>Price</h4><span>FREE</span>
								<% else %>
									<h4>Price</h4><span>$Price</span>
								<% end_if %>
							<% end_if %>
						</div>


						<% if $ExternalForm %>
						    <a class="btn darkBlue  block" href="$ExternalForm" target="_blank" title="">Attend Event</a>
						<% else %>
							<% if $isOwn %>
								<% if $isAttending %>
								<a class="btn green  block" disabled="disabled">You are booked <i class="fa fa-check"></i> </a>
								<% else %>
									<% if $CurrentMember %>
										<a class="btn darkBlue  block js__open_modal" href="eventForm">Attend Event</a>
									<% else %>
										<a class="btn darkBlue  block js__open_modal" href="login">Log in to register</a>
									<% end_if %>
								<% end_if %>
							<% end_if %>
						<% end_if %>


						<% if $AdditonalFile %>
						<% with $AdditonalFile %>
							<a class="btn paleBlue block" href="$URL" title="">Download $Extension ($Size)</a>
						<% end_with %>
						<% end_if %>

						<% if $CurrentMember %>
						<% if $isBookmarked %>
						<a class="btn paleBlue block btnBookmark active" href="#" title="Bookmark" data-type="event" data-id="$ID">Bookmarked!</a>
						<% else %>
						<a class="btn paleBlue block btnBookmark" href="#" title="Bookmark" data-type="event" data-id="$ID"><i class="fa fa-star" aria-hidden="true"></i> Bookmark Event</a>
						<% end_if %>
						<% else %>
						<a class="btn paleBlue block" href="/Security/login" title="Login to Bookmark"><i class="fa fa-star" aria-hidden="true"></i> Bookmark Event</a>
						<% end_if %>

						<div class="icons">
							<% include Sharez %>							
						<% if $Logos %>
						<h4>In collaboration with</h4>
							<figure>
							<% loop $Logos %>
								<% with $Image %>
								    <img src="$URL" alt="">
								<% end_with %>
							<% end_loop %>
						  	</figure>
						<% end_if %>
					</aside>
				</div>
			</div>
	<% end_with %>
		<% control getRelatedBlocks(Event) %>
			<% include RelatedBLocks %>
		<% end_control %>
	</main>

	<% include EventForm %>

	<% include LoginModal %>
