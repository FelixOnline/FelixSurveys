<?php
	require('db.php');
	require('functions.php');
	session_name(COOKIE);
	session_start();

	$loginfailed = false;

	if(!defined('ACTIVE')) define('ACTIVE', true);
	if (array_key_exists('login', $_POST)) {
		// attempting to login
		if (!login($_POST['uname'], $_POST['pass'])) {
			$loginfailed = true;
		} else {
			$_SESSION[COOKIE]['uname'] = strtolower($_POST['uname']);
			// Add redirect here if we need to
		}
	}
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

	<title><?php echo SURVEY_NAME; ?></title>
	<meta name="description" content="<?php echo SURVEY_NAME; ?>">
	<meta property="og:title" content="<?php echo SURVEY_NAME; ?>"/>
	<meta property="og:type" content="website"/>

	<meta property="og:image" content="img/facebook.jpg"/>

	<!-- Mobile viewport optimized: h5bp.com/viewport -->
	<meta name="viewport" content="width=device-width,initial-scale=1">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href='https://fonts.googleapis.com/css?family=Alegreya+Sans:400,700,400italic,700italic|Noto+Serif:400,700,400italic,700italic|Sorts+Mill+Goudy:400,400italic' rel='stylesheet' type='text/css'>

	<!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

	<!-- All JavaScript at the bottom, except this Modernizr build incl. Respond.js
	   Respond is a polyfill for min/max-width media queries. Modernizr enables HTML5 elements & feature detects;
	   for optimal performance, create your own custom Modernizr build: www.modernizr.com/download/ -->
	<script src="js/libs/modernizr-2.0.6.min.js"></script>

