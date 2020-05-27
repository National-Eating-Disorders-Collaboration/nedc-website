<html>
    <body>
		<div style="background-color: #F2F2F2; margin: 0 auto; width: 90%;">
			<div style="width: 100%; margin: 0 auto; height: 90px; background-color:#fff;">
				<img style="max-height: 70px; width: auto; float: left; margin-left: 9px;" src="$BaseHref/themes/nedc/img/logolr.png"/>
			</div>

			<div style="padding: 5%">
				<p>Hi Admin,</p>
				<p><b>$Member</b> has shared an event in <a href="$BaseHref">nedc.com.au</a>. To review or accept this, you can go to the CMS and choose 'published' and save. Here are the summary of the event they shared:</p>
		        <h2 style="font-size:1.1em;">Title:</h2>
		        <p style="font-size:1em;">$Title</p>

		        <h2 style="font-size:1.1em;">About</h2>
		        <p style="font-size:1em;" >$About</p>

		          <h2 style="font-size:1.1em;">Event Audience</h2>
		        <p style="font-size:1em;" >$EventAudience</p>

		       	<h2 style="font-size:1.1em;">Rquirements</h2>
		        <p style="font-size:1em;">$Requirements</p>

				<h2 style="font-size:1.1em;">When</h2>
				<% loop $DateForEmail %>
				<br>
				<p style="font-size:1em;">Date: $Date</p>
				<p style="font-size:1em;">Start Time: $StartTime</p>
				<p style="font-size:1em;">End Time: $EndTime </p>
				<% end_loop %>

				<h2 style="font-size:1.1em;">Where</h2>
				<p style="font-size:1em;">Address: $Address, $State</p>

				<h2 style="font-size:1.1em;">Event </h2>
				<p style="font-size:1em;">Event Type: $Category </p>
				<p style="font-size:1em;">Price: $$Price</p>
				<p style="font-size:1em;">Payment Form: <a href="$ExternalForm" target="_blank">$ExternalForm</a></p>

				<h2 style="font-size:1.1em;">Speaker</h2>
				<p style="font-size:1em;">Name: $Name</p>
				<p style="font-size:1em;">Position: $Position</p>
				<p style="font-size:1em;">Company: $Company</p>

				<h2 style="font-size:1.1em;">Contact Person</h2>
		        <p style="font-size:1em;" ><i>Email Address:&nbsp;</i><a href="mailto:$Email">$Email</a></p>
		        <p style="font-size:1em;" ><i>Contact Number:&nbsp;</i>$Contact</p>
		        <p style="font-size:1em;" ><i>Collaboration Images:&nbsp;</i><% if $Images %>
		                $Images
		        	<% end_if %></p>
			</div>

		</div>
    </body>
</html>
