	<main id="main-wrapper-page">
		<ul id="breadcrumb" class="grid">
			<li><a href="$BaseHref"></a></li>
			<li><a href="$Link" title="">Research & Resources </a></li>
			<li><a href="$Link(true)" title="">Search</a></li>
		</ul>
		<div id="researchSearch">
			<div id="wrapTitle">
				<div class="grid">
					<h1 class="">Research & Resources</h1>
				</div>
			</div>

			<div class="grid wrapflex">
				<div class="left">
					$SearchForm

					<% if $Keywords %>
					<h3>Search Result for “$Keywords”</h3>
					<% end_if %>
					<% include ResourcesList %>
				</div>
				<% if $Articles %>
				<aside>
					<h4>Related Articles</h4>
					<p>
						<% loop $Articles %>
						<a href="$Link">$Title</a><br/>
						<% end_loop %>
					</p>
				</aside>
				<% end_if %>
			</div>
		</div>
	</main>
