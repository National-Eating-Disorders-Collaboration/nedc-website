
	<main id="about">
		<div class="banner">
			<% if $Banner %>
			<% with Banner %>
				<div class="image" style="background: url($URL) center no-repeat;">
			<% end_with %>
			<% else %>
				<div class="image" style="background-color: #275569; ">
			<% end_if %>
				<h1 class="<% if DarkColor%> dark <% end_if%>">$Title</h1>
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
				<% if Children %>
				    <% loop Children %>
				        <div class="more">
							<% with $Thumbnail %>
							    <div class="image" style="background: url($URL) no-repeat;"></div>
							<% end_with %>
							<div>
								<h3>$Title</h3>
								<p>$Content.FirstParagraph.NoHTML</p>
								<a class="ancleArrow" href="$Link" title="">Read more</a>
							</div>
						</div>
				    <% end_loop %>
				<% end_if %>
				<% include Sharez %>
			
			</div>
			<% include SideBlock %>
		</div>
		<% include SeeAlsoSections %>
	</main>
