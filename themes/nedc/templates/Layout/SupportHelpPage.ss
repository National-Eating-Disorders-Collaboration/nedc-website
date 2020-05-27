
  <!-- End Header -->
	<main id="main-wrapper-page">
		<div id="supportHelp">
			<ul id="breadcrumb" class="grid">
				<li><a href="$BaseHref"></a></li>
				<% loop $Breadcrumbs %>
				    <li><a href="$Link">$Title</a></li>
				<% end_loop %>
			</ul>
			<div class="inner grid">
				<h1>$Title</h1>
				<div class="editor-content">
					$Content
				</div>
				<div class="flexImg">
				<% loop $Blocks %>
				<% if $Type = 'Help' %>
					<div>
						$Image
						<p>Call <span>$Contact</span></p>
					</div>
				<% end_if %>
				<% end_loop %>
				</div>
			</div>
			<div class="contact">
				<div class="grid">
					<img src="$ThemeDir/img/butterbig.png">
					<div class="flex">
						<% loop $Blocks %>
						<% if $Type = 'Butterfly' %>
						<div>
							<h3 class="tel">$Title</h3>
							<p>$Description</p>
							<% if Contact %>
							    <span>$Contact</span>
							<% end_if %>
							<% if $Link %>
							    <% with $Link %>
							        <a class="btn paleBlue" href="$LinkURL" title="">$Title</a>
							    <% end_with %>
							<% end_if %>
							<% if $Email %>
							     <a class="btn paleBlue" href="mailto:$Email" title="">Email us</a>
							<% end_if %>
						</div>
						<% end_if %>
						<% end_loop %>
					</div>
					<div class="grid">
						<br>
						$ButterflyText
					</div>
				</div>
			</div>
			<div class="location grid">
				<div>
					<h3>$BrowseTitle</h3>
					$BrowseText
					<% if $BrowseLink %>
					    <% with $BrowseLink %>
					        <a class="btn paleBlue" href="$LinkURL" title="">$Title</a>
					    <% end_with %>
					<% end_if %>
					
				</div>
				<% include AUStateSVG %>
			</div>
		</div>
		<% control getRelatedBlocks(SupportOrganization) %>
		    <% include RelatedBlocks %>
		<% end_control %>
	</main>
