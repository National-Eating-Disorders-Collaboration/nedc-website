<html>
    <body>
		<div style="background-color: #F2F2F2; margin: 0 auto; width: 90%;">
			<div style="width: 100%; margin: 0 auto; height: 90px; background-color:#fff;">
				<img style="max-height: 70px; width: auto; float: left; margin-left: 9px;" src="$BaseHref/themes/nedc/img/logolr.png"/>
			</div>

			<div style="padding: 5%">
				<p>Hi Admin,</p>
				<p><b>$Member</b> has shared a case studies in <a href="$BaseHref">nedc.com.au</a>. To review or accept this, you can go to the CMS and choose 'accept' and save. Here are the summary of the event they shared:</p>
		        <h2 style="font-size:1.1em;">Title:</h2>
		        <p style="font-size:1em;">$Title</p>

		        <h2 style="font-size:1.1em;">Author</h2>
		        <p style="font-size:1em;" >$Author</p>

		       	<h2 style="font-size:1.1em;">Description</h2>
		        <p style="font-size:1em;">$Description</p>

		        <h2 style="font-size:1.1em;">Participants</h2>
		        <p style="font-size:1em;">$Participants</p>

		        <h2 style="font-size:1.1em;">What's Involved</h2>
		        <p style="font-size:1em;">$WhatsInvolved</p>


				<p style="font-size:1em;">Funding Source: $FundingSource</p>
				<p style="font-size:1em;">Institution: $Institution</p>
				<p style="font-size:1em;">Project Start Date: $ProjectStartDate.Long </p>
				<p style="font-size:1em;">Category: $Category</p>
				<p style="font-size:1em;">Ethics Approval Number: $EthicsApprovalNumber</p>
				<p style="font-size:1em;">Location: $Location</p>
				<p style="font-size:1em;">Contact Details: $ContactDetails</p>

		        <p style="font-size:1em;" ><i>Case Study File:</i><% if $Files %>
		           $Files
		        <% end_if %></p>
			</div>

		</div>
    </body>
</html>
