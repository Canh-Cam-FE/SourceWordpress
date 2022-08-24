<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<!-- Style-->
	<link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/styles/main.min.css">
	<link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/styles/global.min.css">
	<link rel="stylesheet" href="<?php bloginfo("template_directory"); ?>/styles/fontAwesome.min.css">
	<?php wp_head(); ?>
	<!-- Script-->
</head>

<body class="<?php the_field('add_class_body',get_the_ID()) ?>">
	<header>
		header
	</header>
	<main>