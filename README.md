# **Table of content**

# **Bảo mật website wordpress**
- Đổi prefix database: brozzme-db-prefix-Change
- Bảo mật xác thực 2 lớp: ithemes-securiry-pro
-- Cấu hình recaptcha cho login
-- Bật xác minh 2 bước qua email khi login
- Password sau khi onsite để lại random

# **SỬ DỤNG BỘ THEME BOILERPLATE**

> ## **Upload Theme**

-   Upload Thư mục **CanhCamTheme** vào thư mục **wp-content/themes**
-   Upload 3 bộ plugin vào thư mục **wp-content/plugins**

> ## **Cấu trúc của 1 theme wordpress**

```html
📦CanhCamTheme
┣ 📂fonts
┣ 📂img
┣ 📂scripts
┣ 📂styles
┣ 📂Modules
┣ ┣ 📂 homepage
┣ ┣ ┣ 📜banner.php
┣ 📜404.php
┣ 📜category.php
┣ 📜footer.php
┣ 📜comments.php
┣ 📜comments-helper.php
┣ 📜functions.php
┣ 📜header.php
┣ 📜index.php
┣ 📜screenshot.png
┣ 📜search.php
┣ 📜single.php
┣ 📜style.css
┗ 📜todo.md
```

---

> **index.php** - Hiển thị định dạng trang chủ

> **header.php** - Hiển thị Header

> **footer.php**- Hiển thị footer

> **functions.php** - chứa các hàm khai báo, viết thêm chức năng

> **category.php** - Hiển thị chuyên mục của bài viết

> **category-{slug-category}.php** - Cũng giống như trên nhưng nó sẽ hiển thị giao diện chuyên mục riêng biệt cho từng loại,
>
> -   ví dụ ta có **slug-category** là **tin-tuc** và **su-kien** thì sẽ có 2 file **category-tin-tuc.php** và **category-su-kien.php**

> **page.php** - Hiển thị định dạng giao diện cho trang

> **page-{slug-category}.php** - Hiển thị định dạng giao diện theo từng trang

-   Trước mỗi giao diện page phải khai báo trước

```php
<?php
/*
Template name: Page - Sản phẩm List
*/
?>
```

> **single.php** - Hiển thị mặc định giao diện trang chi tiết (chi tiết tin tức)

> **single-{slug-post-type}** - Hiển thị giao diện chi tiết riêng biệt cho post-type

> **search.php** - Hiển thị giao diện trang search

> **comments.php** - File giao diện form bình luận

> **comments-helper.php** - File hiển thị bình luận

---

# **Một số key/snippet dùng để ráp**

> ## **Ráp form search**

```html
<form
	class="searchbox flex items-center w-full relative"
	action="<?php bloginfo('url') ?>/"
	method="GET"
	role="form"
>
	<input
		class="w-full"
		name="s"
		class="form-control"
		type="text"
		placeholder="Tìm kiếm"
	/>
	<button type="submit" class="flex items-center justify-center">
		<em class="fa-regular fa-magnifying-glass"></em>
	</button>
</form>
```

> ## **Edit Link**

```php
<?php echo edit_link_post(get_the_ID()) ?>
```

> ## **Get link menu**

```php
<?php wp_nav_menu([
	"theme_location" => "header-menu", // Vị trí menu
	"container" => "false", // Option Wrap ul
	"menu_id" => "header-menu", // ID cho ul
	"menu_class" => "flex md:items-end flex-col font-semibold text-2xl md:text-white uppercase", // class cho ul
	"add_li_class"  => "your-class-name1 your-class-name-2" // Option custom thêm
	"add_class_active" => "" //Tùy biến class active - Option custom thêm
]); ?>
```

> ## **Get breadcrumb**

```php
<div class="global-breadcrumb">
	<div class="container">
	<?php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); ?>
	</div>
</div>
```

> ## **Get id page hiện tại**

```php
get_the_ID()
```

> ## **Get đường dẫn root**

-   Dùng cho trường hợp dùng hình cứng trong source

```php
<?php bloginfo('template_directory')?>
```

