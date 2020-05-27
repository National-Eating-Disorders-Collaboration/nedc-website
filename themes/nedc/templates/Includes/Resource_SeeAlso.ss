		<% if $RelatedResources %>
		<div id="seeAlso">
			<h2>See also</h2>	
			<div class="grid">
				<div id="slick-slide" class="inner">
					<% loop $RelatedResources %>
					<div class="wrap">
						<h3 class="anchorTitle">$Title</h3>
						<p>$Description.FirstSentence</p>
						<a href="$Link">Read more</a>
					</div>
					<% end_loop %>
				</div>
			</div>	
		</div>
		<% end_if %>
