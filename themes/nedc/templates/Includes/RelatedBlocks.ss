
		<div id="seeAlso">
			<div class="grid">
				<h2>See also</h2>
				<div id="slick-slide" class="inner">
					<% loop $Blocks %>
						<div class="wrap">
							<h3 class="anchorTitle">$Title</h3>
							<% if $Content %>
							    <p>$Content.LimitWordCount(10)</p>
							    <% else_if $Description %>
							    <p>$Description.LimitWordCount(10)</p>
							    <% else_if $About %>
							    <p>$About.LimitWordCount(10)</p>
							<% end_if %>
							<a href="$Link">Read more</a>
						</div>
					<% end_loop %>
				</div>
			</div>
		</div>
