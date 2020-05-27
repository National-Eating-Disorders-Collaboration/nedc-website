
	<main id="become">
		<div class="banner">
			<div class="banner">
			<% if $Thumbnail %>
			<% with Thumbnail %>
				<div class="image" style="background: url($URL) center no-repeat;">
			<% end_with %>
			<% else %>
				<div class="image" style="background-color: #275569">
			<% end_if %>

				<h1 class="<% if DarkColor%> dark <% end_if%>">$Title</h1>
			</div>
		</div>
		</div>
		<ul id="breadcrumb" class="grid">
			<li><a href="$BaseHref"></a></li>
			<% loop Breadcrumbs %>
			    <li class=""><a href="$Link">$Title</a></li>
			<% end_loop %>
		</ul>
		<div class="grid wrapper">
			<div>
				<div class="editor-content">
					$Content
				</div>
					<% include Sharez %>
			</div>
			<% include SideBlock %>
		</div>
		<% include SeeAlsoSections %>
	</main>
