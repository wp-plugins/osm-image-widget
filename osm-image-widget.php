<?php defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
Plugin Name: OSM Image Widget
Plugin URI:  http://www.programador-paginasweb.com
Description: This plugin lets you easily add images to widgets. Uses WordPress media library. You can add link, title, text, alternative text, CSS classes...
Version:     1.1
Author:      Pablo López
Author URI:  http://www.programador-paginasweb.com
License:     GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: osm-image-widget
*/

class OSM_Image_Widget extends WP_Widget {
    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array('classname' => 'osm-image-widget', 'description' => __( 'Add images to your widgets', 'osm-image-widget' ) );
        parent::__construct('osm_image_widget', __( 'OSM Image Widget', 'osm-image-widget'), $widget_ops);
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance );
        $image = esc_attr($instance['image']);
        $image_alt = esc_attr($instance['image_alt']);
        $image_class = esc_attr($instance['image_class']);
        $text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
        $link = esc_attr($instance['link']);
        $link_text = esc_attr($instance['link_text']);
        $link_class = esc_attr($instance['link_class']);
        $link_rel = esc_attr($instance['link_rel']);
        $link_target = esc_attr($instance['link_target']);

        echo $args['before_widget'];
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo '<div id="osm-image-widget-wrapper">';
            echo '<div class="osm-image-widget-image">';
                if (!empty($link)) {
                    echo '<a href="' . $link . '" title="' . $link_text . '" rel="' . $link_rel . '"';
                    if ($link_target == 1) {
                        echo ' target="_blank"';
                    }
                    echo '>';
                }

                $attr = array(
                    'class' => $image_class,
                    'alt' => $image_alt
                );
                echo wp_get_attachment_image( $image, '', '', $attr );

                if (!empty($link)) {
                    echo '</a>';
                }
            echo '</div><!-- osm-image-widget-image -->';

            if (!empty($text)) {
                echo '<div class="osm-image-widget-content">';
                    echo '<p>' . $text . '</p>';
                echo '</div><!-- osm-image-widget-content -->';
            }

            if (!empty($link)) {
                echo '<div class="osm-image-widget-link">';
                    echo '<a href="' . $link . '" title="' . $link_text . '" rel="' . $link_rel . '"';
                    if (!empty($link_class)) {
                        echo ' class="' . $link_class . '"';
                    }
                    if ($link_target == 1) {
                        echo ' target="_blank"';
                    }
                    echo '>' . $link_text . '</a>';
                echo '</div><!-- osm-image-widget-link -->';
            }
        echo '</div><!-- osm-image-widget-wrapper -->';
        echo $args['after_widget'];
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        // outputs the options form on admin
        add_thickbox();

        $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
        $title = strip_tags($instance['title']);
        $image = strip_tags($instance['image']);
        $image_alt = strip_tags($instance['image_alt']);
        $image_class = strip_tags($instance['image_class']);
        $text = strip_tags($instance['text']);
        $link = strip_tags($instance['link']);
        $link_text = strip_tags($instance['link_text']);
        $link_class = strip_tags($instance['link_class']);
        $link_rel = strip_tags($instance['link_rel']);
        $link_target = strip_tags($instance['link_target']);?>

        <p>
            <label for="<?php echo $this->get_field_id('title');?>"><?php _e('Title','osm-image-widget');?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('title');?>" name="<?php echo $this->get_field_name('title');?>" class="widefat" value="<?php echo esc_attr($title);?>" />
        </p>

        <label for="<?php echo $this->get_field_id('image');?>"><?php _e('Image','osm-image-widget');?>:</label>
        <div class="osm-image-widget-wrapper">
            <?php $display = '';
            if (empty($image) || $image == '') { $display = 'style="display:none"';}
            $image_src = wp_get_attachment_url( $image );?>

            <input type="hidden" id="<?php echo $this->get_field_id('image');?>" name="<?php echo $this->get_field_name('image');?>" value="<?php echo esc_attr($image);?>" />
            <img src="<?php echo $image_src;?>" <?php echo $display;?> />
            <a href="#" class="button osm-image-widget-upload"><?php _e('Upload Image','osm-image-widget');?></a>
            <a href="#" class="osm-image-widget-delete" <?php echo $display;?>><i class="dashicons-before dashicons-dismiss"></i></a>
        </div><!-- osm-image-widget-wrapper -->

        <p>
            <label for="<?php echo $this->get_field_id('image_alt');?>"><?php _e('Alternative Text for Image','osm-image-widget');?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('image_alt');?>" name="<?php echo $this->get_field_name('image_alt');?>" class="widefat" value="<?php echo esc_attr($image_alt);?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('image_class');?>"><?php _e('CSS Class for Image','osm-image-widget');?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('image_class');?>" name="<?php echo $this->get_field_name('image_class');?>" class="widefat" value="<?php echo esc_attr($image_class);?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('text');?>"><?php _e('Text','osm-image-widget');?>:</label>
            <textarea id="<?php echo $this->get_field_id('text');?>" name="<?php echo $this->get_field_name('text');?>" rows="4" class="widefat"><?php echo esc_attr($text);?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('link');?>"><?php _e('Link','osm-image-widget');?>:</label>

            <span class="osm-image-widget-link-wrapper">
                <input type="text" id="<?php echo $this->get_field_id('link');?>" name="<?php echo $this->get_field_name('link');?>" class="widefat osm-image-widget-link" value="<?php echo esc_attr($link);?>" />
                <a href="#TB_inline?width=600&height=550&inlineId=post-list" title="<?php _e('Post, Page & Custom Post Types List','osm-image-widget');?>" class="thickbox"><button class="osm-image-widget-link-button dashicons dashicons-search"></button></a>
            </span>

            <div id="post-list" style="display:none;">
                <p><?php _e('Then the last 50 entries are displayed sorted by date. Use the filter to make a more specific search','osm-image-widget');?></p>

                <p>
                    <input type="search" id="post-link-search" name="post-link-search" class="search" placeholder="<?php _e('Search','osm-image-widget');?>">
                    <input type="button" id="post-link-submit" name="post-link-submit" value="<?php _e('Search','osm-image-widget');?>">
                </p>

                <div id="post-list-items"></div>
            </div>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('link_text');?>"><?php _e('Link Text','osm-image-widget');?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('link_text');?>" name="<?php echo $this->get_field_name('link_text');?>" class="widefat" value="<?php echo esc_attr($link_text);?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('link_class');?>"><?php _e('Link Class','osm-image-widget');?>:</label>
            <input type="text" id="<?php echo $this->get_field_id('link_class');?>" name="<?php echo $this->get_field_name('link_class');?>" class="widefat" value="<?php echo esc_attr($link_class);?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('link_rel');?>"><?php _e('Rel Attribute','osm-image-widget');?>:</label>
            <select id="<?php echo $this->get_field_id('link_rel');?>" name="<?php echo $this->get_field_name('link_rel');?>" class="widefat">
                <option value="" <?php if ($link_rel == "") {?>selected<?php }?>><?php _e('Select an option','osm-image-widget');?></option>
                <option value="alternate" <?php if ($link_rel == "alternate") {?>selected<?php }?>>alternate</option>
                <option value="author" <?php if ($link_rel == "author") {?>selected<?php }?>>author</option>
                <option value="bookmark" <?php if ($link_rel == "bookmark") {?>selected<?php }?>>bookmark</option>
                <option value="help" <?php if ($link_rel == "help") {?>selected<?php }?>>help</option>
                <option value="license" <?php if ($link_rel == "license") {?>selected<?php }?>>license</option>
                <option value="next" <?php if ($link_rel == "next") {?>selected<?php }?>>next</option>
                <option value="nofollow" <?php if ($link_rel == "nofollow") {?>selected<?php }?>>nofollow</option>
                <option value="noreferrer" <?php if ($link_rel == "noreferrer") {?>selected<?php }?>>noreferrer</option>
                <option value="prefetch" <?php if ($link_rel == "prefetch") {?>selected<?php }?>>prefetch</option>
                <option value="prev" <?php if ($link_rel == "prev") {?>selected<?php }?>>prev</option>
                <option value="search" <?php if ($link_rel == "search") {?>selected<?php }?>>search</option>
                <option value="tag" <?php if ($link_rel == "tag") {?>selected<?php }?>>tag</option>
            </select>
        </p>

        <p>
            <input type="checkbox" id="<?php echo $this->get_field_id('link_target');?>" name="<?php echo $this->get_field_name('link_target');?>" value="1" class="checkbox" <?php if (esc_attr($link_target) == 1) {?>checked<?php }?> />
            <label for="<?php echo $this->get_field_id('link_target');?>"><?php _e('Open in a new window?','osm-image-widget');?></label>
        </p>
    <?php }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['image'] = strip_tags($new_instance['image']);
        $instance['image_alt'] = strip_tags($new_instance['image_alt']);
        $instance['image_class'] = strip_tags($new_instance['image_class']);
        $instance['text'] = strip_tags($new_instance['text']);
        $instance['link'] = strip_tags($new_instance['link']);
        $instance['link_text'] = strip_tags($new_instance['link_text']);
        $instance['link_class'] = strip_tags($new_instance['link_class']);
        $instance['link_rel'] = strip_tags($new_instance['link_rel']);
        $instance['link_target'] = strip_tags($new_instance['link_target']);

        return $instance;
    }
}