> ## **Show thông tin của array trên về để tìm key get**

```php
print_r(get_field("section_home_3", get_the_ID()));
```

> ## **Tại sao phải dùng wp_reset_postdata()**

```html
Đây là hàm luôn nằm ở cuối cùng khi get post có sử dụng phương thức WP_query() -
Dùng để reset lại biến $post trong truy vấn chính tránh phát sinh ra lỗi
```

> ## **Code get post | Không sử dụng custom field**

-   code này dùng cho trường hợp không phải từ **custom field**

```php
$args = array(
	'order' => 'ASC',
	'category_name' => 'tin-tuc',
	'orderby' => 'date'
);
$the_query = new WP_Query( $args );
if ( $the_query->have_posts() ) :
while ( $the_query->have_posts() ) : $the_query->the_post();
  // Code cần lặp ở đây
endwhile;
endif;
wp_reset_postdata();
```

> ## **Các hook để get dữ liệu trong custom field**

```php
get_field('key_field', 'ID') // Được sử dụng để xữ lý trong các hàm => nếu muốn dùng cái này show ra Dom thì phải dùng kèm với echo
the_field('key_field', 'ID') // Show dữ liệu ra Dom
//
ID: Là thứ bắt buộc phải có
- ở đây có thể là ID trang hiện tại (get_the_ID())

$post_id = false; // current post
$post_id = 1; // post ID = 1
$post_id = "user_2"; // user ID = 2
$post_id = "category_3"; // category term ID = 3
$post_id = "event_4"; // event (custom taxonomy) term ID = 4
$post_id = "option"; // options page
$post_id = "options"; // same as above

$value = get_field( 'my_field', $post_id );
```

> ## **Code get post | Có sử dụng custom field**

```php
$news_home = get_field('key_field_post_object')
<?php if ($news_home): ?>
<?php foreach ($news_home as $new) : setup_postdata($new) ?>

// Code lặp
<?php echo get_page_link($new->ID) ?> // Get link trang
<?php echo get_the_post_thumbnail($new->ID, 'full') ?> // Get hình => return ra thẻ img
<?php echo get_the_date('d', $new->ID) ?> // Get date
<?php echo $new->post_title ?> // Những key như post_title có thể dùng print_r($news_home) để tìm key


<?php endforeach; ?>
<?php wp_reset_postdata() ?>
<?php endif; ?>
//
```

> ## **Code lấy gọi module file**

```php
<?php
	get_template_part('modules/introduce/about')
?>
```

> ## **Ráp form thông tin**

```php
Tạo form trong cms contact form => Lấy mã shortcode
<?php echo do_shortcode('[contact-form-7 id="395" title="Contact form 1"]'); ?>
```

```js
// Sử dụng sự kiện wpcf7mailsent để handle sự kiến submit form thành công
document.addEventListener(
	"wpcf7mailsent",
	function (event) {
		$(".box-form .wrapper").remove();
		$(".popup-form .box-success").removeClass("hidden");
	},
	false
);
```

> ## **Get bài viết liên quan trong chi tiết tin**

```php
<?php
	$category = get_the_category(get_the_ID());
	$args = array(
		'posts_per_page' => 5,
		'cat' => $category[0]->term_id,
		'order' => 'ASC',
		'orderby' => 'date'
	);
	// Đoạn sau sử dụng code get post truyền array trên vào
?>
```

> ## Get Paginate link - phân trang

```php
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$args = array(
    // options here
    'paged' => $paged,
);
$the_query = new WP_Query( $args );

<?php if (paginate_links() != '') { ?>
		<div class="pagination">
			<?php
			global $wp_query;
			$big = 99999999;
			echo paginate_links(array(
				'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
				'format' => '?paged=%#%',
				'prev_text' => __('<'),
				'next_text' => __('>'),
				'current' => max(1, get_query_var('paged')),
				'total' => $wp_query->max_num_pages
			))
			?>
		</div>
	<?php
	}
?>
```

> ## Get list page children

