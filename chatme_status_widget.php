<?php
/*
Plugin Name: ChatMe Status Widget
Plugin URI: http://chatme.im
Description: Displays the ChatMe User Status.
Author: camaran 
Version: 2.0.1
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
			
		//	Outputs the widget in its standard ul li format.
		echo $before_widget;
		if (!empty( $title )) { 
			echo $before_title . 'ChatMe.im Status' . $after_title; 
		};
		echo '<ul style="list-style:none;margin-left:0px;">';
		
		//	Let's display the image(s)

			//	Outputs the image
			echo '  <li>'. $title .'@chatme.im <img src="http://api.chatme.im/status/'.$title.'@chatme.im" alt="ChatMe Status" /></li>';
		
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
		//$instance['width'] = strip_tags($new_instance['width']);

		return $instance;
		
	}
	
	//
	//	form() - outputs the options form on admin in Appearance => Widgets (backend). 
	//
	function form($instance) {

		//	Assigns values
		//$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'width' => '' ) );
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = strip_tags($instance['title']);
		//$width = strip_tags($instance['width']);
		?>
			<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo __('ChatMe Username'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />@chatme.im</label></p>
			<!-- <p><label for="<?php echo $this->get_field_id('width'); ?>"><?php echo __('Width'); ?>: <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo attribute_escape($width); ?>" /></label></p> -->
		<?php
		
	}

}

//
//	Register the chatme_status_Widget widget class
//
add_action('widgets_init', create_function('', 'return register_widget("chatme_status_Widget");'));

?>