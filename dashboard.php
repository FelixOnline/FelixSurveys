<?php
	require('functions.php');
    require('db.php');
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <!-- Use the .htaccess and remove these lines to avoid edge case issues.
       More info: h5bp.com/b/378 -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Felix Sex Survey</title>
    <meta name="description" content="The Felix Online Sex Survey 2012">
    <meta property="og:image" content="http://felixonline.co.uk/img/sexsurvey.jpg"/>
    <meta property="og:title" content="Felix Sex Survey 2012"/>
    <meta property="og:type" content="website"/>

    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

    <!-- All JavaScript at the bottom, except this Modernizr build incl. Respond.js
       Respond is a polyfill for min/max-width media queries. Modernizr enables HTML5 elements & feature detects; 
       for optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ -->
    <script src="js/libs/modernizr-2.0.6.min.js"></script>

</head>
<body>
    <div class="container">
        <header id="head">
            <h1>Felix Sex Survey 2012 Responses</h1>
        </header>
        <div role="main" id="main">
        	<?php
        		$sql = "SELECT COUNT(*) FROM `sexsurvey_responses`";
				$rsc = mysql_query($sql);
				list($match) = mysql_fetch_array($rsc);
			?>
        	<legend>Number of responses so far: <b><?php echo $match; ?></b></legend>
        </div>
        <footer>
        	<a href="http://felixonline.co.uk" title="Go back to Felix Online"><img class="footer-right" src="img/title.jpg" alt="FELIX" /></a>
			<p>&copy; Felix Imperial <a href="#head">Top of page</a></p>
        </footer>
    </div>

    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7 ]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
        <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->

</body>
</html>
