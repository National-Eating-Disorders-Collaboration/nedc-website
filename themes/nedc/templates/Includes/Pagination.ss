

	<% if $Results.MoreThanOnePage %>
        <div id="pagination">
            <% if $Results.NotFirstPage %>
           		<a class="prev" href="$Results.PrevLink" title="">Previous</a>
            <% end_if %>
            <% loop $Results.PaginationSummary(10) %>
                <% if $Link %>
                     <a href="$Link" class=" <% if $CurrentBool %> active <% end_if %>">
                        $PageNum
                    </a>
                    <% else %>
                        ...
                <% end_if %>
            <% end_loop %>
            <% if $Results.NotLastPage %>
            	<a class="next" href="$Results.NextLink" title="">Next</a>
            <% end_if %>
        </div>
    <% end_if %>
