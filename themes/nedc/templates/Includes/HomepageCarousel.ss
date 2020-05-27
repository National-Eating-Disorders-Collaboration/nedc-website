		<% if $Carousel %>
		<div class="slider">
			<div id="sliders">
			<% control $Carousel %>
				<div class="hero-image">
					<div class="image" style="background: url($Slider.URL) no-repeat;">
						<% if not $Title %>
						    <% if $Link %>
						        <% with $Link %>
						            <a class="overlay-link" href="$LinkURL">&nbsp;</a>
						        <% end_with %>
						    <% end_if %>
						<% end_if %>
						<% if $Title %>
						<div class="grid inner">
							<div class="info">
						        <% if $Title %>
						            <h1 class="$Color">$Title</h1>
						        <% end_if %>
					            <% if $Link %>
									<span class="link $Color">$Link</span>
								<% end_if %>
								<% if $OtherText %>
								    <span class="other $Color">$OtherText</span>
								<% end_if %>
							</div>
						</div>
						<% end_if %>
					</div>
				</div>
			<% end_control %>
			</div>
			<% if $BecomeMember %>
			<% with BecomeMember %>
			<div class="captionHome">
				<% include BecomeMemberBox %>
			</div>
			<% end_with %>
			<% end_if %>
		</div>
		<% end_if %>
