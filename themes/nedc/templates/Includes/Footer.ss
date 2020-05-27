	<!-- Footer -->
	<footer id="footer">
	  <div class="grid inner">
	    <div class="wrap">
	      <img class="noMobile" src="$ThemeDir/img/logo.png">
	      <div class="onlyMobile border">
	        <ul>
	          <li>Need Help?</li>
	        </ul>
	        <a class="boton help" href="#" title="">Get Help</a>
	      </div>
	      <% if $getFooter %>
	         <% loop $getFooter.Filter('Row', 'First') %>
	         	<ul class="accordion">
		         	<% with $TitleLink %>
		         	    <li class="accordionState"><a href="$LinkURL">$Title</a></li>
		         	<% end_with %>
					<% if $ChildrenLink %>
					    <% loop ChildrenLink %>
					    <% with Link %>
					         <li class="accordionInner"><a href="$LinkURL" title="">$Title</a></li>
					    <% end_with %>
					    <% end_loop %>
					<% end_if %>
		        </ul>
	         <% end_loop %>
	     <% end_if %>
	    </div>
	    <div class="wrap">
	      <% if $getFooter %>
	         <% loop $getFooter.Filter('Row', 'Second') %>
	         	<ul class="accordion">
		         	<% with $TitleLink %>
		         	    <li class="accordionState"><a href="$LinkURL">$Title</a></li>
		         	<% end_with %>
					<% if $ChildrenLink %>
					    <% loop ChildrenLink %>
					    <% with Link %>
					         <li class="accordionInner"><a href="$LinkURL" title="">$Title</a></li>
					    <% end_with %>
					    <% end_loop %>
					<% end_if %>
		        </ul>
	         <% end_loop %>
	     <% end_if %>
	    </div>
	    <div class="wrap border">
	       	<% if $getFooter %>
	         <% loop $getFooter.Filter('Row', 'Third') %>
	         	<ul class="accordion">
		         	<% with $TitleLink %>
		         	    <li class="accordionState"><a href="$LinkURL">$Title</a></li>
		         	<% end_with %>
					<% if $ChildrenLink %>
					    <% loop ChildrenLink %>
					    <% with Link %>
					         <li class="accordionInner"><a href="$LinkURL" title="">$Title</a></li>
					    <% end_with %>
					    <% end_loop %>
					<% end_if %>
		        </ul>
	         <% end_loop %>
	     <% end_if %>
	    </div>
	    <div class="wrap">
	      <ul class="noMobile">
	        <li>Need Help?</li>
	      </ul>
	      <a class="boton help noMobile" href="support-help/" title="">Get Help</a>
	      <ul>
	        <li>Follow Us</li>
	      </ul>
	      <div class="social">
	        <a class="facebook" href="$SiteConfig.FacebookURL" target="_blank" title=""></a>
	        <a class="twiter" href="$SiteConfig.TwitterURL" target="_blank" title=""></a>
	        <a class="instagram" href="$SiteConfig.InstagramURL" target="_blank" title=""></a>
	        <a class="linkedin" href="$SiteConfig.LinkedInURL" target="_blank" title=""></a>
	      </div>
	      <img class="onlyMobile" src="$ThemeDir/img/logof.png" alt="" style="margin: 40px auto 0;">
	    </div>
	  </div>
	  <div id="copyright">
	    <div class="grid editor-content">
	    	$SiteConfig.SiteFooterText
	    </div>
	  </div>
	</footer>
	<!-- End Footer -->
