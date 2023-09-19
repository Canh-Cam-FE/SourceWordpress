<?php
function log_dump($data)
{
	// Use the PHP ob_start function to capture the output of the var_dump function
	ob_start();
	var_dump($data);
	$dump = ob_get_clean();

	// Use the PHP highlight_string function to highlight the syntax
	$highlighted = highlight_string("<?php\n" . $dump . "\n?>", true);

	// Remove the PHP tags and wrap the highlighted code in a <pre> tag
	$formatted = '<pre>' . substr($highlighted, 27, -8) . '</pre>';

	// Add custom CSS styles for the .php and .hlt classes
	$custom_css = 'pre {position: static;
		background: #ffffff80;
		// max-height: 50vh;
		width: 100vw;
	}
	pre::-webkit-scrollbar{
	width: 1rem;}';

	// Wrap the custom CSS in a <style> tag
	$formatted_css = '<style>' . $custom_css . '</style>';
	echo ($formatted_css . $formatted);
}

function empty_content($str)
{
	return trim(str_replace('&nbsp;', '', strip_tags($str, '<img>'))) == '';
}

function custom_get_post_thumbnail($post_id, $size = 'full', $attr = '')
{
    if (is_array($post_id))
        $post_id = $post_id["ID"];
    $post_thumbnail_id = get_post_thumbnail_id($post_id);
    $image_attributes = wp_get_attachment_image_src($post_thumbnail_id, $size);
    $alt_text = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);

    if ($image_attributes) {
        $html = "<img width='" . $image_attributes[1] . "' height='" . $image_attributes[2] . "' data-src='" . esc_url($image_attributes[0]) . "' class='lozad'";
        if (empty($alt_text)) {
            $html .= 'alt="' . get_wp_title_rss('') . '"';
        } else {
            $html .= ' alt="' . esc_attr($alt_text) . '"';
        }
        $html .= ' />';

        return $html;
    }
}

function custom_lozad_image($attachment_id, $size = 'full', $icon = false, $attr = '')
{
    if (is_array($attachment_id))
        $attachment_id = $attachment_id["ID"];
    $image_attributes = wp_get_attachment_image_src($attachment_id, $size);
    $alt_text = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
    if ($image_attributes) {
        $html = "<img width='" . $image_attributes[1] . "' height='" . $image_attributes[2] . "' data-src='" . esc_url($image_attributes[0]) . "' class='lozad'";
        if (empty($alt_text)) {
            $html .= 'alt="' . get_wp_title_rss('') . '"';
        } else {
            $html .= ' alt="' . esc_attr($alt_text) . '"';
        }
        $html .= ' />';
        return $html;
    }
}

?>