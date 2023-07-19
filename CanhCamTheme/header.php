<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<!-- Style-->
	<?php wp_head(); ?>
	<!-- Script-->
</head>

<body <?php body_class(get_field('add_class_body', get_the_ID())) ?>>
	<header>
		header
	</header>
	<main>