</head>
<body>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=169785919713408";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
		<div id="head-top">
			<div class="container header">
				<a href="http://www.felixonline.co.uk">Back to Felix Online</a>
			</div>
		</div>
		<header id="head">
			<div class="container header">
			<img src="img/logo.png" alt="Felix" />
			Felix
		</div>
		</header>
		<div class="main-container">
			<div class="container">
			<h1><?php echo SURVEY_NAME; ?></h1>
	            <div id="social-links" class="clearfix">
	                <a href="https://twitter.com/share" class="twitter-share-button" data-url="https://union.ic.ac.uk/media/felix/sexsurvey/" data-related="feliximperial">Tweet</a>
	                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	                <div class="fb-like" data-href="<?php echo selfurl();; ?>" data-send="true" data-layout="button_count" data-width="200" data-show-faces="false" data-font="arial"></div>
	            </div>
			<?php if(ACTIVE == false) { ?>
				<div id="closed">
					<div class="alert alert-block alert-error">
						<h4 class="alert-heading">This survey has now closed</h4>
						Thank you for your interest. The results will be published shortly in Felix.
					</div>
					<p>For more information on the privacy and confidentiality of the results, <a data-toggle="modal" href="#more-details" >click here</a>.</p>
					<?php include('privacypolicy.php'); ?>
				</div>
			<?php } else { ?>
			<div role="main" id="main">
				<?php
					if (!isloggedin()) {
						if($loginfailed) {
							?><div class="alert alert-error">Sorry, your account details were not accepted. Please try again.</div><?php
						}

						// not logged in? display login form
						?>
						<?php include('introduction.php'); ?>
							<form action="<?php echo selfurl(); ?>" method="post" id="loginForm" class="form-horizontal">
								<legend>Please enter your username/password to continue</legend>
								<p>This information is only required to confirm that you have not yet completed this survey. It will <strong>not</strong> be tied to your response. See above for further details.</p>
								<fieldset class="control-group">
									<div class="row">
										<div class="span4">
											<label for="uname">IC Username:</label>
										</div>
										<div class="span8">
											<input type="text" name="uname" id="uname" />
										</div>
									</div>
								</fieldset>
								<fieldset class="control-group">
									<div class="row">
										<div class="span4">
											<label for="pass">IC Password:</label>
										</div>
										<div class="span8">
											<input type="password" name="pass" id="pass" />
										</div>
									</div>
								</fieldset>
								<div class="control-group">
									<fieldset class="form-actions">
										<input type="submit" value="Login" name="login" id="submitButton" class="btn btn-primary"/>
									</fieldset>
								</div>
							</form>
						<?php
					} else {
						if (isdone($_SESSION[COOKIE]['uname'])) {
							?>
							<div class="alert alert-block alert-success">
								<h4 class="alert-heading">Thank you!</h4>
								Your response has already been recorded, thank you for filling out the survey. After the research has been conducted, your responses will be deleted.
							</div>
							<p>For more information on the privacy and confidentiality of the results, <a data-toggle="modal" href="#more-details" >click here</a>.</p>
							<?php include('privacypolicy.php'); ?>
							<?php
						} elseif(array_key_exists('response', $_POST)) {
							if(array_key_exists('response', $_POST)) {
								$troll = 1;
								if ($_POST['department'] == 'anon' || strtolower(str_replace('_', ' ', $_POST['department'])) == strtolower(getdept($_SESSION[COOKIE]['uname'])) || getdept($_SESSION[COOKIE]['uname']) == 'Unknown') {
									$troll = 0;
								}

								$questions = file_get_contents('questions.json');
									$questions = json_decode($questions, true);

					$to_store = array();
					$to_secure_store = array();
					foreach($_POST as $question => $value) {
						if(!array_key_exists($question, $questions)) {
							continue; // ignore dunno boxes
						}
						if($questions[$question]['type'] == 'secure-textbox') {
							$to_secure_store[$question] = $value;
						} else {
							if($questions[$question]['type'] == 'number' && array_key_exists($question.'-dunno', $_POST)) {
								$to_store[$question] = ['notsure'];
							} else {
								$to_store[$question] = [$value];
							}
						}
					}
								addresponse(json_encode($to_store), json_encode($to_secure_store), $troll);
								markasdone($_SESSION[COOKIE]['uname']);
							} ?>
							<div class="alert alert-block alert-success">
								<h4 class="alert-heading">Thank you!</h4>
								Your response has been recorded, thank you for filling out the survey. After the research has been conducted, your responses will be deleted.
							</div>
							<p>For more information on the privacy and confidentiality of the results, <a data-toggle="modal" href="#more-details" >click here</a>.</p>
							<?php include('privacypolicy.php'); ?>
						<?php } else {
							// Display questions
							$questions = file_get_contents('questions.json');
							$questions = json_decode($questions, true);
							?>
								<?php include('introduction.php'); ?>
								<?php include('backgroundinfo.php'); ?>
								<form action="<?php echo selfurl(); ?>" method="post" class="form-horizontal" onSubmit="return window.confirm('Are you sure you would like to submit this survey now?\nAs this survey is anonymous, you will not be able to get back or edit your responses after they have been submitted.');">
									<?php
									if(!$questions) {
										?><p class="alert alert-danger">Malformed JSON</p><?php
										$questions = array();
									}
									$id = 1;
										foreach($questions as $key => $value) {
					?>
						<div>
					<?php
											if($value['type'] == 'header') {
												$classes = array();
												if(array_key_exists('dependencies', $value)) {
													$classes[] = 'hidden';
													$classes[] = 'dependant';
												} ?>
												<legend class="<?php outputclasses($classes);?>"
													<?php if(array_key_exists('dependencies', $value)) { ?>
														data-dependencies='<?php echo json_encode($value['dependencies']); ?>'
														<?php if(array_key_exists('reverse', $value)) { ?>
															data-reverse='true'
														<?php }?>
													<?php } ?>
												>
													<?php echo $value['label'];?>
												</legend>
											<?php } else {
												$classes = array('control-group');
												if(array_key_exists('dependencies', $value)) {
													$classes[] = 'hidden';
													$classes[] = 'dependant';
												}
												$hide_classes = array('muted');
												if(!array_key_exists('dependencies', $value)) {
													$hide_classes[] = 'hidden';
												}
												?>
											<small class="<?php outputclasses($hide_classes); ?>" id="<?php echo $key; ?>_hide"><p>Question <?php echo $id; ?> has been skipped based on your answers to previous question(s).</p></small>
											<fieldset id="<?php echo $key; ?>" class="<?php outputclasses($classes); ?>"
												<?php if(array_key_exists('dependencies', $value)) { ?>
													data-dependencies='<?php echo json_encode($value['dependencies']); ?>'
														<?php if(array_key_exists('reverse', $value)) { ?>
															data-reverse='true'
														<?php }?>
												<?php } ?>
											>
												<div class="row">
													<div class="span4">
														<label<?php if ($value['type'] !== 'radio'): ?> for="cont_<?php echo $key; ?>"<?php endif; ?>><?php echo $id.' - '.$value['label']; ?>
														<?php if(array_key_exists('moreinfo', $value) && $value['moreinfo']): ?>
														<br>
														<a href="#" rel="popover" data-content="<?php echo $value['moreinfo']; ?>" data-original-title="More information">More information</a>
														<?php endif; ?>
														</label>
													</div>

													<?php
													$id++;
														// Default radio sets
														if($value['type'] == 'yesno') {
															$value['type'] = 'radio';
															$value['options'] = array(array('value' => 'yes', 'label' => 'Yes'), array('value' => 'no', 'label' => 'No'), array('value' => 'anon', 'label' => 'Don\'t wish to say'));
														}

														// Default radio sets
														if($value['type'] == 'yesnomaybe') {
															$value['type'] = 'radio';
															$value['options'] = array(array('value' => 'yes', 'label' => 'Yes'), array('value' => 'no', 'label' => 'No'), array('value' => 'maybe', 'label' => 'Maybe'), array('value' => 'anon', 'label' => 'Don\'t wish to say'));
														}
													?>
													<div class="span8">
													<?php
														switch($value['type']) {
															case 'dropdown':
																?>
																<select name="<?php echo $key; ?>" id="cont_<?php echo $key; ?>">
																	<?php foreach($value['options'] as $option) { ?>
																		<option value="<?php echo $option['value']; ?>"<?php if(array_key_exists('default', $value) && $value['default'] == $option['value']): ?> selected="selected"<?php endif; ?>>
																			<?php echo $option['label'];?>
																		</option>
																	<?php } ?>
																</select>
															<?php break;
															case 'radio':
																foreach($value['options'] as $option) {
																	?>
																		<label class="radio <?php if(array_key_exists('inline', $value) && $value['inline'] == true) echo 'inline'; ?>">
																		<input type="radio" value="<?php echo $option['value']; ?>" name="<?php echo $key; ?>"<?php if(array_key_exists('default', $value) && $value['default'] == $option['value']): ?> checked="checked"<?php endif; ?>>
																			<?php echo $option['label']; ?>
																		</label>
																	<?php
																}
																break;
															case 'number':
																?>
																	<div class="number-group">
																		<input type="number" class="number-input" style="width: 100px" name="<?php echo $key; ?>" id="cont_<?php echo $key; ?>" min="0" step="1"/>
																		<br>
																		<label class="checkbox inline dunno-box">
																		<input type="checkbox" name="<?php echo $key; ?>-dunno" id="cont_<?php echo $key; ?>-dunno">Don't know
																		</label>
																	</div>
																<?php
																break;
															case 'widget':
																if(!ctype_alnum($value['name']) || !file_exists('widgets/'.$value['name'].'.html')) {
																	echo '<b class="text-error">The widget for this question does not exist.</b>';
																} else {
																	echo '<btn class="btn btn-info" id="btn-'.$value['name'].'" onclick="$(\'#btn-'.$value['name'].'\').hide(); $(\'#div-'.$value['name'].'\').show();">Click here to open the '.$value['widget-type'].' for this question</btn>';
																	echo '<div class="widget-div" id="div-'.$value['name'].'" style="display: none;">';
																	require('widgets/'.$value['name'].'.html');
																	echo '</div>';
																	echo '<input type="hidden" name="'.$value['name'].'" id="cont_'.$value['name'].'">';
																}
																break;
															case 'textbox':
															case 'secure-textbox':
																?>
																<textarea style="width: 95%" name="<?php echo $key; ?>" id="cont_<?php echo $key; ?>"></textarea>
															<?php break;
															case 'checkbox':
																foreach($value['options'] as $option) {
																	?>
																		<label class="checkbox <?php if(array_key_exists('inline', $value) && $value['inline'] == true) echo 'inline'; ?>">
																		<input type="checkbox" value="<?php echo $option['value']; ?>" name="<?php echo $key; ?>[]"<?php if(array_key_exists('default', $value) && $value['default'] == $option['value']): ?> checked="checked"<?php endif; ?>>
																			<?php echo $option['label']; ?>
																		</label>
																	<?php
																}
																break;
															}
													?>
													</div>
												</div>
											</fieldset>
											<?php } ?></div><?php
										} ?>
										<hr>
									<center>
										<!--<a data-toggle="modal" class="btn btn-primary btn-large" href="#submit-form" ><b>Submit</b></a>-->
										<input type="submit" class="btn btn-primary btn-large" value="Submit" name="response"/>
									</center>
									
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
											<a href="#" data-dismiss="modal" class="btn">No</a>
											<input type="submit" class="btn btn-primary" value="Yes" name="response"/>
										</div>
									</div>

								</form>
							<?php
						}
					}
				?>
			</div>
			</div>
			<?php } ?>
			<footer>
				<div class="container">
					<a href="http://felixonline.co.uk" title="Go back to Felix Online"><img class="footer-right" src="img/logo.png" alt="FELIX"/></a>
					<p style="float: right;">&copy; Felix Imperial <a href="#head">Top of page</a><br>Survey software by Philip Kent and Jonathan Kim<br>Use of this website indicates acceptance of cookies.</p>
				</div>
			</footer>
		</div>
	</div>

	<!-- JavaScript at the bottom for fast page loading -->

	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.1.min.js"><\/script>')</script>

	<script src="js/libs/bootstrap.min.js"></script>

	<!-- scripts concatenated and minified via build script -->
	<script defer src="js/script.js"></script>
	<!-- end scripts -->


	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6.
	   chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
		<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
		<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->

</body>
</html>
