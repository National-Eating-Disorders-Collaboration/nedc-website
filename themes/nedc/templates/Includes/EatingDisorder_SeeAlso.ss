		<% if $HasSiblingArticles %>
		<div id="seeAlso">
			<h2>See also</h2>
			<div class="grid">
				<div id="slick-slide" class=" inner">
					<% loop $SiblingArticles %>
					<div class="wrap">
						<h3 class="anchorTitle">$Title</h3>
						<p>$Content.Summary()</p>
						<p><a href="$Link" title="Read more about $Title">more</a></p>
					</div>
					<% end_loop %>
				</div>
			</div>
		</div>
		<% end_if %>