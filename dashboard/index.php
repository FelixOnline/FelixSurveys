<?php require('../db.php'); ?>
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

    <title><?php echo SURVEY_NAME; ?> - Response Dashboard</title>
    <meta name="description" content="">

    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:400,700,400italic,700italic|Noto+Serif:400,700,400italic,700italic|Sorts+Mill+Goudy:400,400italic' rel='stylesheet' type='text/css'>

    <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

    <!-- All JavaScript at the bottom, except this Modernizr build incl. Respond.js
       Respond is a polyfill for min/max-width media queries. Modernizr enables HTML5 elements & feature detects; 
       for optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ -->
    <script src="../js/libs/modernizr-2.0.6.min.js"></script>
</head>

<body>
        <div id="head-top">
            <div class="container header">
                <a href="http://www.felixonline.co.uk">Back to Felix Online</a> - <a href="../">Back to survey</a>
            </div>
        </div>
        <header id="head">
            <div class="container header">
            <img src="../img/logo.png" alt="Felix" />
            Felix
        </div>
        </header>
        <div class="main-container">
            <div class="container">
  <h1><?php echo SURVEY_NAME; ?> - Survey is <?php if(ACTIVE): ?>OPEN<?php else: ?>CLOSED - <a href="output.php">Download responses</a><?php endif; ?></h1>

            <div id="counter">
                <?php
                    $sql = "SELECT COUNT(*) FROM `".TABLE_PREFIX."_responses`";
                    $rsc = mysql_query($sql);
                    list($count) = mysql_fetch_array($rsc);
                ?>
                    <h2><?php echo $count; ?></h2>
                <p id="info">responses so far</p><br><br>
                <img src="graph.png" style="width: 100%">
                <br><br>
            </div>
    </div>
            <footer>
                <div class="container">
                    <a href="http://felixonline.co.uk" title="Go back to Felix Online"><img class="footer-right" src="../img/logo.png" alt="FELIX"/></a>
                    <p style="float: right;">&copy; Felix Imperial <a href="#head">Top of page</a><br>Survey software by Philip Kent and Jonathan Kim<br>Use of this website indicates acceptance of cookies.</p>
                </div>
            </footer>
    </div>

    <!-- JavaScript at the bottom for fast page loading -->

    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../js/libs/jquery-1.7.1.min.js"><\/script>')</script>

</body>
</html>
