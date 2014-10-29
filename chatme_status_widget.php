<?php
/*
Plugin Name: ChatMe Status Widget
Plugin URI: http://chatme.im
Description: Displays the ChatMe User Status.
Author: camaran 
Version: 2.1.2
Author URI: http://chatme.im
*/
class chatme_status_Widget extends WP_Widget {

	//
	//	Constructor
	//
	function chatme_status_Widget() {

		//	'widget_chatme_status' is the CSS class name assigned to the widget
		//	'description' is the widget description that appears in the 'Available Widgets' list in the backend
		$widget_ops = array('classname' => 'widget_chatme_status', 'description' => __('Display the ChatMe User Status') );
		
		//	'status-picture-widget', this will be the ID (random-picture-widget-1, random-picture-widget-2, etc)
		//	__('ChatMe Status Picture') is the title of the widget in the backend
		$this->WP_Widget('status-picture-widget', __('ChatMe Status Picture'), $widget_ops);
		
	}
	
	//
	//	widget() - outputs the content of the widget, in our case: a random picture. 
	//
	function widget($args,$instance) {
	
		extract($args);

		//	Get the title of the widget and the specified width of the image
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$hosted = empty($instance['hosted']) ? ' ' : apply_filters('widget_hosted', $instance['hosted']);
			
		//	Outputs the widget in its standard ul li format.
		echo $before_widget;
		if (!empty( $title )) { 
			echo $before_title . 'ChatMe Status' . $after_title; 
		};
		echo '<ul style="list-style:none;margin-left:0px;">';
		
		//	Let's display the image(s)

			//	Outputs the image
			if ($hosted == "1") { 
				echo '  <li>'. $title .' <img src="http://webchat.domains/status/'.$title.'" alt="ChatMe Status" /></li>';
			} else {
				echo '  <li>'. $title .' <img src="http://webchat.chatme.im/status/'.$title.'" alt="ChatMe Status" /></li>'; 
				}
		
		echo '</ul>';
		echo $after_widget;
		//	Done
	}
	
	//
	//	update() - processes widget options to be saved.
	//
	function update($new_instance, $old_instance) {
		
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['hosted'] = strip_tags($new_instance['hosted']);

		return $instance;
		
	}
	
	//
	//	form() - outputs the options form on admin in Appearance => Widgets (backend). 
	//
	function form($instance) {

		//	Assigns values
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'hosted' => '0' ) );
		$title = strip_tags($instance['title']);
		$hosted = strip_tags($instance['hosted']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('ChatMe Username with domain'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('hosted'); ?>"><?php echo __('Hosted Domain?'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('hosted'); ?>" name="<?php echo $this->get_field_name('hosted'); ?>" type="checkbox" <?php if ($hosted == "1") { echo 'checked=""'; }?> value="1" /></label></p>
		<?php
		
	}

}

//
//	Register the chatme_status_Widget widget class
//
add_action('widgets_init', create_function('', 'return register_widget("chatme_status_Widget");'));

?>