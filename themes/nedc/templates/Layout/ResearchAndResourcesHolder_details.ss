	<main id="researchDetails">
			<ul id="breadcrumb" class="grid">
			<li><a href="$BaseHref"></a></li>
			<li><a href="$Link" title="">Research Database & Resources </a></li>
			<li><a title="">$Resource.Title.LimitWordCount(16, "...")</a></li>
		</ul>

		<% with $Resource %>
		<div id="wrapTitle">
			<div class="grid">
				<h1 class="">$Title</h1>
			</div>
		</div>
		<div class="grid wrapflex">
			<div class="clear-div"></div>
			<div class="left">
				<% if not isAustralianCaseStudies %>
				    <h3>About this resource</h3>
				    <% else %> 
				    <h3>About this study</h3>
				<% end_if %>
				
				<div class="editor-content">
					<p>$Description</p>
				</div>
				<div class="wrap">
					<% if $Author %><div class="data"><% if isAustralianCaseStudies %><span>Research Team</span><% else %><span>Author</span><% end_if %><span>$Author</span></div><% end_if %>
					<% if $Institution %><div class="data"><span>Institution</span><span>$Institution</span></div><% end_if %>
					<% if $FullText %><div class="data"><span>Has FullText ? </span><span>Yes</span></div><% end_if %>
					<% if $Format %><div class="data"><span>Format</span><span>$Format</span></div><% end_if %>
					<% if $Journal %><div class="data"><span>Journal</span><span>$Journal</span></div><% end_if %>
					<% if $Volume %><div class="data"><span>Volume</span><span>$Volume</span></div><% end_if %>
					<% if $PDFAvailable %><div class="data"><span>PDF Available ?</span><span>$PDFAvailable.Nice</span></div><% end_if %>
					<% if $Publisher %><div class="data"><span>Publisher</span><span>$Publisher</span></div><% end_if %>
					<% if $Year %><div class="data"><span>Year</span><span>$Year</span></div><% end_if %>
					<% if $Country %><div class="data"><span>Country</span><span>$Country</span></div><% end_if %>
					<% if $Free %><div class="data"><span>Is Free ?</span><span>Yes</span></div><% end_if %>
					<% if $AvailableFrom %><div class="data"><span>AvailableFrom</span><span>$AvailableFrom</span></div><% end_if %>
					<% if $Address %><div class="data"><span>Address</span><span>$Address</span></div><% end_if %>
					<% if $Phone %><div class="data"><span>Phone</span><span>$Phone</span></div><% end_if %>
					<% if $Fax %><div class="data"><span>Fax</span><span>$Fax</span></div><% end_if %>
					<% if $Website %><div class="data"><span>Website</span><span><a href="$Website" title="" style="color: #1D687E;">$Website</a></span></div><% end_if %>
					<% if $Publication %><div class="data"><span>Publication</span><span>$Publication</span></div><% end_if %>
					<% if $EthicsApprovalNumber %><div class="data"><span>Ethics Approval Number</span><span>$EthicsApprovalNumber</span></div><% end_if %>
					<% if $FundingSource %><div class="data"><span>Funding Source</span><span>$FundingSource</span></div><% end_if %>
					<% if $ProjectStartDate %><div class="data"><span>Project Start Date</span><span>$ProjectStartDate.Long</span></div><% end_if %>
					<% if $ProjectEndDate %><div class="data"><span>Project End Date</span><span>$ProjectEndDate.Long</span></div><% end_if %>
					<% if $Participants %><div class="data"><span>Participants</span><span>$Participants</span></div><% end_if %>
					<% if $WhatsInvolved %><div class="data"><span>Whats Involved</span><span>$WhatsInvolved</span></div><% end_if %>
					<% if $Location %><div class="data"><span>Location</span><span>$Location</span></div><% end_if %>
					<% if $ContactDetails %><div class="data a-blue p-gray"><span>Contact Details</span><span>$ContactDetails</span></div><% end_if %>
				</div>
			</div>
			<aside class="move-on-mobile" data-append=".wrapflex .clear-div">
				<% if not $isAustralianCaseStudies %>
					<% if $ExternalLink %>
					<a class="btn darkBlue" href="$ExternalLink.RAW" target="_blank">View Online</a>
					<% else_if $DownloadableFile %>
					<a class="btn darkBlue" href="$DownloadableFile.AbsoluteLink" target="_blank">View</a>
					<% end_if %>
					<% if $CurrentMember %>
					<% if $isBookmarked %>
					<a class="btn paleBlue btnBookmark active" href="#" title="Bookmark" data-type="resource" data-id="$ID">Bookmarked!</a>
					<% else %>
					<a class="btn paleBlue btnBookmark" href="#" title="Bookmark" data-type="resource" data-id="$ID"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
					<% end_if %>
					<% else %>
					<a class="btn paleBlue" href="/Security/login"><i class="fa fa-star" aria-hidden="true"></i> Bookmark</a>
					<% end_if %>
				<% end_if %>
				<div class="flex">
					<a class="f" href="https://www.facebook.com/sharer/sharer.php?u=$AbsoluteLink" title="Share on Facebook" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=480')"></a>
					<a class="t" href="https://twitter.com/share?url=$AbsoluteLink" title="Share on Twitter" onclick="return !window.open(this.href, 'Facebook', 'width=640,height=480')"></a>
					<a class="m" href="" title="" disabled="disabled"></a>
					<a class="p" href="javascript:window.print()" title="Print"></a>
				</div>
			</aside>
		</div>
		<% end_with %>
		$SeeAlso
	</main>
