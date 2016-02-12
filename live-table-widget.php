<?php
/*
Plugin Name: Tutsplus Widget Pack
Plugin URI: http://code.tutsplus.com
Description: A plugin containing various widgets created in a TutsPlus series on WordPress widgets
Version: 0.1
Author: Tutsplus
Author URI: http://code.tutsplus.com
Text Domain: tutsplustextdomain
License: GPLv2

Copyright 2014  Tutsplus

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


class TutsplusText_Widget extends WP_Widget {

    public function __construct() {

        parent::__construct(
            'tutsplustext_widget',
            __( 'TutsPlus Text Widget', 'tutsplustextdomain' ),
            array(
                'classname'   => 'tutsplustext_widget',
                'description' => __( 'A basic text widget to demo the Tutsplus series on creating your own widgets.', 'tutsplustextdomain' )
                )
        );

        load_plugin_textdomain( 'tutsplustextdomain', false, basename( dirname( __FILE__ ) ) . '/languages' );

    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {

        extract( $args );

        $title      = apply_filters( 'widget_title', $instance['title'] );
        $message    = $instance['message'];

        echo $before_widget;

        if ( $title ) {
            echo $before_title . $title . $after_title;
        }

        echo $message;
        echo $after_widget;

    }


    /**
      * Sanitize widget form values as they are saved.
      *
      * @see WP_Widget::update()
      *
      * @param array $new_instance Values just sent to be saved.
      * @param array $old_instance Previously saved values from database.
      *
      * @return array Updated safe values to be saved.
      */
    public function update( $new_instance, $old_instance ) {

        $instance = $old_instance;

        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['message'] = strip_tags( $new_instance['message'] );

        return $instance;

    }

    /**
      * Back-end widget form.
      *
      * @see WP_Widget::form()
      *
      * @param array $instance Previously saved values from database.
      */
    public function form( $instance ) {

        $title      = esc_attr( $instance['title'] );
        $message    = esc_attr( $instance['message'] );
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('message'); ?>"><?php _e('Simple Message'); ?></label>
            <textarea class="widefat" rows="16" cols="20" id="<?php echo $this->get_field_id('message'); ?>" name="<?php echo $this->get_field_name('message'); ?>"><?php echo $message; ?></textarea>
        </p>

    <?php
    }

}

/* Register the widget */
add_action( 'widgets_init', function(){
     register_widget( 'TutsplusText_Widget' );
});
