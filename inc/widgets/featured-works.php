<?php
/**
 * $Desc
 *
 * @version    $Id$
 * @package    wpbase
 * @author      Team <opalwordpressl@gmail.com >
 * @copyright  Copyright (C) 2015  prestabrain.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @website  http://www.wpopal.com
 * @support  http://www.wpopal.com/questions/
 */

class Opaljob_featured_works_Widget extends WP_Widget{

    public function __construct() {
         parent::__construct(
            // Base ID of your widget
            'opaljob_featured_works_widget',
            // Widget name will appear in UI
            __('Opal Featured Works', 'opaljob'),
            // Widget description
            array( 'description' => __( 'Featured Works widget.', 'opaljob' ), )
        );
    }

    public function widget( $args, $instance ) {

        
        extract( $args );
	   extract( $instance );
        //Our variables from the widget settings.
        $title  = apply_filters('widget_title', esc_attr($instance['title']));


        //Check

        $tpl = OPALJOB_THEMER_WIDGET_TEMPLATES .'widgets/featured_works/default.php'; 
        $tpl_default = OPALJOB_PLUGIN_DIR .'templates/widgets/featured_works/default.php';
  
        if(  is_file($tpl) ) { 
            $tpl_default = $tpl;
        }
        require $tpl_default;
    }


    // Form

    public function form( $instance ) {
        //Set up some default widget settings.
        $defaults = array( 
            'title' => __('Featured Works', 'opaljob'),
            'num' => '5'
        );              
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e('Title:', 'opaljob'); ?></label>
            <input type="text" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('num')); ?>"><?php __('Limit:', 'pbrthemer'); ?></label>
            <br>
            <input id="<?php echo esc_attr($this->get_field_id('num')); ?>" name="<?php echo esc_attr($this->get_field_name('num')); ?>" type="text" value="<?php echo esc_attr( $instance['num'] ); ?>" />
        </p>
    <?php
    }

    //Update the widget

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        //Strip tags from title and name to remove HTML
        $instance['title']      = strip_tags( $new_instance['title'] );
        $instance['num'] = $new_instance['num'];
        return $instance;
    }
    
}

register_widget( 'Opaljob_featured_works_Widget' );

?>