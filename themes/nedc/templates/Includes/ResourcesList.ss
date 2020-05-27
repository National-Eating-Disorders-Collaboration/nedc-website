
					<div class="result">
						<% if $Resources %>
							<% if not $hideTotalResultCount %>
						    <%-- <span>Showing $Resources.CurrentPage - $Resources.TotalPages of $Resources.TotalItems total results</span> --%>
						    $resultCounter($Resources.TotalItems, $Resources.CurrentPage, 12)
							<% end_if %>
						    <% if not $hideSortBy %>
						    <div>Sort by
							<%-- $Form.Fields.fieldByName(sort) --%>
								<select name="sort" id="sort_resources">
									<option value="">Sort By</option>
									<option value="Recent">Recent</option>
									<option value="Title">Title</option>
								</select>
							</div>
						    <% end_if %>
						<% end_if %>
					</div>
					<% if $Resources %>
					<% loop $Resources %>
					<div class="bookmark">
						<div>
							<div>
								<h4 class="resource-title"><a href="$Link">$Title</a></h4>
								<% if $ArticleTypes %>
								    <p>$ArticleTypes.First.Name</p>
								 <% else %>
								 <p>Uncategorised</p>
								<% end_if %>
								
							</div>
							<% if $CurrentMember %>
							<% if $isBookmarked %>
							<a class="btn paleBlue btnBookmark active" href="#" title="Bookmark" data-type="resource" data-id="$ID">Bookmarked!</a>
							<% else %>
							<a class="btn paleBlue btnBookmark" href="#" title="Bookmark" data-type="resource" data-id="$ID"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
							<% end_if %>
							<% else %>
							<a class="btn paleBlue" href="/Security/login" title="Login to Bookmark"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
							<% end_if %>
						</div>
						<% if $isNEDC %>
						<span>NEDC Resource</span>
						<% end_if %>
					</div>
					<% end_loop %>

					<% if $Resources.MoreThanOnePage %>
					<div id="pagination">
				  		<% if $Resources.NotFirstPage %>
			  			<a class="prev" href="$Resources.PrevLink" title="">Previous</a>
				  		<% end_if %>
				  		<% loop $Resources.PaginationSummary(10) %>
		  				<% if Link %>
	  					<a <% if $CurrentBool %>class="active"<% end_if %> href="$Link" title="Page $PageNum">$PageNum</a>
		  				<% else %>
	  					...
		  				<% end_if %>
				  		<% end_loop %>
				  		<% if $Resources.NotLastPage %>
			  			<a class="next" href="$Resources.NextLink" title="">Next</a>
				  		<% end_if %>

					    <%-- if $Resources.NotFirstPage %>
					     <a class="prev" href="$Resources.PrevLink" title="">Previous</a>
					    <% end_if %>
				        <% loop $Resources.Pages %>
				        <a <% if $CurrentBool %>class="active"<% end_if %> href="$Link" title="Page $PageNum">$PageNum</a>
				        <% end_loop %>
					    <% if $Resources.NotLastPage %>
					    <a class="next" href="$Resources.NextLink" title="">Next</a>
					    <% end_if --%>
					</div>
					<% else %>
					<div id="pagination"></div>
					<% end_if %>
					<% else %>
					<div class="result">
						<span>No results found.</span>
					</div>
					<div id="pagination"></div>
					<% end_if %>
