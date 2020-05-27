
  <!-- End Header -->

		<div id="supportDetails">
			<% include BreadCrumbs %>
			<div class="inner grid">
			<% if $Organization %>
				<% with $Organization %>
					<div class="content">
						<h1>$Title</h1>
						<div class="editor-content">
							$Content
						</div>
						<br>
						<div class="data">
							<p id="google_address"><i class="fa fa-map-pin"></i> <% if $Address %>$Address<% end_if %> <% if $State %> $State<% end_if %></p>
							<% if $Hour %>
							    <p><i class="fa fa-clock-o"></i> $Hour</p>
							<% end_if %>
							<p><i class="fa fa-phone"></i> <a href="tel:$Contact">$Contact</a> <% if $Phone1 %>, <a href="tel:$Phone1">$Phone1</a> <% end_if %> <% if $Phone2 %>,  <a href="tel:$Phone2">$Phone2</a>, <% end_if %> </p>
							<% if $Fax %>
							    <p><i class="fa fa-fax"></i> $Fax</p>
							<% end_if %>
							<% if $Website %>
							 	<p><i class="fa fa-globe"></i> <a href="$Website" target="_blank" title="">$Website</a></p>
							<% end_if %>
							<% if $EmailAddress %>
							    <p><i class="fa fa-envelope"></i> <a href="mailto:$EmailAddress" title="">$EmailAddress</a></p>
							<% end_if %>
						</div>
						<% if $Categories %>
						<div class="flex">
							<b>Service Type</b>
							<div>
								<p>
								<% loop $Categories %>
								   $Title<% if not $Last %>,<% end_if %>
								<% end_loop %>
								</p>
							</div>
						</div>
						<% end_if %>
			<% end_with %>
			<% end_if %>
					<% if $Time %>
					<div class="flex">
						<b class="open_title">Opening Hours</b>
						<div class="hours">
						<% loop $Time %>
							<dl>
								<% if $Monday %>
						        	<dt>Monday</dt>
						        	<dd>$Monday</dd>
						    	<% end_if %>
						    	<% if $Tuesday %>
						        	<dt>Tuesday</dt>
						        	<dd>$Tuesday</dd>
						    	<% end_if %>
						    	<% if $Wednesday %>
						        	<dt>Wednesday</dt>
						        	<dd>$Wednesday</dd>
						    	<% end_if %>
						    	<% if $Thursday %>
						        	<dt>Thursday</dt>
						        	<dd>$Thursday</dd>
						    	<% end_if %>
						    	<% if $Friday %>
						        	<dt>Friday</dt>
						        	<dd>$Friday</dd>
						    	<% end_if %>
						    	<% if $Saturday %>
						        	<dt>Saturday </dt>
						        	<dd>$Saturday</dd>
						    	<% end_if %>
						    	<% if $Sunday %>
						        	<dt>Sunday</dt>
						        	<dd>$Sunday</dd>
						    	<% end_if %>
							</dl>
						<% end_loop %>
						</div>
					</div>
					<% end_if %>
					<% if $Population %>
						<div class="flex">
							<b>Population</b>
							<div>
							<p>
							   <% loop $Population %>
									$Title<% if not $Last %>,<% end_if %>
								<% end_loop %>
							</p>
							</div>
						</div>
					<% end_if %>
				</div>
				<aside>
					<% with Organization %>
					<% if $Address %>
					    <iframe frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBXn0CC-sxhzoSqyQX74hBmOi56ggK_42g &q=$Address" allowfullscreen> </iframe>
					<% end_if %>
					<% end_with %>

					<%-- <a class="btn darkBlue" href="https://www.google.com.au/maps" title="">Get Direction</a> --%>
					<% if $CurrentMember %>
					<% if $isBookmarked %>
					<a class="btn paleBlue btnBookmark active" href="#" title="Bookmark" data-type="service" data-id="$ID">Bookmarked!</a>
					<% else %>
					<a class="btn paleBlue btnBookmark" href="#" title="Bookmark" data-type="service" data-id="$ID"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
					<% end_if %>
					<% else %>
					<a class="btn paleBlue" href="/Security/login" title="Login to Bookmark"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
					<% end_if %>
					
					<% include Sharez %>
				</aside>
			</div>
		</div>
		<% control getRelatedBlocks(SupportOrganization) %>
		    <% include RelatedBlocks %>
		<% end_control %>
