<?php
if (!isset($title)) {
	$pageTitle = "Guaman Project";
} else {
	$pageTitle = $title . " - Guaman Project";
}
?>
<html>
<head>
	<link rel="stylesheet" href="<?php echo css_url("style.css"); ?>">
	<title><?php echo $pageTitle; ?></title>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
		  integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	<link rel="stylesheet" href=<?php echo css_url("sb-admin-2.min.css"); ?>>
	<link rel="stylesheet" href=<?php echo css_url("dataTables.bootstrap4.min.css"); ?>>
	<link
		href="https://fonts.googleapis.com/css?family=Fira+Sans:400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&amp;subset=latin-ext"
		rel="stylesheet">
	<script
		src="https://code.jquery.com/jquery-3.3.1.min.js"
		integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		crossorigin="anonymous"></script>
	<script src="<?php echo js_url("bootstrap.bundle.min.js");?>" ></script>
	<script src="<?php echo js_url("jquery.easing.min.js");?>" ></script>
	<script src="<?php echo js_url("jquery.dataTables.min.js");?>" ></script>
	<script src="<?php echo js_url("dataTables.bootstrap4.min.js");?>" ></script>
</head>
<body>
<div id="wrapper">