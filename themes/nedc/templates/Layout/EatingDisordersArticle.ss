		<div id="contentEating" class="white">
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
			<div class=" grid internPage ">
				<div class="editor-content">
					$Content
					<% if $Links %>
					<div class="related">
						<h3 class="anchorTitle">$RelatedLinksTitle</h3>
						<% loop $Links %>
						<a class="link" href="$LinkURL" target="_blank">$Title<span></span></a>
						<% end_loop %>
					</div>
					<% end_if %>

						<% include Sharez %>
				</div>
				<aside id="sticky">
					<% if $Parent.Children %>
					<ul>
						<h4>Articles in this section</h4>
						<% loop $Parent.Children %>
						<% if $ClassName == 'EatingDisordersArticle' %>
						<li><a href="$Link">$Title</a></li>
						<% end_if %>
						<% end_loop %>
					</ul>
					<% end_if %>
					<% if $Factsheets %>
					<div class="download">
						<h4>Download Factsheet</h4>
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
					<% if $SideBox %>
					<div class="side-blocks">
					<% loop $SideBox %>
						<div class="blocks">
					    	<h4>$Title</h4>
					    	$Description
					    	$Link
					   	</div>
					<% end_loop %>
					</div>
					<% end_if %>
				</aside>
			</div>
		</div>
		<%-- include EatingDisorder_SeeAlso --%>
