/*
   Plugin Name:Bootstrap Implementation (Steph)
   Plugin URI: http:www.stephanielynnpitman.com/bootstrap-steph
   Description: Uses Bootstrap as primary visual framework
   Version: 1.0
   Author: Stephanie Pitman
   Author URI: http://www.stephanielynnpitman.com
*/
<?php
error_reporting(0);
add_action('admin_menu','wbs_add_menu');
add_action('admin_init','wbs_settings_init');

function wbs_add_menu(){
	add_options_page('WordPress and Bootstrap Settings Page','WordPress and Bootstrap Settings Page','manage_options','wbs-api-page','wbs_page_create');
}

function wbs_page_create(){
	?>
	<form>
	<h2>WordPress Bootstrap Settings</h2>
	<?php
	settings_fields('wbsHeaderPlugin');
	do_settings_sections('wbsHeaderPlugin');
	submit_button();
	?>
	</form>
	<?php
}

function wbs_settings_init(){
	register_setting('wbsHeaderPlugin','wbs_header_settings');
	add_settings_section('wbs_plugin_header_section',__('Header Settings','wordpress'), 'wbs_section_call', 'wbsHeaderPlugin');
	add_settings_field('wbs_header_colour',__('Colour','wordpress'), 'wbs_select_field_call', 'wbsHeaderPlugin','wbs_plugin_header_section');
}

function wbs_section_call(){
	echo __('Customize Your Website Header','wordpress');
}

function wbs_select_field_call(){
	$options = get_option('wbs_header_settings');
	?>
	<select>
		<option value = 'bg-important'>Blue</option>
		<option value = 'bg-success'>Green</option>
		<option value = 'bg-info'>Indigo</option>
		<option value = 'bg-warning'>Yellow</option>
		<option value = 'bg-danger'>Red</option>
		<option value = 'bg-secondary'>Dark Grey</option>
		<option value = 'bg-dark'>Black</option>
		<option value = 'bg-light'>White</option>
	</select>
	<?php
}
?>