```php
$all_locations = get_pages(array(
			'post_type'         => 'page', //here's my CPT
			'sort_order' => 'ASC',
			'sort_column' => 'post_date'
		));
		$list_page_child = get_page_children(14, $all_locations);
```

> ## **Get Term Children - Taxonomy**

```php
$childs = get_term_children(17,'danh-muc-san-pham') // tham số 2 là key của taxonomy
<?php if ($childs) : ?>
  <?php foreach ($childs as $child) : ?>
    <li>
        <a href="<?php echo get_term_link($child) ?>"><?php echo get_term($child)->name; ?></a>
    </li>
  <?php endforeach ?>
<?php endif; ?>
```
> ## **Get Children Category**
```php
<?php
	$idCurrent = get_queried_object()->term_id;
	$childs = get_term_children(13, 'category');
?>
<?php foreach ($childs as $child) :  ?>
	<li class="<?php echo (get_category_link($child) == get_category_link($idCurrent) ? 'active' : '') ?>"><a href="<?php echo get_category_link($child) ?>">
			<?php echo get_cat_name($child) ?>
		</a></li>
<?php endforeach; ?>
```

> ## **Check conditional EN or VI**

```php
	echo do_shortcode('[language]')
```

> **get_queried_object()->term_id;: get category id current**: Key get current category id

> **the_title(string $before = '', string $after = '', bool $echo = true)**: key get title page => Displays or retrieves the current post title

> **get_the_title(id)**: Key get title post theo id

> **the_content(string $more_link_text = null, bool $strip_teaser = false)**: key get content

> **get_the_post_thumbnail($news->ID, 'full', array('class' => 'alignleft'))**: Key get hình post

> **get_page_link($page->ID)**: Get Page Link by ID

> **get_the_date(format, id)**: Get date format = 'dd.mm.yyyy'

> **get_the_post_thumbnail_url($image->ID)**: Get url hình

> **single_post_title( string $prefix = '', bool $display = true )**: Get title page and post

---

# **Một số code function thông dụng**

-   Tên cả những file code dưới đều sử dụng trong **functions.php**
    > ## **Tạo vị trí menu**

```php
function register_my_menu()
{
	register_nav_menu('header-menu', __('Menu chính'));
}
add_action('init', 'register_my_menu');
```

> ## **Tạo theme options**

-   Có thể dùng để tạo các tab key cố định trên site

```php
if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme options', // Title hiển thị khi truy cập vào Options page
		'menu_title'	=> 'Theme options', // Tên menu hiển thị ở khu vực admin
		'menu_slug' 	=> 'theme-settings', // Url hiển thị trên đường dẫn của options page
		'capability'	=> 'edit_posts',
		'redirect'	=> false
	));
}
```

> ## **Tạo custom post types**

```php
function slider_custom_post_type()
{
	$label = array(
		'name' => 'Banner',
		'singular_name' => 'Banner',
		'view_item'           => 'Xem Banner',
		'add_new_item'        => 'Thêm Banner Mới',
		'add_new'             => 'Thêm Banner',
		'edit_item'           => 'Chỉnh sửa Banner',
		'update_item'         => 'Update Banner',
		'search_items'        => 'Tìm Banner'
		'not_found'           => 'Không tìm thấy'
		'not_found_in_trash'  => 'Không tìm thấy rác'
	);

	$args = array(
		'labels' => $label,
		'description' => 'Ảnh slider',
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
		'taxonomies' => array('pages'), //Các taxonomy được phép sử dụng để phân loại nội dung
		'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
		'public' => true, //Kích hoạt post type
		'show_ui' => true, //Hiển thị khung quản trị như Post/Page
		'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
		'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
		'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
		'menu_position' => 5, //Thứ tự vị trí hiển thị trong menu (tay trái)
		'menu_icon' => 'dashicons-slides', //Đường dẫn tới icon sẽ hiển thị
		'can_export' => true, //Có thể export nội dung bằng Tools -> Export
		'has_archive' => true, //Cho phép lưu trữ (month, date, year)
		'exclude_from_search' => false, //Loại bỏ khỏi kết quả tìm kiếm
		'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
		'capability_type' => 'post' //
	);
	register_post_type('slider', $args); //Tạo post type với slug tên  và các tham số trong biến $args ở trên
}
add_action('init', 'slider_custom_post_type');
```

