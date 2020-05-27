	<main id="main-wrapper-page">
	<div id="research">
		<div class="search">
			<div class="grid">
				<ul id="breadcrumb">
					<li><a href="$BaseHref"></a></li>
					<li><a href="$Link" title="">Research Database & Resources</a></li>
				</ul>
				<h1>Research Database & Resources</h1>
				<div class="editor-content">$Content</div>
				$SearchForm
				<div class="editor-content">$SearchInstruction</div>
			</div>
		</div>
		<div id="category" class="grid tabs">
			<h2>Browse by</h2>
			<ul>
				<li><a class="btn darkBlue" href="#nedc-resources" title="$Button1">$Button1</a></li> 
				<li><a class="btn darkBlue" href="#audience" title="$Button2">$Button2</a></li>
				<li><a class="btn darkBlue" href="#topics" title="$Button3">$Button3</a></li>
				<li><a class="btn darkBlue" href="#disorders" title="$Button4">$Button4</a></li>
			</ul>
			
			<div class="flex" id="nedc-resources">
				<% loop $NEDCResources %>
				<a href="$Link">
					<% if $Thumbnail %>
					<img src="$Thumbnail.AbsoluteLink" alt="$Title" />
					<% end_if %>
					$Title
				</a>
				<% end_loop %>
			</div>
			
			<div class="flex" id="audience">
				<% loop $Audience %>
				<a href="$Link">
					<% if $Thumbnail %>
					<img src="$Thumbnail.AbsoluteLink" alt="$Title" />
					<% end_if %>
					<p>$Title</p>
				</a>
				<% end_loop %>
			</div>
			<div class="flex" id="topics">
				<% loop $Topics %>
				<a href="$Link">
					<% if $Thumbnail %>
					<img src="$Thumbnail.AbsoluteLink" alt="$Title" />
					<% end_if %>
					<p>$Title</p>
				</a>
				<% end_loop %>
			</div>
			<div class="flex" id="disorders">
				<% loop $Disorders %>
				<a href="$Link">
					<% if $Thumbnail %>
					<img src="$Thumbnail.AbsoluteLink" alt="$Title" />
					<% end_if %>
					<p>$Title</p>
				</a>
				<% end_loop %>
			</div>
		</div>
		<div id="studies" class="grid">
			<div class="latest">
				<h3>Latest Research</h3>
				<a href="$Link(latest-research)" title="">View all</a>
				<% loop $LatestResearch %>
				<div class="info">
					<p>$Title <a href="$Link">Read</a></p>
					<span>$Year</span>
				</div>
				<% end_loop %>
			</div>
			<div class="light">
				<div class="latest">
					<h3>Australian Studies</h3>
					<a href="$Link(current-australian-studies)" title="">View all</a>
					<% loop $CurrentAustralianStudies %>
					<div class="info">
						<p><a href="$Link">$Title</a></p>
						<span>$ProjectStartDate.Month $ProjectStartDate.Year</span>
					</div>
					<% end_loop %>
				</div>
				<% if $SubmitStudies %>
				<% with $SubmitStudies %>
				<div class="current">
					<img src="$ThemeDir/img/chat.svg">
					<h4>$Title</h4>
					<p>$Description</p>
					$Link
					<% with Button %>
					    <a class="btn darkBlue" href="$LinkURL" title="">$Title</a>
					<% end_with %>
				</div>
				<% end_with %>
				<% end_if %>
			</div>
		</div>
	</div>
	</main>
