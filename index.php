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
    <meta name="description" content="">

    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet/less" type="text/css" href="css/style.less">
    <script src="js/less-1.2.0.min.js"></script>

    <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

    <!-- All JavaScript at the bottom, except this Modernizr build incl. Respond.js
       Respond is a polyfill for min/max-width media queries. Modernizr enables HTML5 elements & feature detects; 
       for optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ -->
    <script src="js/libs/modernizr-2.0.6.min.js"></script>
</head>

        session_name("felix_sex_survey");
        session_start();

        mysql_connect("localhost",$user,$pass);
        mysql_select_db($db);
<body>
    <div class="container">
        <header id="head">
            <h1>Felix Sex Survey 2012</h1>
        </header>
        <div role="main" id="main">
        <?php
            if (!isset($_SESSION['felix_sex_survey']) || !$_SESSION['felix_sex_survey']['uname']) {
                if ($_POST['login']) {
                    if (pam_auth($_POST['uname'],$_POST['pass'])) {
                        $_SESSION['felix_sex_survey'] = strtolower($_POST['uname']);
                    }
                    else
                        echo "<p>Authentication failed. Please go back and try again.</p>";
                    }
                else {
        ?>
            <form method="post" id="loginForm">
                <p>Please enter your username/password to continue:</p>
                <table>
                    <tr><td><label for="uname">IC Username:</label></td><td><input type="text" name="uname" /></td></tr>
                    <tr><td><label for="pass">IC Password:</label></td><td><input type="password" name="pass" /></td></tr>
                    <tr><td></td><td><input type="submit" value="Login" name="login" id="submitButton"/></td></tr>
                </table>
            </form>	
        <?php
                }
        }
    if (isset($_SESSION['felix_sex_survey'])) {
        $id = sha1(md5($_SESSION['felix_sex_survey']));
        if ($_POST['submit']) {
            foreach ($_POST as $k => $v) {
                if ($k != "submit") {
                    $ks[] = "`".mysql_real_escape_string($k)."`";
                    $vs[] = "'".mysql_real_escape_string($v)."'";
                }
            }
            $sql = "INSERT INTO `sexsurvey` (id,".(implode(",",$ks)).") VALUES ('$id',".(implode(",",$vs)).")";
            mysql_query($sql);
        }
        $sql = "SELECT COUNT(*) FROM sexsurvey WHERE id='$id'";
        $rsc = mysql_query($sql);
        list($match) = mysql_fetch_array($rsc);
        if ($match > 0) {
            echo "<div id='thankyou'><img src='thumbsup.jpg' width='200px'/><p>Thank you for submitting your answers to this survey. Your data will be deleted as soon after the survey as results have been aggregated.</p></div>";
        }
        else {
?>
        <form method="post">

        </form>
<?php
        } }
?>

        </div>
        <footer>
			<p>&copy; Felix Imperial <a href="#head">Top of page</a></p>
        </footer>
    </div>

    <!-- JavaScript at the bottom for fast page loading -->

    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>


    <!-- scripts concatenated and minified via build script -->
    <script defer src="js/plugins.js"></script>
    <script defer src="js/script.js"></script>
    <!-- end scripts -->


    <!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
       mathiasbynens.be/notes/async-analytics-snippet -->
    <script>
        var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>

    <!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
       chromium.org/developers/how-tos/chrome-frame-getting-started -->
    <!--[if lt IE 7 ]>
        <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
        <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
    <![endif]-->

</body>
</html>
