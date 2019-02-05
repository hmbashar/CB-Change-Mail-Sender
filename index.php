<?php 

/*
 * Plugin Name: CB Change Mail Sender
 * Description: Easy to change mail sender name and email from wordpress default name and email.
 * Version: 1.2
 * Author: Md Abul Bashar
 * Author URI: http://www.codingbank.com
 */




function cb_mail_sender_register() {
	add_settings_section('cb_mail_sender_section', 'CB Mail Sender Options', 'cb_mail_sender_text', 'cb_mail_sender');

	add_settings_field('cb_mail_sender_id', 'CB Mail Sender Name', 'cb_mail_sender_function', 'cb_mail_sender',  'cb_mail_sender_section');

	register_setting('cb_mail_sender_section', 'cb_mail_sender_id');

	add_settings_field('cb_mail_sender_email_id', 'CB Mail Sender Email', 'cb_mail_sender_email', 'cb_mail_sender',  'cb_mail_sender_section');

	register_setting('cb_mail_sender_section', 'cb_mail_sender_email_id');

}
add_action('admin_init', 'cb_mail_sender_register');



function cb_mail_sender_function(){

	echo '<input name="cb_mail_sender_id" type="text" class="regular-text" value="'.get_option('cb_mail_sender_id').'" placeholder="CB Mail Name"/>';

}
function cb_mail_sender_email() {

	echo '<input name="cb_mail_sender_email_id" type="email" class="regular-text" value="'.get_option('cb_mail_sender_email_id').'" placeholder="no_reply@yourdomain.com"/>';

}

function cb_mail_sender_text() {

echo '<p>You may change your WordPress Default mail sender name and email.</p>';

}



function cb_mail_sender_menu() {
	add_menu_page('CB Mail Sender Options', 'CB Mail Sender', 'manage_options', 'cb_mail_sender', 'cb_mail_sender_output', 'dashicons-email');


}
add_action('admin_menu', 'cb_mail_sender_menu');



function cb_mail_sender_output(){
?>	
	<?php settings_errors();?>
	<form action="options.php" method="POST">
		<?php do_settings_sections('cb_mail_sender');?>
		<?php settings_fields('cb_mail_sender_section');?>
		<?php submit_button();?>
	</form>
<?php }








// Change the default wordpress@ email address
add_filter('wp_mail_from', 'cb_new_mail_from');
add_filter('wp_mail_from_name', 'cb_new_mail_from_name');
 
function cb_new_mail_from($old) {
return get_option('cb_mail_sender_email_id');
}
function cb_new_mail_from_name($old) {
return get_option('cb_mail_sender_id');
}




?>