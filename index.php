<?php 

/*
 * Plugin Name: CB Change Mail Sender
 * Description: Easy to change mail sender name and email from wordpress default name and email.
 * Version: 1.2.2
 * Author: Md Abul Bashar
 * Author URI: http://www.codingbank.com
 */

// Don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;


/**
 * Load plugin textdomain.
 *
 * @since 1.0.0
 */

 final class CB_mail_sender{

    private function __construct(){
        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Make the class Singleton
     * @return void
     */

    public static function init(){

        static $instance = false;

        if( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Initilaizes the plugin
     * @requires mixed
     */
     public function init_plugin(){
         
         if( is_admin() ) {
             // Stuff only for admin
             add_action( 'admin_init', [ $this, 'cb_mail_sender_register' ] );
             add_action('admin_menu', [ $this, 'cb_mail_sender_menu' ] );
            }else{
                // stuff only for frontned
                
            }
            
            // Common stuff
                        
            // Change the default wordpress@ email address
            add_filter('wp_mail_from', [ $this, 'cb_new_mail_from' ] );
            add_filter('wp_mail_from_name', [ $this, 'cb_new_mail_from_name' ] );

            load_plugin_textdomain( 'cb-mail', false, basename( dirname( __FILE__ ) ) . '/languages' ); // Load textdoamin
     }

     /**
      * Plugin settings page
      * Admin option page
      */
      public function cb_mail_sender_register() {
        add_settings_section('cb_mail_sender_section', __('CB Mail Sender Options', 'cb-mail'), [ $this, 'cb_mail_sender_text' ], 'cb_mail_sender');
    
        add_settings_field('cb_mail_sender_id', __('CB Mail Sender Name','cb-mail'), [ $this, 'cb_mail_sender_function'], 'cb_mail_sender',  'cb_mail_sender_section');
    
        register_setting('cb_mail_sender_section', 'cb_mail_sender_id');
    
        add_settings_field('cb_mail_sender_email_id', __('CB Mail Sender Email', 'cb-mail'), [ $this, 'cb_mail_sender_email' ], 'cb_mail_sender',  'cb_mail_sender_section');

        register_setting('cb_mail_sender_section', 'cb_mail_sender_email_id');
    
    }

    public function cb_mail_sender_function(){
        printf('<input name="cb_mail_sender_id" type="text" class="regular-text" value="%s" placeholder="CB Mail Name"/>', get_option('cb_mail_sender_id'));
    }

    public function cb_mail_sender_email() {
        printf('<input name="cb_mail_sender_email_id" type="email" class="regular-text" value="%s" placeholder="no_reply@yourdomain.com"/>', get_option('cb_mail_sender_email_id'));
    }

    public function cb_mail_sender_text() {
        printf('%s You may change your WordPress Default mail sender name and email %s', '<p>', '</p>');
    }
    
    
    public function cb_mail_sender_menu() {
        add_menu_page(__('CB Mail Sender Options', 'cb-mail'), __('CB Mail Sender', 'cb-mail'), 'manage_options', 'cb_mail_sender', [ $this, 'cb_mail_sender_output' ], 'dashicons-email');
    }

    public function cb_mail_sender_output(){
        ?>	
            <?php settings_errors();?>
            <form action="options.php" method="POST">
                <?php do_settings_sections('cb_mail_sender');?>
                <?php settings_fields('cb_mail_sender_section');?>
                <?php submit_button();?>
            </form>
        <?php }

    public function cb_new_mail_from( $old ) {
        return get_option('cb_mail_sender_email_id');
    }
    public function cb_new_mail_from_name( $old ) {
        return get_option('cb_mail_sender_id');
    }
}

if( ! function_exists( 'cb_change_mail_sender' ) ) {
    function cb_change_mail_sender(){
        return CB_mail_sender::init();
    } 
}

// Kick-off the plugin
cb_change_mail_sender();