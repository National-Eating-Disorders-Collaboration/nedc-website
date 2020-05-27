
		<ul id="breadcrumb" class="grid">
			<li><a href="$BaseHref"></a></li>
			<% loop $Breadcrumbs %>
			    <li><a href="$Link">$Title</a></li>
			<% end_loop %>
			<%-- For dataObject --%>
			<% if not $Up %>
			    <li><a href="$Link">$Me.Title</a></li>
			<% end_if %>
		</ul>
