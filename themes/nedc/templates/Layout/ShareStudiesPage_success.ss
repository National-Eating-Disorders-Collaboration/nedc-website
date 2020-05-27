
	<main id="main-wrapper-page">
		<ul id="breadcrumb" class="grid">
			<li><a href="$BaseHref"></a></li>
			<% loop $Breadcrumbs %>
			    <li><a href="$Link">$Title</a></li>
			<% end_loop %>
		</ul>
		<%-- $ShareEventForm --%>
		<div id="professionalShare" class="grid">
			<div class="inner">
				<h1>Share an Event</h1>
				<div class="editor-content">
					$Content
				</div>
				<script>
					setTimeout(function(){
						window.location.href = 'share-studies/';
					}, 5000);
				</script>
			</div>
		</div>
	</main>
