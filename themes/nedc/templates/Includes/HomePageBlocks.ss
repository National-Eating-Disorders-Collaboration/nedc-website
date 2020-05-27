		<div id="fluidBlocks">
			<div class="inner">
				<% control Blocks.Limit(3).Filter(Featured, '1') %>
				<div class="block $Position"
					<% if $Position == 'Third' %>
					<% else %>
				    	style="background-image: url($Background.URL);"
					<% end_if %>
				>
					<% if $Position == 'Third' %>
					<% if Background %>
					    <img src="$Background.Url" alt="">
					<% end_if %>
					<% end_if %>
					<h2>$Title</h2>
					<p>$Description</p>
					<% if $BlockLinks %>
					<ul>
						<% loop $BlockLinks %>
						    <li>$Link</li>
						<% end_loop %>
					</ul>
					<% end_if %>
					<% if $Browse %>
					    <% with Browse %>
							<a class="browse" href="$LinkURL" title="">$Title</a>
						<% end_with %>
					<% end_if %>
				</div>
				<% end_control %>
			</div>
		</div>