// Add CSS to Widget Back
function osm_image_widget_styles() {
    wp_enqueue_style( 'thickbox' );
    wp_enqueue_style( 'osm-image-widget-style', plugin_dir_url(__FILE__) . 'css/style.css' );
}
add_action( 'admin_init', 'osm_image_widget_styles' );

// Add JS to Widget Back
function osm_image_widget_scripts() {
    wp_enqueue_media();
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_script( 'osm-image-widget-script', plugin_dir_url(__FILE__) . 'js/scripts.js', '', false, true );
}
add_action( 'admin_init', 'osm_image_widget_scripts' );

// AJAX post-list
function ajax_get_publish_posts(){
    $return = '<table class="post-link-table">';
    $return .= '<thead>';
    $return .= '<tr>';
    $return .= '<td width="80%"><strong>' . __('Title', 'osm-image-widget') . '</strong></td>';
    $return .= '<td width="20%"><strong>' . __('Date', 'osm-image-widget') . '</strong></td>';
    $return .= '</tr>';
    $return .= '</thead>';
    $return .= '<tbody>';

    // Looking for all custom post types. Add Page & Post
    $args = array(
       'public'   => true,
       '_builtin' => false
    );
    $post_types = get_post_types( $args );
    $post_types[] = "post";
    $post_types[] = "page";

    $args = array(
        'post_type' => $post_types,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        's' => esc_attr($_POST["filter"]),
        'posts_per_page' => '50'
    );
    $query = new WP_Query( $args );

    while ($query->have_posts()): $query->the_post();
        $return .= '<tr class="post-item" id="' . get_permalink() . '">';
        $return .= '<td>' . get_the_title() . '</td>';
        $return .= '<td>' . get_the_date() . '</td>';
        $return .= '</tr>';
    endwhile;
    wp_reset_query();

    $return .= '</tbody>';
    $return .= '</table>';

    echo $return;
    exit;
}
add_action('wp_ajax_get_publish_posts', 'ajax_get_publish_posts');

// Widget Init
function osm_image_widget_init() {
    register_widget('OSM_Image_Widget');
}
add_action('widgets_init', 'osm_image_widget_init');

// Widget i18n
load_plugin_textdomain( 'osm-image-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );?>