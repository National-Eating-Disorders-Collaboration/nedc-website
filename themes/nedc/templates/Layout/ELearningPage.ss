
	<main id="main-wrapper-page">
		<% include BreadCrumbs %>
		<div id="professionalElerning" class="grid">
			<h1>$Title</h1>
			<div class="slider">
				<% include Carousel %>
			</div>
			<div class="editor-content">
				$Content
			</div>
			<div class="filter">
				<span>Filter by</span>
				$SortForm
			</div>
			<div class="media">
				<% if Results %>
				    <% loop Results %>
						<div class="box <% with Categories %><% if $Title == 'Webminar' %>video<% end_if %><% end_with %>">
							<a href="$Link">
								<% with $Thumbnail %>
								    <div class="image" style="background: url($URL) no-repeat;"></div>
								<% end_with %>
							</a>
							<div class="info">
								<p>$Title</p>
								<% with Categories %>
								    <small>$Title</small>
								<% end_with %>
							</div>
						</div>
					<% end_loop %>
					<% else %> 
					No results found.
				<% end_if %>

			</div>
		</div>
		<% include Pagination %>
	</main>
