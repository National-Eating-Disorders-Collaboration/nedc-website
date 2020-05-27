		<div id="slider">
			<% if Carousel %>
				<% loop Carousel %>
				    <div class="image">
				    <% with Slider %>
				    	<img src="$URL" alt="">
				        <%-- <div class="slider" style="background-image: url($URL)"></div> --%>
				    <% end_with %>
				    <% if $Title %>
						<div class="caption">
							<h3>$Title</h3>
							<p>$Description.LimitWordCount(25)</p>
							<% if $Link %>
							    <% with $Link %>
							        <a href="$LinkURL">$Title</a>
							    <% end_with %>
							<% end_if %>
						</div>
					<% end_if %>
					</div>
				<% end_loop %>
			<% end_if %>
		</div>
		
