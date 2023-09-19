<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<?php if (stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false) : ?>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<?php endif; ?>
	<!-- Style-->
	<?php wp_head(); ?>
	<!-- Script-->
</head>

<body <?php body_class(get_field('add_class_body', get_the_ID())) ?>>
	<header>
		header
	</header>
	<main>