	<main id="main-wrapper-page">
		<ul id="breadcrumb" class="grid">
			<li><a href="$BaseHref"></a></li>
			<li><a href="$Link" title="">Research & Resources </a></li>
			<li><a title="">$Title</a></li>
		</ul>
		<div id="researchSearch">
			<div id="wrapTitle">
				<div class="grid">
					<h1 class="">Research & Resources<span> / $Title</span></h1>
				</div>
			</div>
			<div class="grid wrapflex">
				<div class="left">
					<div class="editor-content"><p>$Category.ShortDescription</p></div>
					<% include ResourcesList %>
					$SortForm
				</div>
			</div>
		</div>
	</main>
