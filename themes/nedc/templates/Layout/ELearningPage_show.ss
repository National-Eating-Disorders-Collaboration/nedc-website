	<main id="researchDetails">
		<% include BreadCrumbs %>
		<% with ELearn %>
			<div id="wrapTitle">
				<div class="grid">
					<h1 class="">$Title</h1>
				</div>
			</div>
			<div class="grid wrapflex">
				<div class="clear-div"></div>
				<div class="left">
					<%--  TEMPORARY embed  --%>
					<% if $Video %>
					    <iframe width="100%" height="500px !important" src="https://www.youtube.com/embed/$Video?rel=0" frameborder="0" allowfullscreen></iframe>
					<% end_if %>
					<h3>$Title</h3>
					<div class="editor-content">
						$Description
					</div>
				</div>
				<aside class="move-on-mobile" data-append=".wrapflex .clear-div">

					<% if $CurrentMember %>
					<% if $isBookmarked %>
					<a class="btn paleBlue btnBookmark active" href="#" title="Bookmark" data-type="lesson" data-id="$ID">Bookmarked!</a>
					<% else %>
					<a class="btn paleBlue btnBookmark" href="#" title="Bookmark" data-type="lesson" data-id="$ID"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
					<% end_if %>
					<% else %>
					<a class="btn paleBlue" href="/Security/login"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
					<% end_if %>

					<div class="flex">
						<a class="f" href="https://www.facebook.com/sharer/sharer.php?u=$BaseHref$Link" title="Share on Facebook" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=480')"></a>
						<a class="t" href="https://twitter.com/share?url=$BaseHref$Link" title="Share on Twitter" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=480')"></a>
						<a class="m" href="" title="" disabled="disabled"></a>
						<a class="p" href="javascript:window.print()" title="Print"></a>
					</div>
				</aside>
			</div>
		</main>
	<% end_with %>
