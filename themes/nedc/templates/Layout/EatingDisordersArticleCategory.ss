	<main id="contentEating">
		<div class="sticky">
			<ul class="grid">
				<li>Eating Disorders:</li>
				<% loop Menu(2) %>
				<li><a class="<% if $InSection($Me.URLSegment) %>active<% end_if %> $LinkingMode" href="$Link" title="$Title">$Title</a></li>
				<% end_loop %>
			</ul>
		</div>
		<ul id="breadcrumb" class="grid">
			<li><a href="#"></a></li>
			<% loop $Breadcrumbs %>
			<li><a class="<% if $LinkingMode == 'current' %>active<% end_if %>" href="$Link" title="">$Title</a></li>
			<% end_loop %>
		</ul>
		<div id="wrapTitle">
			<h1 class="grid">$Title</h1>
		</div>
		<div class="grid">
			<div class="editor-content">
				$Content
			</div>
		<%-- <div class="jump">
				<p class="description">Jump to:</p>
				<div class="flex">
					<div>
						<% loop $Children %>
						<% if $CLassName == 'EatingDisordersArticleSubCategory' %>
						<% loop $Children %>
						<a class="anchorTitle" href="$Link">$Title</a>
						<% end_loop %>
						<% else %>
						<a class="anchorTitle" href="$Link">$Title</a>
						<% end_if %>
						<% if $MultipleOf(3) %>
						</div>
						<div>
						<% end_if %>
						<% end_loop %>
					</div>
				</div>
			</div> --%>
			<% if $Children.filter('ClassName', 'EatingDisordersArticleSubCategory').first %>
			<div class="wrap">
				<div class="info light">
					<div class="flex">
						<div>
							<% with $Children.filter('ClassName', 'EatingDisordersArticleSubCategory').first %>
							<% with $Children.first %>
							<h2 class="anchorTitle">$Title</h2>
							<div class="description">
								<% if $SpecialSummary %>
									$SpecialSummary
								<% else %>
									$Content.FirstParagraph
								<% end_if %>
							</div>
							<a class="btn paleBlue" href="$Link" title="">Learn More</a>
							<% end_with %>
							<% if $Children.limit(999, 1) %>
							<div class="more">
								<p>See also</p>
								<% loop $Children.limit(999, 1) %>
								<a class="anchorTitle" href="$Link">$Title <% if not Last %>,<% end_if %></a>
								<% end_loop %> 
							</div>
							<% end_if %>
							<% end_with %>
						</div>
						<% if $Children.filter('ClassName', 'EatingDisordersArticleSubCategory').limit(999, 1) %>
						<div class="links">
							<% loop $Children.filter('ClassName', 'EatingDisordersArticleSubCategory').limit(999, 1) %>
							<p>$Title</p>
							<% loop $Children %>
							<a class="anchorTitle" href="$Link">$Title</a>
							<% end_loop %>
							<% end_loop %>
						</div>
						<% end_if %>
					</div>
				</div>
			</div>
			<% end_if %>
			<% loop $Children.filter('ClassName', 'EatingDisordersArticle') %>
			<div class="wrap">
				<% if $Photo %>
				    <% if $Even %>
						<div class="image"><img src="$Photo.SetWidth(300).URL" alt=""></div>
					<% end_if %>
				<% end_if %>
				<div class="info <% if $Even %>light<% end_if %>">
					<h2 class="anchorTitle">$Title</h2>
					<div class="description">
						<% if $SpecialSummary %>
							$SpecialSummary
						<% else %>
							$Content.FirstParagraph
						<% end_if %>
					</div>
					<br>
					<a class="btn paleBlue" href="$Link">Learn More</a>
				</div>
				<% if $Photo %>
				    <% if $Odd %>
						<div class="image"><img src="$Photo.SetWidth(300).URL" alt=""></div>
					<% end_if %>
				<% end_if %>
			</div>

			<% if $Pos == $Top.MiddleOf($TotalItems)%>
			$SiteConfig.UrgentSupportCTA
			<% end_if %>
			<% end_loop %>
		</div>
	</main>
