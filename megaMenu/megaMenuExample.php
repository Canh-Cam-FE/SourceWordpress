<!-- *** header.php -->
<?php 
    custom_mega_menu();
?>

<!-- *** function_custom.php -->
 <?php 
function custom_mega_menu()
{
ob_start();
get_template_part("/components/megaMenu/megaMenu");
$mega_menu = ob_get_clean();
return $mega_menu;
}
?>

<!-- *** /components/megaMenu/megaMenu.php -->
<?php
$menu_name = 'primary-menu';
$locations = get_nav_menu_locations();

if (!isset($locations[$menu_name])) return;

$menu_items = wp_get_nav_menu_items($locations[$menu_name], [
	'update_post_term_cache' => false,
	'suppress_filters' => false
]);

if (empty($menu_items)) return;

// Build menu hierarchy and set active states
global $ACTIVE_CLASS;
$ACTIVE_CLASS = "current-custom-active";
function build_menu_with_active_states($menu_items)
{
	global $ACTIVE_CLASS;
	$current_url = trailingslashit(home_url(add_query_arg(array(), $_SERVER['REQUEST_URI'])));
	$menu_hierarchy = array();
	$items_by_id = array();

	// First pass: index all items by ID and check basic active state
	foreach ($menu_items as $item) {
		$item->is_active = false;
		$item->classes = array_unique((array)$item->classes); // Ensure unique classes from the start
		$post_taxonomies = get_post_taxonomies(get_the_ID());
		if ($post_taxonomies) {
			$post_categories = get_post_primary_category(get_the_ID(), $post_taxonomies[0]);
			$primary_category = $post_categories['primary_category'];
		}
		// Check if item is active
		if (
			trailingslashit($item->url) === $current_url ||
			in_array($ACTIVE_CLASS, $item->classes) ||
			(is_singular() && get_the_ID() == $item->object_id) ||
			(is_singular() && $primary_category && $item->object_id == $primary_category->term_id)
		) {
			$item->is_active = true;
		}

		$items_by_id[$item->ID] = $item;
		$item->children = array();
	}

	// Second pass: build hierarchy and propagate active states
	foreach ($menu_items as $item) {
		if ($item->menu_item_parent == 0) {
			$menu_hierarchy[] = $item;
		} else if (isset($items_by_id[$item->menu_item_parent])) {
			$parent = $items_by_id[$item->menu_item_parent];
			$parent->children[] = $item;
			// If child is active, mark parent as active
			if ($item->is_active) {
				$parent->is_active = true;
				// Propagate up the chain
				$current_parent = $parent;
				while (
					$current_parent->menu_item_parent != 0 &&
					isset($items_by_id[$current_parent->menu_item_parent])
				) {
					$current_parent = $items_by_id[$current_parent->menu_item_parent];
					$current_parent->is_active = true;
				}
			}
		}

		// Add current-custom-active class if active and not already present
		if ($item->is_active && !in_array($ACTIVE_CLASS, $item->classes)) {
			$item->classes[] = $ACTIVE_CLASS;
		}
	}

	return $menu_hierarchy;
}

// Apply the new function
$menu_items = build_menu_with_active_states($menu_items);

function get_item_class($menu_item)
{
	global $ACTIVE_CLASS;
	$classes = array();
	$menu_type = get_field("dropdown_menu", $menu_item);

	if ($menu_item->children) $classes[] = 'menu-item-has-children normal-dropdown';
	if ($menu_item->is_active) $classes[] = $ACTIVE_CLASS;
	if ($menu_type === 'has_child_arrow') $classes[] = 'has-child-arrow';
	if ($menu_type === 'mega_menu_1') $classes[] = 'has-mega-menu mega-menu-style-1';
	if ($menu_type === 'mega_menu_2') $classes[] = 'has-mega-menu mega-menu-style-2';

	$classes = array_merge($classes, array_filter($menu_item->classes));
	return implode(' ', array_unique($classes));
}

