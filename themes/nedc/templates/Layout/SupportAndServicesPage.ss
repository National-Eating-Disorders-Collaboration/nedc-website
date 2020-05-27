
	<main id="main-wrapper-page">
		<% include BreadCrumbs %>
		<div id="supportServices" class="grid" >
			<div class="wrap">
				<h1>Support Organisations & Services in
					<select name="state" id="au_states" >
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
				<div class="editor-content">
					$Content
				</div>
				<div class="search">
					$ServicesForm
				</div>
				<div class="filter">
					<span>Sort by</span>
					<select name="sort" id="sort_by">
						<option value="" selected="selected">Sort</option>
						<option value="Alphabetical">Alphabetical</option>
						<option value="Relevance">Relevance</option>
					</select>
				</div>
				<% if $Results %>
				<% loop $Results %>
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
							<p class="address"><% if $Address %>
							    $Address
							<% end_if %>
							<% if $State %>
							    $State
							<% end_if %>
							</p>

							<% if $Hours %>
							<% if $Hours == 'Closed'  %>
							    <% else %>
							   	<p class="open-today">Open today $Hours</p>
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
						    <a class="btn paleBlue" href="$Website" target="_blank" title=""><i class="fa fa-globe" aria-hidden="true"></i> Visit Website</a>
						<% end_if %>

						<% if $Contact %>
						    <a class="btn paleBlue" href="tel:$Contact" title=""><i class="fa fa-phone" aria-hidden="true"></i> $Contact</a>
						<% end_if %>

						</div>
					</div>
				<% end_loop %>
				<% else %>
					<p>No Results.</p>
				<% end_if %>
				<% include Pagination %>
			</div>
			<% include SideBlock %>
		</div>
	</main>
