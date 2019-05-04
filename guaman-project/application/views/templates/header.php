<?php
if (!isset($title)) {
	$pageTitle = "GP DEV";
} else {
	$pageTitle = $title . " - GP DEV";
}
?>
<html>
<head>
    <meta charset="utf-8">
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
	<script src="<?php echo js_url("bootstrap.bundle.min.js"); ?>"></script>
	<script src="<?php echo js_url("jquery.easing.min.js"); ?>"></script>
	<script src="<?php echo js_url("jquery.dataTables.min.js"); ?>"></script>
	<script src="<?php echo js_url("dataTables.bootstrap4.min.js"); ?>"></script>
	<script src="<?php echo js_url("jsLists.min.js"); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/js/i18n/defaults-hu_HU.min.js"></script>


    <link rel="icon" href="<?php echo img_url("logo.png") ?>" type="image/x-icon"/>
    <link rel="shortcut icon" href="<?php echo img_url("logo.png") ?>" type="image/x-icon"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/css/bootstrap-select.min.css">
    <link rel="apple-touch-icon" sizes="180x180"
		  href="https://guamanpj.com/guaman-project/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32"
		  href="https://guamanpj.com/guaman-project/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16"
		  href="https://guamanpj.com/guaman-project/favicon/favicon-16x16.png">
	<link rel="manifest" href="https://guamanpj.com/guaman-project/favicon/site.webmanifest">
	<link rel="mask-icon" href="https://guamanpj.com/guaman-project/favicon/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">


</head>
<body>
<div id="wrapper">
