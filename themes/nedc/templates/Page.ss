<!DOCTYPE html>
<html>

	<head>
		<% base_tag %>
		<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %></title>
		<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="apple-touch-icon" sizes="57x57" href="$ThemeDir/img/favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="$ThemeDir/img/favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="$ThemeDir/img/favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="$ThemeDir/img/favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="$ThemeDir/img/favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="$ThemeDir/img/favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="$ThemeDir/img/favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="$ThemeDir/img/favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="$ThemeDir/img/favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="$ThemeDir/img/favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="$ThemeDir/img/favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="$ThemeDir/img/favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="$ThemeDir/img/favicon/favicon-16x16.png">
		<link rel="manifest" href="$ThemeDir/img/favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="$ThemeDir//ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		$MetaTags(false)
		<!-- Global Site Tag (gtag.js) - Google Analytics (ONLY FOR LIVE)-->
		<% if $GAID %>
		    <script async src="https://www.googletagmanager.com/gtag/js?id=$GAID"></script>
			<script>
			  window.dataLayer = window.dataLayer || [];
			  function gtag(){dataLayer.push(arguments);}
			  gtag('js', new Date());

			  gtag('config', '$GAID');
			</script>
		<% end_if %>
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-PJZS8MJ');</script>
		<!-- End Google Tag Manager -->
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDhtWVKaSluuvhiKeo6F0ep6hw7fZBhZl0&libraries=places"></script>
	</head>
	<body>
		<% include Header %>
		<main id="main-wrapper-page">
			$Layout
		</main>
		
		<% include Footer %>
		<% include Survey %>
	</body>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PJZS8MJ"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
</html>
