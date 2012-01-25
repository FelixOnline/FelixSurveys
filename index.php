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
<?php
		require('functions.php');
        session_name("felix_sex_survey");
        session_start();

        // mysql_connect("localhost",$user,$pass);
        // mysql_select_db($db);
		
		$local = true;
?>
<body>
    <div class="container">
        <header id="head">
            <h1>Felix Sex Survey 2012</h1>
        </header>
        <div role="main" id="main">
        <?php
        	if (array_key_exists('login', $_POST)) {
        		// attempting to login
				if (!login($_POST['uname'], $_POST['pass'])) {
					echo('login failed error here');
				} else {
					strtolower($_SESSION['felix_sex_survey']['uname'] = $_POST['uname']);
					// Add redirect here if we need to
				}
			}
			
			if (!isloggedin()) {
				// not logged in? display login form
				?>
	            <form method="post" id="loginForm" class="form-horizontal">
	                <legend>Please enter your username/password to continue:</legend>
                    <fieldset class="control-group">
                        <label for="uname">IC Username:</label>
                        <div class="controls">
                            <input type="text" name="uname" />
                        </div>
                    </fieldset>
                    <fieldset class="control-group">
                        <label for="pass">IC Password:</label>
                        <div class="controls">
                            <input type="password" name="pass" />
                        </div>
                    </fieldset>
                    <fieldset class="form-actions">
	                    <input type="submit" value="Login" name="login" id="submitButton" class="btn primary"/>
                    </fieldset>
	            </form>
	            <?php
			} else {
				if (isdone($_SESSION['felix_sex_survey']['uname'])) {
					echo('thank you for filling out message here');
				} elseif (array_key_exists('response', $_POST)) {
					foreach ($_POST as $k => $v) {
						if ($k != "submit") {
							$ks[] = "`".mysql_real_escape_string($k)."`";
							$vs[] = "'".mysql_real_escape_string($v)."'";
						}
					}
					$sql = "INSERT INTO `sexsurvey` (id,".(implode(",",$ks)).") VALUES ('$id',".(implode(",",$vs)).")";
					mysql_query($sql);
					
					echo('thank you for filling out message here');
				} else {
					// Display questions
                    $questions = file_get_contents('questions.json');
                    $questions = json_decode($questions, true);
                    ?>
                        <form method="post">
                            <?php 
                                foreach($questions as $key => $value) { ?>
                                    <fieldset class="control-group" id="<?php echo $key; ?>">
                                        <label><?php echo $value['label']; ?>:</label>
                                        <div class="controls">
                                            <?php
                                                switch($value['type']) {
                                                    case 'dropdown':
                                                        ?>
                                                        <select>
                                                            <?php foreach($value['options'] as $option) { ?>
                                                                <option value="<?php echo $option['value']; ?>">
                                                                    <?php echo $option['label'];?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    <?php break;  
                                                    case 'radio':
                                                        foreach($value['options'] as $options) {
                                                    ?>
                                                        <label class="radio">
                                                            <input type="radio" value="<?php echo $options['value']; ?>">
                                                            <?php echo $options['label']; ?>
                                                        </label>
                                                    <?php 
                                                        }
                                                        break;
                                                }
                                            ?>
                                        </div>
                                    </fieldset>
                            <?php } ?>
                        </form>
					<?php
				}
			}
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
