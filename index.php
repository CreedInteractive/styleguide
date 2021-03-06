<?php
	// Build out URI to reload from form dropdown
	// Need full url for this to work in Opera Mini
	$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";

	if (isset($_POST['sg_uri']) && isset($_POST['sg_section_switcher'])) {
		$pageURL .= $_POST[sg_uri].$_POST[sg_section_switcher];
		$pageURL = htmlspecialchars( filter_var( $pageURL, FILTER_SANITIZE_URL ) );
		header("Location: $pageURL");
	}

	// Display title of each markup samples as a select option
	function listMarkupAsOptions ($type) {
		$files = array();
		$handle=opendir('markup/'.$type);
		while (false !== ($file = readdir($handle))):
			if(stristr($file,'.html')):
					$files[] = $file;
			endif;
		endwhile;

		sort($files);
		foreach ($files as $file):
			$filename = preg_replace("/^[0-9]*_/i", "", $file);
			$filename = preg_replace("/\.html$/i", "", $filename);
			$title = preg_replace("/\-/i", " ", $filename);
			$title = ucwords($title);
			echo '<option value="#sg-'.$filename.'">'.$title.'</option>';
		endforeach;
	}

	// Display title of each markup samples as a list item
	function listMarkupAsList ($type) {
		$files = array();
		$handle=opendir('markup/'.$type);
		while (false !== ($file = readdir($handle))):
			if(stristr($file,'.html')):
					$files[] = $file;
			endif;
		endwhile;

		sort($files);
		foreach ($files as $file):
			$filename = preg_replace("/^[0-9]*_/i", "", $file);
			$filename = preg_replace("/\.html$/i", "", $filename); 
			$title = preg_replace("/\-/i", " ", $filename);
			$title = ucwords($title);
			echo '<li><a href="#sg-'.$filename.'">'.$title.'</a></li>';
		endforeach;
	}

	// Display markup view & source
	function showMarkup($type) {
		$files = array();
		$handle=opendir('markup/'.$type);
		while (false !== ($file = readdir($handle))):
			if(stristr($file,'.html')):
					$files[] = $file;
			endif;
		endwhile;

		sort($files);
		foreach ($files as $file):
			$filename = preg_replace("/^[0-9]*_/i", "", $file);
			$filename = preg_replace("/\.html$/i", "", $filename);
			$title = preg_replace("/\-/i", " ", $filename);
			$documentation = 'doc/'.$type.'/'.$file;
			echo '<div class="sg-markup sg-section">';
			echo '<div class="sg-display">';
			echo '<h2 class="sg-h2"><a id="sg-'.$filename.'" class="sg-anchor">'.$title.'</a></h2>';
			if (file_exists($documentation)) {
				echo '<div class="sg-doc">';
				echo '<h3 class="sg-h3">Notes</h3>';
				include($documentation);
				echo '</div>';
			};
			include('markup/'.$type.'/'.$file);
			echo '</div>';
        	echo '<div class="sg-markup-controls"><a class="sg-btn sg-btn--source btn" href="#">View Source</a> <a href="#top" class="sg-top">Back to Top</a></div>';
			echo '<div class="sg-source sg-animated">';
			echo '<a class="sg-btn sg-btn--select btn" href="#">Copy Source</a>';
			echo '<pre class="prettyprint linenums"><code>';
			echo htmlspecialchars(file_get_contents('markup/'.$type.'/'.$file));
			echo '</code></pre>';
			echo '</div>';
			echo '</div>';			
		endforeach;
	}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Styleguide Boilerplate</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<!-- Favicon and touch icons -->
	
	<!-- Styleguide Boilerplate Styles -->
	<link rel="stylesheet" href="css/sg-style.css">	
	<!-- Replace below stylesheet with your own stylesheet -->
	<link rel="stylesheet" href="css/main.css">
	<!-- IE Styles -->
	<!--[if lte IE 8]>
		<link rel="stylesheet" href="css/ie.css">
		<link rel="stylesheet" href="css/sg-ie.css">
	<![endif]-->
	
	<script src="js/vendor/modernizr.custom.74033.js"></script>
	<script src="js/vendor/picturefill.min.js" async></script>
</head>
<body>
	<div id="container">
		<div class="sg-nav-panel">
			<div class="sg-panel-header">
				<a href="#" class="sg-nav-toggle"><span class="icon-menu"></span></a>
				<h1 class="sg-title"><a href="#top">Styleguide</a></h1>
			</div>			
			<nav id="menu">
				<ul class="sg-nav">
					<li class="sg-nav-section">Base Styles</li>
					<?php listMarkupAsList('base'); ?>
					<li class="sg-nav-section">Patterns</li>
					<?php listMarkupAsList('patterns'); ?>
					<li class="sg-nav-section">Brand Guidelines</li>
					<?php listMarkupAsList('brand'); ?>
				</ul>
			</nav>
		</div>

		<div id="top" class="sg-wrap">
			<div class="sg-body sg-container">
				<div class="wrap">
					<div class="sg-info">               
						<div class="sg-about sg-section">
							<h2 class="sg-h2">Overview</h2>
							<p>Comments and documentation about your style guide. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus nobis enim labore facilis consequuntur! Veritatis neque est suscipit tenetur temporibus enim consequatur deserunt perferendis. Neque nemo iusto minima deserunt amet.</p>
						</div><!--/.sg-about-->
					</div><!--/.sg-info-->

					<div class="sg-base-styles">    
						<h1 class="sg-h1">Base Styles</h1>
						<?php showMarkup('base'); ?>
					</div><!--/.sg-base-styles-->

					<div class="sg-pattern-styles">
						<h1 class="sg-h1">Patterns</h1>
						<?php showMarkup('patterns'); ?>
					</div><!--/.sg-pattern-styles-->
					
					<div class="sg-brand-styles">    
						<h1 class="sg-h1">Brand Styles</h1>
						<?php showMarkup('brand'); ?>
					</div><!--/.sg-brand-styles-->
				</div>
			</div><!--/.sg-body-->
		</div><!--/.sg-wrap-->
	</div><!--/#container-->

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>

	<!-- Styleguide Boilerplate Scripts -->
	<script src="js/sg-plugins.js"></script>
	<script src="js/sg-scripts.js"></script>
	<script src="js/main.js"></script>

	<!-- Place additional scripts below -->

</body>
</html>
 