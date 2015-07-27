<?php
/*
Plugin Name: ChatMe Status Widget
Plugin URI: http://chatme.im
Description: Displays the ChatMe User Status.
Author: camaran 
Version: 2.2.1
Author URI: http://chatme.im
Text Domain: chatmeim-status-widgt
Domain Path: /languages/
*/
class chatme_status_Widget extends WP_Widget {

	function __construct() {

		$widget_ops = array('classname' => 'widget_chatme_status', 'description' => __('Display the ChatMe User Status', 'chatmeim-status-widgt') );
		parent::__construct('status-picture-widget', __('ChatMe Status Picture', 'chatmeim-status-widgt'), $widget_ops);
		
	}
	
	function widget($args,$instance) {
	
		extract($args);

		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$hosted = empty($instance['hosted']) ? ' ' : apply_filters('widget_hosted', $instance['hosted']);
			
		echo $before_widget;
		if (!empty( $title )) { 
			echo $before_title . __('ChatMe Status', 'chatmeim-status-widgt') . $after_title; 
		};
		echo '<ul style="list-style:none;margin-left:0px;">';
		
			if ($hosted == "1") { 
				echo '  <li>'. $title .' <img src="http://webchat.domains/status/'.$title.'" alt="ChatMe Status" /></li>';
			} else {
				echo '  <li>'. $title .' <img src="http://webchat.chatme.im/status/'.$title.'" alt="ChatMe Status" /></li>'; 
				}
		
		echo '</ul>';
		echo $after_widget;

	}
	
	function update($new_instance, $old_instance) {
		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['hosted'] = strip_tags($new_instance['hosted']);

		return $instance;
		
	}
	
	function form($instance) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'hosted' => '0' ) );
		$title = strip_tags($instance['title']);
		$hosted = strip_tags($instance['hosted']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('ChatMe Username with domain', 'chatmeim-status-widgt'); ?>: <input placeholder="<?php echo __('user@host', 'chatmeim-status-widgt'); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="email" value="<?php echo esc_attr($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('hosted'); ?>"><?php echo __('Hosted Domain?', 'chatmeim-status-widgt'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('hosted'); ?>" name="<?php echo $this->get_field_name('hosted'); ?>" type="checkbox" <?php if ($hosted == "1") { echo 'checked=""'; }?> value="1" /></label></p>
		<?php
		
	}

}

	function languages() {
      		$plugin_dir = basename(dirname(__FILE__));
      		load_plugin_textdomain( 'chatmeim-status-widgt', null, $plugin_dir . '/languages/' );
	}

add_action('widgets_init', create_function('', 'return register_widget("chatme_status_Widget");'));
add_action( 'init', 'languages' );

?>