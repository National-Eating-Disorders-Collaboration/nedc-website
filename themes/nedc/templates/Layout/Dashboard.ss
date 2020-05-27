	<main id="member" class="dashboard-page">
		<div class="head">
			<ul id="breadcrumb" class="grid">
				<li><a href="$BaseHref"></a></li>
				<li><a href="/member/dashboard" title="">Dashboard</a></li>
			</ul>
			<div class="flex grid">
				<h1>Welcome back, $CurrentMember.getName</h1>
				<a class="btn darkBlue" href="mailto:$AdminEmail?Subject=Enquiry%20from%20nedc.com.au&amp;body=Cheers,%20$CurrentMember.getName" title="">Contact NEDC</a>
			</div>
		</div>
		<div class="tabs">
			<div class="nav user-options">
				<nav class="grid">
					<ul class="submenu-user">
						<li id="tabLnkSummary"><a href="#summary" title="">Summary</a></li>
						<li id="tabLnkEvents"><a href="#memberEvents" title="">Events</a></li>
						<li id="tabLnkLessons"><a href="#elearning" title="">E-Learning</a></li>
						<li id="tabLnkResources"><a href="#resources" title="">Research & Resources</a></li>
						<li id="tabLnkServices"><a href="#services" title="">Services</a></li>
						<li id="tabLnkHelp"><a href="#help" title="">Help</a></li>
						<li id="tabLnkSettings"><a href="#settings" title="">Settings</a></li>
					</ul>
				</nav>
			</div>
			<div class="grid" id="summary">
				<div class="wrap">
					<div class="bookEvent">
						<h3 class="bookmarked-entity-block-title">Events</h3>
						<div class="inner">
							<div>
	 							<h4>Booked Events  <% if $BookedEvents %>($BookedEvents.TotalItems)<% end_if %></h4>
								<% if $BookedEvents %>
								<% loop $BookedEvents.limit(5) %>
								<p><a href="$Link">$Title</a></p>
								<% if $isOwn %>
								<span class="color">NEDC Event</span>
								<% end_if %>
								<span>$EventTimeDate.Sort(Date).First.Date.Full</span>
								<br>
								<% end_loop %>
								<br>
								<a class="ancleArrow open-tab" href="member/dashboard#booked-events" title="" data-tab-index="1">View More</a>
								<% else %>
								<div class="any inner">
									<p>You have not booked any</p>
									<a href="/professional-development/SearchForm"><span>event</span></a>
								</div>
								<% end_if %>
							</div>
							<div>
								<h4>Bookmarked Events <% if $BookmarkedEvents %>($BookmarkedEvents.TotalItems)<% end_if %></h4>
								<% if $BookmarkedEvents %>
								<% loop $BookmarkedEvents.limit(5) %>
								<p><a href="$Link">$Title</a></p>
								<% if $isOwn %>
								<span class="color">NEDC Event</span>
								<% end_if %>
								<span>$EventTimeDate.Sort(Date).First.Date.Full</span>
								<br>
								<% end_loop %>
								<br>
								<a class="ancleArrow open-tab" href="" title="" data-tab-index="1">View More</a>
								<% else %>
								<div class="any inner">
									<p>You have not bookmarked any</p>
									<a href="/professional-development/SearchForm"><span>event</span></a>
								</div>
								<% end_if %>
							</div>
						</div>
					</div>
					<div class="Latest">
						<img src="$ThemeDir/img/book.svg" alt="">
						<h4>Latest E-bulletin</h4>
						<p>Learn about the importance of eating disorders and its associated treatments and programs.</p>
						<% if $EBulletin %>
						<div>
							<% loop $EBulletin %>
							<div>
								<span>Latest NEDC E-Bulletin:</span>
								<p>Issue:<span><a href="$Link">$Title</a></span></p>
							</div>
							<% if $DownloadableFile %>
							    <% with $DownloadableFile %>
							        <a class="btn darkBlue" href="$URL" title="">Download</a>
							    <% end_with %>
							<% end_if %>

							<% end_loop %>
						</div>
						<br>
						<a class="ancleArrow" href="$BaseHref/research-and-resources/e-bulletin" title="">Browse past editions</a>
						<% end_if %>
					</div>
				</div>
				<div class="aside">
					<div>
						<h3 class="bookmarked-entity-block-title">Research & Resources <% if $BookmarkedResources %>($BookmarkedResources.TotalItems)<% end_if %></h3>
						<% if $BookmarkedResources %>
						<div class="inner">
							<% loop $BookmarkedResources.limit(5) %>
							<p>
								<a href="$Link" class="bookmarked-item-title">$Title</a>
								<% if $isNEDC %>
								<br/><span class="color">NEDC Resource</span>
								<% end_if %>
								<% if $Year %>
								<br/><span>$Year</span>
								<% end_if %>
							</p>
							<% end_loop %>
							<br>
							<a class="ancleArrow open-tab" href="" title="" data-tab-index="3">View More</a>
						</div>
						<% else %>
						<div class="any inner">
							<p>You have not bookmarked any</p>
							<span><a href="/research-and-resources">Research & Resources</a></span>
						</div>
						<% end_if %>
					</div>
					<div>
						<h3 class="bookmarked-entity-block-title">E-Learning <% if $BookmarkedLessons %>($BookmarkedLessons.TotalItems)<% end_if %></h3>
						<% if $BookmarkedLessons %>
						<div class="inner">
							<% loop $BookmarkedLessons.limit(5) %>
							<p>
								<a href="$Link" class="bookmarked-item-title">$Title</a>
								<% if $Categories %>
								<br/><span class="color">$Categories.first.Title</span>
								<% end_if %>
							</p>
							<% end_loop %>
							<br>
							<a class="ancleArrow open-tab" href="" title="" data-tab-index="2">View More</a>
						</div>
						<% else %>
						<div class="any inner">
							<p>You have not bookmarked any</p>
							<span><a href="/e-learning">e-Learning Lesson</a></span>
						</div>
						<% end_if %>
					</div>
					<div>
						<h3 class="bookmarked-entity-block-title">Services <% if $BookmarkedServices %>($BookmarkedServices.TotalItems)<% end_if %></h3>
						<% if $BookmarkedServices.limit(5) %>
						<div class="inner">
							<% loop $BookmarkedServices %>
							<p>
								<a href="$Link" class="bookmarked-item-title">$Title</a>
								<% if $Categories %>
								<br/><span class="color">$Categories.first.Title</span>
								<% end_if %>
								<% if $Contact %>
								<br/><span>$Contact</span>
								<% end_if %>
							</p>
							<% end_loop %>
							<br>
							<a class="ancleArrow open-tab" href="" title="" data-tab-index="4">View More</a>
						</div>
						<% else %>
						<div class="any inner">
							<p>You have not bookmarked any</p>
							<span><a href="/support-and-services">Support Services</a></span>
						</div>
						<% end_if %>
					</div>
				</div>
			</div>
			<div id="memberEvents">
				<div class="grid">
					<div class="wrap nested-tabs">
						<div class="tags">
							<h3>Events</h3>
							<ul>
								<li id="tabLnkSavedEvents" class="nested-tab-link"><a href="#bookmarked-events" title="">Saved Events<% if $BookmarkedEvents %> ($BookmarkedEvents.TotalItems)<% end_if %></a></li>
								<li id="tabLnkBookedEvents" class="nested-tab-link"><a href="#booked-events" title="">Booked Events<% if $BookedEvents %> ($BookedEvents.TotalItems)<% end_if %></a></li>
							</ul>
						</div>
						<div id="bookmarked-events">
							<% if $BookmarkedEvents %>
							<% loop $BookmarkedEvents %>
							<div class="eventMember">
								<div>
									<% if $isOwn %>
									<span class="tag">NEDC Event</span>
									<% end_if %>
									<h3><a href="$Link">$Title</a></h3>
									<p>$About.FirstSentence</p>

								</div>
								<div>
									<p>$Address</p>
									<% if EventTimeDate %>
									<% loop EventTimeDate %>
									<p class="time">
									$Date.Long<br/>$StartTime.Nice - $EndTime.Nice
									</p>
									<% end_loop %>
									<% end_if %>
									<% if $isBookmarked %>
									<a class="red btnBookmark active js__remove_event" href="#" title="Bookmark" data-type="event" data-id="$ID">Remove</a>
									<% else %>
									<a class="paleBlue btnBookmark" href="#" title="Bookmark" data-type="event" data-id="$ID"><i class="fa fa-star" aria-hidden="true"></i> Bookmark Event</a>
									<% end_if %>
								</div>
							</div>
							<% end_loop %>
							<% if $BookmarkedEvents.MoreThanOnePage %>
							<div id="pagination">
						  		<% if $BookmarkedEvents.NotFirstPage %>
					  			<a class="prev" href="$BookmarkedEvents.PrevLink" title="">Previous</a>
						  		<% end_if %>
						  		<% loop $BookmarkedEvents.PaginationSummary(10) %>
				  				<% if Link %>
			  					<a <% if $CurrentBool %>class="active"<% end_if %> href="$Link" title="Page $PageNum">$PageNum</a>
				  				<% else %>
			  					...
				  				<% end_if %>
						  		<% end_loop %>
						  		<% if $BookmarkedEvents.NotLastPage %>
					  			<a class="next" href="$BookmarkedEvents.NextLink" title="">Next</a>
						  		<% end_if %>
							</div>
							<% else %>
							<div id="pagination"></div>
							<% end_if %>
							<% else %>
							<p>No events have been bookmarked yet.</p>
							<div id="pagination"></div>
							<% end_if %>
						</div>
						<div id="booked-events">
							<% if $BookedEvents %>
							<% loop $BookedEvents %>
							<div class="eventMember">
								<div>
									<% if $isOwn %>
									<span class="tag">NEDC Event</span>
									<% end_if %>
									<h3><a href="$Link">$Title</a></h3>
									<p>$About.FirstSentence</p>
								</div>
								<div>
									<p>$Address</p>
									<% if EventTimeDate %>
									<p>
									<%-- <% loop EventTimeDate %>
									$Date.Long<br/>$StartTime.Nice - $EndTime.Nice<br/>
									<% end_loop %> --%>
									</p>
									<% end_if %>
									<a class="red" href="mailto:info@nedc.com?subject=Cancel booking:$CurrentMember.FirstName&body= Please cancel booking to this event $Link">Email Admin to Cancel</a>
								</div>
							</div>
							<% end_loop %>
							<% if $Resources.MoreThanOnePage %>
							<div id="pagination">
						  		<% if $BookedEvents.NotFirstPage %>
					  			<a class="prev" href="$BookedEvents.PrevLink" title="">Previous</a>
						  		<% end_if %>
						  		<% loop $BookedEvents.PaginationSummary(10) %>
				  				<% if Link %>
			  					<a <% if $CurrentBool %>class="active"<% end_if %> href="$Link" title="Page $PageNum">$PageNum</a>
				  				<% else %>
			  					...
				  				<% end_if %>
						  		<% end_loop %>
						  		<% if $BookedEvents.NotLastPage %>
					  			<a class="next" href="$BookedEvents.NextLink" title="">Next</a>
						  		<% end_if %>
							</div>
							<% else %>
							<div id="pagination"></div>
							<% end_if %>
							<% else %>
							<p>No events have been bookmarked yet.</p>
							<div id="pagination"></div>
							<% end_if %>
						</div>
					</div>
				</div>
			</div>
			<div class="grid" id="elearning">
				<div style="width:940px;">
					<div id="bookmarked-lessons">
						<% if $BookmarkedLessons %>
						<% loop $BookmarkedLessons %>
						<div class="bookmark">
							<div>
								<div>
									<h4 class="resource-title"><a href="$Link">$Title</a></h4>
									<% if $Categories %>
									<p>$Categories.first.Title</p>
									<% end_if %>
								</div>
								<% if $CurrentMember %>
								<% if $isBookmarked %>
								<a class="btn paleBlue btnBookmark active" href="#" title="Bookmark" data-type="lesson" data-id="$ID">Bookmarked!</a>
								<% else %>
								<a class="btn paleBlue btnBookmark" href="#" title="Bookmark" data-type="lesson" data-id="$ID"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
								<% end_if %>
								<% else %>
								<a class="btn paleBlue" href="/Security/login" title="Login to Bookmark"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
								<% end_if %>
							</div>
							<% if $isNEDC %>
							<span>NEDC Resource</span>
							<% end_if %>
						</div>
						<% end_loop %>

						<% if $BookmarkedLessons.MoreThanOnePage %>
						<div id="pagination">
					  		<% if $BookmarkedLessons.NotFirstPage %>
				  			<a class="prev" href="$BookmarkedLessons.PrevLink" title="">Previous</a>
					  		<% end_if %>
					  		<% loop $BookmarkedLessons.PaginationSummary(10) %>
			  				<% if Link %>
								<a <% if $CurrentBool %>class="active"<% end_if %> href="$Link" title="Page $PageNum">$PageNum</a>
			  				<% else %>
								...
			  				<% end_if %>
					  		<% end_loop %>
					  		<% if $BookmarkedLessons.NotLastPage %>
				  			<a class="next" href="$BookmarkedLessons.NextLink" title="">Next</a>
					  		<% end_if %>
						</div>
						<% else %>
						<div id="pagination"></div>
						<% end_if %>
						<% else %>
						<p>No lessons have been bookmarked yet.</p>
						<div id="pagination"></div>
						<% end_if %>
					</div>
				</div>
			</div>
			<div class="grid" id="resources">
				<div style="width:940px;">
				<% include ResourcesList Resources=$BookmarkedResources, hideSortBy=true, hideTotalResultCount=true %>
				</div>
			</div>
			<div class="grid" id="services">
				<div id="supportServices">
					<div class="wrap">
					<% if $BookmarkedServices %>
					<% loop $BookmarkedServices %>
						<div class="service">
							<div>
								<h3><a href="$Link">$Title</a></h3>
								 <span>
								<% loop $Categories %>
								   <% if $First %>
								       $Title
								   <% end_if %>
								<% end_loop %>
								</span>
								<p><% if $Address %>
								    $Address
								<% end_if %>
								<% if $State %>
								    $State
								<% end_if %>
								$State</p>

								<% if $Hours %>
								<% if $Hours == 'Closed'  %>
								    <% else %>
								   	<p>Open today $Hours</p>
								<% end_if %>
								<% end_if %>
							</div>
							<div>

							<% if $CurrentMember %>
							<% if $isBookmarked %>
							<a class="btn paleBlue btnBookmark active" href="#" title="Bookmark" data-type="service" data-id="$ID">Bookmarked!</a>
							<% else %>
							<a class="btn paleBlue btnBookmark" href="#" title="Bookmark" data-type="service" data-id="$ID"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
							<% end_if %>
							<% else %>
							<a class="btn paleBlue" href="/Security/login" title="Login to Bookmark"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
							<% end_if %>

							<% if $Website %>
							    <a class="btn paleBlue" href="$Website" title=""><i class="fa fa-globe" aria-hidden="true"></i> Visit Website</a>
							<% end_if %>

							<% if $Contact %>
							    <a class="btn paleBlue" href="" title=""><i class="fa fa-phone" aria-hidden="true"></i> $Contact</a>
							<% end_if %>

							</div>
						</div>
					<% end_loop %>
					<% else %>
					<p>No services have been bookmarked yet.</p>
					<div id="pagination"></div>
					<% end_if %>
					</div>
				</div>
			</div>
			<div class="grid" id="help">
				<div style="width:940px;">
					<div class="editor-content">
						$SiteConfig.Help
					</div>
				</div>
			</div>

			<div class="grid" id="settings">
				<div id="member_settings" style="width:940px;">
					$MemberUpdateForm
				</div>
			</div>
		</div>
	</main>
