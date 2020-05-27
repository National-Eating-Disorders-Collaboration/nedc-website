			<div class="infoMember">
				<%-- <% if $Image %>
				    <% with Image %>
				    <img src="$URL" alt="">
					<% end_with %>
				<% end_if %> --%>
				<img src="$ThemeDir/img/member.svg" alt="">
				<h4>$Title</h4>
				<p>$Description</p>
				<% if $Link %>
				    <% with Link %>
				        <a class="link" href="$LinkURL" title="">$Title</a>
				    <% end_with %>
				<% end_if %>
				<br>
				<% if $Button %>
				    <% with Button %>
				        <a class="btn" href="$LinkURL" title="">$Title</a>
				    <% end_with %>
				<% end_if %>
			</div>
