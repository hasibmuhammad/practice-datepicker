<?php
/*
Plugin Name: Date Picker
Plugin URI:  
Description: Our Metabox is responsible for showing metabox of our
Version:     1.0
Author:      Hasib Muhammad
Author URI:  https://developer.wordpress.org/
Text Domain: datepicker
Domain Path: /languages
License:     GPL2
*/

class DatePicker {
    function __construct(){
        add_action('plugins_loaded',array($this,'dp_load_plugin_text_domain'));
        add_action('admin_menu',array($this,'dp_datepicker_metabox'));
        add_action('admin_enqueue_scripts',array($this,'enqueue_script'));
        add_action('save_post',array($this,'post_save'));
    }
    function post_save($post_id){
        $datepicker = isset($_POST['dp_'])?$_POST['dp_']:'';
        update_post_meta( $post_id, 'dp_', $datepicker );
    }
    function enqueue_script(){
        wp_enqueue_style('jquery-ui','//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css');
        wp_enqueue_script('dp-datepiker-js',plugin_dir_url(__FILE__).'/assets/admin/js/main.js',array('jquery','jquery-ui-datepicker'),time(),true);
    }
    function dp_load_plugin_text_domain(){
        load_plugin_textdomain('datepicker',false,dirname(__FILE__). '/languages');
    }
    function dp_datepicker_metabox(){
        add_meta_box(
            'datepicker_metabox',
            __('Datepicker Metabox','datepicker'),
            array($this,'dp_metabox_form'),
            'post'
        );
    }
    function dp_metabox_form($post){
        $datepicker = get_post_meta($post->ID,'dp_',true);
        $label = __('Datepicker','datepicker');
        $html = <<<EOD
<p>
<label for="dp_">{$label}</label>
<input type="text" name="dp_" id="dp_" value="{$datepicker}"/>
</p>
EOD;
        echo $html;
    }
}
new DatePicker;





