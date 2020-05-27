	<header id="header">
		<div id="headerFirst">
			<div class="grid">
				<ul>
					<li><a href="/about-us">About us</a></li>
					<li><a href="/contact-us">Contact us</a></li>
					<li><a href="/get-help">Get Help</a></li>
					<li><a href="/news">News</a></li>
					<li><a class="js__open_search"><img src="$ThemeDir/img/search.svg"></a></li>
				</ul>
			</div>
		</div>
		<div id="headerSecond">
			<div class="grid wrap">
				<a class="logo" href="$BaseHref">
					<img src="$ThemeDir/img/logo.png">
					<img src="$ThemeDir/img/logom.png">
				</a>
				<ul class="nav main-menu">
					<% loop Menu(1) %>
					    	<li><a class="arrow" href="$Link">$Title</a>
								<ul class="expanded">
								<% if Children %>
								    <% loop $Children %>
								       <li><a class="$LinkingMode" href="$Link">$MenuTitle</a></li>
								    <% end_loop %>
								<% end_if %>
								<% if  $ClassName == 'ResearchAndResourcesHolder' %>
								    <li><a  href="/share-studies">Share Your Research</a></li> 
								    <li><a  href="/research-and-resources/current-australian-studies">Paticipate in Studies</a></li> 
								 <% end_if %>
								 <% if  $ClassName == 'ProfessionalDevelopmentPage' %>
								    <li><a  href="/professional-development/SearchForm?State=&isOwn=&Type=&action_results=Browse+All">Upcoming Events</a></li>
									<li><a href="/e-learning">E-Learning</a></li>
								 <% end_if %>
								</ul>
							</li>
					<% end_loop %>
				</ul>
				<div class="user">
					<% if not $CurrentMember %>
					<a class="login" href="/Security/login">Log in</a>
					<a class="beMember" href="register/">Become a member</a>
					<% else %>
					<a class="login js__dropdown_login" >$CurrentMember.FirstName</a>
					<ul class="dashboard_dropdown">
						<li><a href="/member/dashboard" title="">Dashboard</a></li>
						<li><a href="/Security/logout" title="">Logout</a></li>
					</ul>
					<% end_if %>
				</div>
				<a class="search js__open_search"  title=""><img src="$ThemeDir/img/searchm.svg" alt=""></a>
				
			</div>
			<div id="menu-mobile-wrapper">
				<ul id="nedc-menu-mobile">
					<% loop Menu(1) %>
					    <li class="item-menu <% if $Children %> has-submenu <% end_if %>">
					    	<div class="link-wrapper">
						    	<a href="$Link">$MenuTitle.XML</a>
						    	<% if $Children %> <span class="js__arrow"></span> <% end_if %>
						    </div>

							<% if $Children %>
							    <ul class="sb-menu">
							    	<% loop $Children %>
							    	    <li class="item-menu-2">
							    	    	<a class="parent" href="$Link"> $MenuTitle.XML</a>
											<% if Children %>
											<ul class="submenu">
											    <% loop $Children %>
													<li class="item-menu-3">
														<div class="link-wrapper">
															<% if $ClassName == 'EatingDisordersArticleSubCategory' %>
															    <a class="parent-level-2"> $MenuTitle.XML</a>
															    <% else %>
															    <a class="parent-level-2" href="$Link"> $MenuTitle.XML</a>
															<% end_if %>
															<% if $Children %> <span class="js__arrow_child"></span> <% end_if %>
														</div>
														<% if Children %>
															<ul class="sub-menu-2">
																<% loop $Children %>
																    <li><a href="$Link">$MenuTitle.XML</a></li>
																<% end_loop %>
															</ul>
														<% end_if %>
													</li>
												<% end_loop %>
											</ul>
											<% end_if %>
							    	    </li>
							    	<% end_loop %>
							    </ul>
							<% end_if %>
					    </li>
					<% end_loop %>
				</ul>
				<div class="menu-close">
					<span class="icon"> <i class="fa fa-times" aria-hidden="true"></i> </span>
				</div>
			</div>
			<div id="search-form">
				<div class="grid">
					$GlobalSearch
					<a class="js__close_search"><i class="fa fa-close"></i></a>
				</div>
			</div>
		</div>
	</header>
