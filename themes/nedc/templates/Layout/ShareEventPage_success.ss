
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
				<div class="editor-content">
					$Content
				</div>
				<script>
					setTimeout(function(){
						window.location.href = 'professional-development/';
					}, 5000);
				</script>
			</div>
		</div>
	</main>
