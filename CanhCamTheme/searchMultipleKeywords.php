<!-- Search nhiều từ khóa -->

<?php $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;?>
<?php
    $search_query = get_search_query();
    $keywords = explode(',', $search_query);
    $keywords = array_map('trim', $keywords);
    // log_dump($keywords);
    $post_types = array('post', 'shareholder');
    $queries = [];
    $conditions = array();
    global $wpdb;

    foreach ($keywords as $keyword) {
        $keyword = trim($keyword);

        $title_conditions = array();
        foreach ($post_types as $post_type) {
            $title_conditions[] = "{$wpdb->posts}.post_title LIKE '%" . esc_sql($keyword) . "%' AND {$wpdb->posts}.post_type = '" . esc_sql($post_type) . "'";
        }

        $conditions[] = "(" . implode(' OR ', $title_conditions) . ")";
    }

    $query = "SELECT * FROM {$wpdb->posts} WHERE 1=1 AND (" . implode(' OR ', $conditions) . ")";
    echo $query;
    $results = $wpdb->get_results($query);
    if ($results) {
        $post_ids = array();
        foreach ($results as $result) {
            $post_ids[] = $result->ID;
        }

        $args = array(
            'post_type' => $post_types,
            'post__in' => $post_ids,
            'posts_per_page' => 8,
            'paged' => $paged,
        );

        $the_query = new WP_Query($args);
    }
?>