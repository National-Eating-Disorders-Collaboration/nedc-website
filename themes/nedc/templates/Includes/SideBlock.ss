	<% if $SideBlocks %>
		<aside id="sticky">
		<% loop $SideBlocks %>
			<h4>$Title</h4>
			<p>$Description</p>
			<% if Link %>
			<% with $Link %>
			    <a class="btn btn-white" href="$LinkURL" title="">$Title</a>
			<% end_with %>
			<% end_if %>
			<% if not $Last %>
			   <br><hr><br>
			<% end_if %>
		<% end_loop %>
		</aside>
	<% end_if %>
