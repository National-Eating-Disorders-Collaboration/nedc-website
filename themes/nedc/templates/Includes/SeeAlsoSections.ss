        <% if $SeeAlsoSection %>
        <div id="seeAlso">
            <div class="grid">
                <h2>See also</h2>
                <div id="slick-slide" class="inner">
                    <% loop $SeeAlsoSection %>
                        <div class="wrap">
                            <% with $Link %>
                            <h3 class="anchorTitle">$Title</h3>
                            <% end_with %>
                            <p>$Teaser.RAW.LimitWordCount(20)</p>
                            <% with $Link %>
                            <a href="$LinkURL">Read more</a>
                            <% end_with %>
                        </div>
                    <% end_loop %>
                </div>
            </div>
        </div>
        <% end_if %>
