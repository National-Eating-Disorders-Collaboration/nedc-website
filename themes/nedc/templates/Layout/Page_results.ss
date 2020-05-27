
	<main id="main-wrapper-page">
		<% include BreadCrumbs %>
		<div id="supportServices" class="grid" >
			<div class="wrap">
				<h1>Search Results</h1>
				<%-- $Content --%>
				<div class="search-form">
					$GlobalSearch
				</div>
				<% if $Results %>
				<p>Search for: "$Query"</p>
				<p>$resultCounter($Results.TotalItems, $Results.CurrentPage, 12)</p>
				<% loop $Results %>
					<div class="service">
						<div>
							<h3><a href="$Link">$Title</a></h3>
							 <span>
								<% if $Content %>
								$Content.LimitWordCount(10)
								<% else %>
								$About.LimitWordCount(10)
								<% end_if %>

								<% if $ClassName == 'File' %>
								    (PDF FILE)
								<% end_if %>
							</span>
						</div>
						<div>
						<a class="btn paleBlue " href="$Link" title="Bookmark">View More</a>

						<% if $Website %>
						    <a class="btn paleBlue" href="$Website" title=""><i class="fa fa-globe" aria-hidden="true"></i><i class="fa fa-globe"></i> Visit Website</a>
						<% end_if %>

						<% if $Contact %>
						    <a class="btn paleBlue" href="" title=""><i class="fa fa-phone" aria-hidden="true"></i> $Contact</a>
						<% end_if %>
						</div>
					</div>
				<% end_loop %>
				<% else %>
					<p>No Results.</p>
				<% end_if %>
				<% include Pagination %>
			</div>
		</div>
	</main>
