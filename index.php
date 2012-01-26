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

        mysql_connect("localhost", 'root', '');
        mysql_select_db('sexsurvey');
		
		$local = true;
?>
<body>
    <div class="container">
        <header id="head">
            <h1>Felix Sex Survey 2012</h1>
        </header>
        <div role="main" id="main">
            <?php include('introduction.php'); ?>
            <?php
                if (array_key_exists('login', $_POST)) {
                    // attempting to login
                    if (!login($_POST['uname'], $_POST['pass'])) {
                        ?><div class="alert alert-error">Sorry, your account details were not accepted. Please try again.</div><?php
                    } else {
                        strtolower($_SESSION['felix_sex_survey']['uname'] = $_POST['uname']);
                        // Add redirect here if we need to
                    }
                }
                
                if (!isloggedin()) {
                    // not logged in? display login form
                    ?>
                        <form method="post" id="loginForm" class="form-horizontal">
                            <legend>Please enter your username/password to continue</legend>
                            <p>This information is only required to confirm that you have not yet completed this survey. It will <strong>not</strong> be tied to your response. See above for further details.</p>
                            <fieldset class="control-group">
                                <label for="uname">IC Username:</label>
                                <div class="controls">
                                    <input type="text" name="uname" id="uname" />
                                </div>
                            </fieldset>
                            <fieldset class="control-group">
                                <label for="pass">IC Password:</label>
                                <div class="controls">
                                    <input type="password" name="pass" id="pass" />
                                </div>
                            </fieldset>
                            <fieldset class="form-actions">
                                <input type="submit" value="Login" name="login" id="submitButton" class="btn primary"/>
                            </fieldset>
                        </form>
                    <?php
                } else {
                    if (isdone($_SESSION['felix_sex_survey']['uname'])) {
                    	?>
                        <div class="alert alert-block alert-success">
                            <h4 class="alert-heading">Thank you!</h4>
                            Your response has already been recorded, thank you for filling out the survey. Results and analysis will be published in Felix on February 17, after which your data will be deleted.
                        </div>
                        <?php
                    } elseif(array_key_exists('response', $_POST)) {
                        if(array_key_exists('response', $_POST)) {
                        	$troll = 1;
                        	if ($_POST['department'] == getdept($_SESSION['felix_sex_survey']['uname']) || getdept($_SESSION['felix_sex_survey']['uname']) == 'Unknown') {
                        		$troll = 0;
                        	}
                            addresponse(json_encode($_POST), $troll);
                            markasdone($_SESSION['felix_sex_survey']['uname']);
                        } ?>
                        <div class="alert alert-block alert-success">
                            <h4 class="alert-heading">Thank you!</h4>
                            Your response has been recorded, thank you for filling out the survey. Results and analysis will be published in Felix on February 17, after which your data will be deleted.
                        </div>
                    <?php } else {
                        // Display questions
                        $questions = file_get_contents('questions.json');
                        $questions = json_decode($questions, true);
                        ?>
                            <?php include('backgroundinfo.php'); ?>
                            <form method="post" class="form-horizontal">
                                <?php 
                                    foreach($questions as $key => $value) { 
                                        if($value['type'] == 'header') { ?>
                                            <legend><?php echo $value['label'];?></legend>
                                        <?php } else { 
                                            $classes = array('control-group');
                                            if(array_key_exists('dependant', $value)) {
                                                $classes[] = 'hidden';
                                                $classes[] = 'dependant';
                                            }
                                            ?>
                                        <fieldset id="<?php echo $key; ?>" class="<?php outputclasses($classes); ?>" <?php if(array_key_exists('dependant', $value)) { ?> data-dependant="<?php echo $value['dependant']['id']; ?>" data-answer="<?php echo $value['dependant']['answer']; ?>"<?php } ?>>
                                            <label<?php if ($value['type'] !== 'radio'): ?> for="cont_<?php echo $value['name']; ?>"<?php endif; ?>><?php echo $value['label']; ?></label>
                                            <div class="controls">
                                                <?php
                                                    switch($value['type']) {
                                                        case 'dropdown':
                                                            ?>
                                                                <select name="<?php echo $value['name']; ?>" id="cont_<?php echo $value['name']; ?>">
                                                                <?php foreach($value['options'] as $option) { ?>
                                                                    <option value="<?php echo $option['value']; ?>"<?php if(array_key_exists('default', $value) && $value['default'] == $option['value']): ?> selected="selected"<?php endif; ?>>
                                                                        <?php echo $option['label'];?>
                                                                    </option>
                                                                <?php } ?>
                                                            </select>
                                                        <?php break;  
                                                        case 'radio':
                                                            foreach($value['options'] as $options) {
                                                        ?>
                                                            <label class="radio">
                                                            <input type="radio" value="<?php echo $options['value']; ?>" name="<?php echo $options['name']; ?>"<?php if(array_key_exists('default', $value) && $value['default'] == $options['value']): ?> checked="checked"<?php endif; ?>>
                                                                <?php echo $options['label']; ?>
                                                            </label>
                                                        <?php 
                                                            }
                                                            break;
                                                        case 'textbox':
                                                            ?>
                                                            <textarea name="<?php echo $value['name']; ?>" id="cont_<?php echo $value['name']; ?>"></textarea>
                                                        <?php break;
                                                    }
                                                ?>
                                            </div>
                                        </fieldset>
                                        <?php } 
                                    } ?>
                                <fieldset class="form-actions">
                                    <a data-toggle="modal" class="btn primary xlarge" href="#submit-form" >Submit</a>
                                </fieldset>
                                
								<div id="submit-form" class="modal hide fade" >
								    <div class="modal-header">
								        <a href="#" class="close" data-dismiss="modal">×</a>
								        <h3>Submit survey</h3>
								    </div>
								    <div class="modal-body">
								        <p>Are you sure you would like to submit this survey now?</p>
								        <p>As this survey is anonymous, you will not be able to get back or edit your responses after they have been submitted.</p>
								    </div>
								    <div class="modal-footer">
								        <input type="submit" class="btn primary xlarge" value="Yes" name="response"/>
								        <a href="#" data-dismiss="modal" class="btn xlarge">No</a>
								    </div>
								</div>

                            </form>
                        <?php
                    }
                }
            ?>
        </div>
        <footer>
        	<a href="http://felixonline.co.uk" title="Go back to Felix Online"><img class="footer-right" src="img/title.jpg" alt="FELIX" /></a>
			<p>&copy; Felix Imperial <a href="#head">Top of page</a></p>
        </footer>
    </div>

    <!-- JavaScript at the bottom for fast page loading -->

    <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

    <script src="js/bootstrap-transition.js"></script>
    <script src="js/bootstrap-modal.js"></script>
    <script src="js/bootstrap-tooltip.js"></script>
    <script src="js/bootstrap-popover.js"></script>

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