> ## **Custom taxonomy**

```php

<?php
function tao_taxonomy_category_product()
{
	$labels = array(
		'name' => 'Danh mục sản phẩm',
		'singular' => 'Danh mục sản phẩm',
		'menu_name' => 'Danh mục sản phẩm',
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'rewrite' => array('slug' => 'danh-muc', 'hierarchical' => true),
		'public' => true,
		'show_ui' => true,
		'show_admin_column' => true,
		'show_in_nav_menus' => true,
		'show_tagcloud' => true,
	);
	register_taxonomy('danh-muc-san-pham', 'product', $args);
}
add_action('init', 'tao_taxonomy_category_product', 0);

```

> ## **Custom thêm ảnh đại diện bài viết**

```php
add_theme_support('post-thumbnails');
```

> ## **Hiển thị thanh admin bar**

```php
function admin_bar()
{

	if (is_user_logged_in()) {
		add_filter('show_admin_bar', '__return_true', 1000);
	}
}
add_action('init', 'admin_bar');
```

> ## **Thêm chức năng menu**

```php
add_theme_support('menus');
```

> ## Xóa slug post-types

```php
function remove_custom_post_type_slug($post_link, $post)
{
	if ('products' === $post->post_type && 'publish' === $post->post_status) {
		$post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
	}
	if ('grounds' === $post->post_type && 'publish' === $post->post_status) {
		$post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
	}
	return $post_link;
}
add_filter('post_type_link', 'remove_custom_post_type_slug', 10, 2);
function add_post_names_to_main_query($query)
{
	// Bail if this is not the main query.
	if (!$query->is_main_query()) {
		return;
	}
	// Bail if this query doesn't match our very specific rewrite rule.
	if (!isset($query->query['page']) || 2 !== count($query->query)) {
		return;
	}
	// Bail if we're not querying based on the post name.
	if (empty($query->query['name'])) {
		return;
	}
	// Add CPT to the list of post types WP will include when it queries based on the post name.
	$query->set('post_type', array('post', 'page', 'products', 'grounds'));
}
```

> ## Xóa slug post-types

```php
// Bỏ vào trong functions.php
function cc_mime_types($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');
// Gắn vào wp-config.php
define('ALLOW_UNFILTERED_UPLOADS', true);

```

---

# **Một số lỗi hay gặp**

> **Không hiện show admin bar**

-   Thiếu thẻ **wp_header()** hoặc **wp_footer()**

---

# **Cách làm đa ngôn ngữ**

-   Sử dụng plugin **WPML**
-   Vào mục setting tick dịch hết những field có translate - https://ibb.co/z61G7bc
-   Đối với page - custom field - post => duplicate chuyển sang ngôn ngữ tiếng anh edit

*   Lưu ý phải dịch **page** > **category** > **post** > **custom field**

---

# **Bảo mật wordpress**

> **Change link login** - Sử dụng plugin WPS Hide Login

-   Change đường dẫn trong settings - admincp

---

## **Field Custom Mặc Định**

-   Banner (file: function-field)
    -   Banner: **banner_select_page**
    -   Custom thêm chổ hiển thị field
    ```php
        array(
          array(
            'param' => 'post_type',
            'operator' => '==',
            'value' => 'page',
          ),
        ),
        array(
          array(
            'param' => 'taxonomy',
            'operator' => '==',
            'value' => 'category',
            ),
        ),
        // Thêm taxonomy ở dưới
      array(
        array(
          'param' => 'taxonomy',
          'operator' => '==',
          'value' => 'danh-muc-san-pham'
        )
      )
    ```

---

# **Một số nguồn tham khảo**

https://gist.github.com/thachpham92/d57b18cf02e3550acdb5

https://huykira.net/

https://thachpham.com/

https://www.udemy.com/course/become-a-wordpress-developer-php-javascript/