?>
<?php if ($menu_items) : ?>
	<nav>
		<ul>
			<?php foreach ($menu_items as $level_1): ?>
				<?php
				$menu_type = get_field("dropdown_menu", $level_1);
				$has_level_2_child = $level_1->children;
				?>
				<?php if ($menu_type === "default" || $menu_type === null || $menu_type === "has_child_arrow") : ?>
					<?php if ($has_level_2_child) : ?>
						<li class="<?= get_item_class($level_1) ?>">
							<div class="title">
								<a href="<?= $level_1->url ?>" title="<?= $level_1->title ?>">
									<?= $level_1->title ?>
								</a>
								<i class="fa-solid fa-angle-down"></i>
							</div>
							<ul>
								<?php foreach ($has_level_2_child as $level_2): ?>
									<li class="<?= get_item_class($level_2) ?>">
										<a href="<?= $level_2->url ?>" title="<?= $level_2->title ?>">
											<?= $level_2->title ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</li>
					<?php else : ?>
						<li class="<?= get_item_class($level_1) ?>">
							<a href="<?= $level_1->url ?>" title="<?= $level_1->title ?>">
								<?= $level_1->title ?>
							</a>
						</li>
					<?php endif; ?>
				<?php endif; ?>
				<?php if ($menu_type === 'mega_menu_1') : ?>
					<li class="<?= get_item_class($level_1) ?>" tab-wrapper="parent">
						<div class="title"><a href="<?= $level_1->url ?>" title="<?= $level_1->title ?>"><?= $level_1->title ?></a><i class="fa-solid fa-angle-down"></i></div>
						<div class="mega-menu-wrapper">
							<div class="mega-menu-inner">
								<div class="close-button close-mega-dropdown xl:hidden"><i class="fa-regular fa-arrow-left"></i>
									<div class="label"><?= $level_1->title ?></div>
								</div>
								<div class="menu-left">
									<?php foreach ($has_level_2_child as $level_2_key => $level_2): ?>
										<a title="<?= $level_2->title ?>" tab-item="parent" tab-item-value="<?= $level_2_key ?>"><?= $level_2->title ?></a>
									<?php endforeach; ?>
								</div>
								<div class="menu-right">
									<?php foreach ($has_level_2_child as $level_2_key => $level_2): ?>
										<?php
										$level_3_child = $level_2->children;
										?>
										<div class="menu-right-item" tab-content="parent" tab-content-value="<?= $level_2_key ?>">
											<div class="close-button close-child-mega-dropdown xl:hidden"><i class="fa-regular fa-arrow-left"></i>
												<div class="label"><?= $level_1->title ?></div>
											</div>
											<?php if ($level_3_child) : ?>
												<div class="menu-right-wrapper">
													<div class="menu-right-inner">
														<?php foreach ($level_3_child as $level_3): ?>
															<?php
															$level_4_child = $level_3->children;
															?>
															<div class="menu-item">
																<div class="title"><?= $level_3->title ?></div>

																<ul>
																	<?php foreach ($level_4_child as $level_4): ?>
																		<li class="<?= get_item_class($level_4) ?>"><a title="<?= $level_4->title ?>" href="<?= $level_4->url ?>"><?= $level_4->title ?></a></li>
																	<?php endforeach; ?>
																</ul>
															</div>
														<?php endforeach; ?>
													</div>
												</div>
											<?php endif; ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</li>
				<?php endif; ?>
				<?php if ($menu_type === 'mega_menu_2') : ?>
					<li class="<?= get_item_class($level_1) ?>" tab-wrapper="parent">
						<div class="title"><a title="<?= $level_1->title ?>" href="<?= $level_1->url ?>"><?= $level_1->title ?></a><i class="fa-solid fa-angle-down"></i></div>
						<div class="mega-menu-wrapper">
							<div class="mega-menu-inner">
								<div class="close-button close-mega-dropdown xl:hidden"><i class="fa-regular fa-arrow-left"></i>
									<div class="label"><?= $level_1->title ?></div>
								</div>
								<div class="menu-left">
									<?php foreach ($has_level_2_child as $level_2_key => $level_2): ?>
										<a title="<?= $level_2->title ?>" tab-item="parent" tab-item-value="<?= $level_2_key ?>"><?= $level_2->title ?></a>
									<?php endforeach; ?>
								</div>
								<div class="menu-right">
									<?php foreach ($has_level_2_child as $level_2_key => $level_2): ?>
										<?php
										$level_3_child = $level_2->children;
										?>
										<div class="menu-right-item" tab-content="parent" tab-content-value="<?= $level_2_key ?>">
											<div class="close-button close-child-mega-dropdown xl:hidden"><i class="fa-regular fa-arrow-left"></i>
												<div class="label"><?= $level_1->title ?></div>
											</div>
											<?php if ($level_3_child) : ?>
												<div class="menu-right-wrapper">
													<div class="menu-right-inner">
														<?php foreach ($level_3_child as $level_3): ?>
															<?php
															$level_4_child = $level_3->children;
															$brand_button_url = get_field("brand_button_url", $level_3);
															if ($level_4_child) {
																$has_level_4_image = get_field("image", $level_4_child[0]);
															}
															?>
															<div class="menu-item <?php if ($has_level_4_image) : ?> logo-item <?php endif; ?>">
																<div class="title"><?= $level_3->title ?></div>
																<ul>
																	<?php foreach ($level_4_child as $level_4): ?>
																		<li class="<?= get_item_class($level_4) ?>">
																			<?php if ($has_level_4_image) : ?>
																				<a href="<?= $level_4->url ?>" title="<?= $level_4->title ?>" class="ratio-[1/1] ratio-contain"><?= custom_lozad_image(get_field("image", $level_4)) ?></a>
																			<?php else : ?>
																				<a title="<?= $level_4->title ?>" href="<?= $level_4->url ?>"><?= $level_4->title ?></a>
																			<?php endif; ?>
																		</li>
																	<?php endforeach; ?>
																</ul>
																<?php if ($brand_button_url) : ?>
																	<div class="button relative z-1"><a title="<?php _e('Xem tất cả thương hiệu', 'canhcamtheme'); ?>" class="btn  btn-primary " href="<?= $brand_button_url ?>"><?php _e('Xem tất cả thương hiệu', 'canhcamtheme'); ?><i class="fa-regular fa-plus"></i></a>
																	</div>
																<?php endif; ?>
															</div>
														<?php endforeach; ?>
													</div>
												</div>
											<?php endif; ?>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					</li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
	</nav>
<?php endif; ?>