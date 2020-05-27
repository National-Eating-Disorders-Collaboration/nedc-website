	<main id="contentEating">
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
			<h3 class="description">$Content.Summary</h3>
			<ul class="linksCat">
				<% loop Menu(2) %>
				<li><a class="<% if $LinkoOrCurrent == 'current' %>active<% end_if %> $LinkingMode" href="$Link" title="$Title">$Title</a></li>
				<% end_loop %>
			</ul>

			<% loop $Children %>
			<div class="wrap">
				<div class="info">
					<div class="head">
						<h2>$Title</h2>
						<a class="btn paleBlue" href="$Link" title="$Title">Browse Topics</a>
					</div>
					<p class="description">$Content.Summary</p>
					<% if $Children.filter('ClassName', 'EatingDisordersArticleSubCategory') %>
					<nav>
						<% loop $Children.filter('ClassName', 'EatingDisordersArticleSubCategory') %>
						<ul>
							<li>$Title</li>
							<% loop $Children %>
							<li><a href="$Link" title="$Title">$Title</a></li>
							<% end_loop %>
						</ul>
						<% end_loop %>
					</nav>
					<% else %>
					<% if $no_of_articles_on_parent_list_mode > 1 %>
					<% loop $Children.filter('ClassName', 'EatingDisordersArticle') %>
					<% if $First %>
					<div class="twoColumns">
					<% end_if %>
						<div>
							<h3>$Title</h3>
							<p class="description">$Content.FirstSentence</p>
							<a class="link" href="$Link">Read more</a>
						</div>
					<% if $Last %>
					</div>
					<% end_if %>
					<% end_loop %>
					<% else %>
					<% with $Children.First %>
					<h3>$Title</h3>
					<% if $SpecialSummary %>
					$SpecialSummary
					<% else %>
					<p class="description">$Content.Summary</p>
					<% end_if %>
					<a class="link" href="$Link" title="$Title">More on $Title</a>
					<% end_with %>
					<% end_if %>
					<% end_if %>
				</div>

				<% if $Children.filter('ClassName', 'EatingDisordersArticle').count > 2 %>
				<div class="aside<% if $Odd %> dark <% else %> light <% end_if %> links">
				<% else %>
				<div class="aside light content">
				<% end_if %>
	
					<% loop $Children.filter('ClassName', 'EatingDisordersArticle').limit(4) %>
					<% if $TotalItems > 2 %>
					<% if $First %>
					<span class="title">See also</span>
					<% end_if %>
					<% if $Pos != 1  %>
					    <a class="more" href="$Link" title="$Title">$Title</a>
					<% end_if %>
					
					<% else %>
					<% if $First %>
					<div class="content">
					<% end_if %>
					<h3>$Title</h3>
					<p class="description">$Content.FirstSentence</p>
					<a class="link" href="$Link">Read more</a>
					<% if $Last %>
					</div>
					<% end_if %>
					<% end_if %>
					<% end_loop %>

					<% if $Factsheets %>
					<div class="download">
						<h5>Download Factsheet</h5>
						<div class="fact-sheet">
							<ul class="f-list">
							<% loop $Factsheets %>
								<li><a class="inner" href="$Me.FactsheetPDF.AbsoluteLink" title="$Title">$Title<span>$Me.FactsheetPDF.getExtension.UpperCase, $Me.FactsheetPDF.getSize</span></a></li>
							<% end_loop %>
							</ul>
							<a class="js__view_more">View more <i class="fa fa-angle-down"></i></a>
							<a class="js__view_less">View less <i class="fa fa-angle-up"></i></a>
						</div>
					</div>
					<% end_if %>
				</div>
			</div>

			<% if $Pos == $Top.MiddleOf($TotalItems)%>
			$SiteConfig.UrgentSupportCTA
			<% end_if %>
			<% end_loop %>
		</div>
	</main>
