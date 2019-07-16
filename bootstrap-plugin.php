<?php
/*
   Plugin Name:Bootstrap Implementation (Steph)
   Plugin URI: http:www.stephanielynnpitman.com/bootstrap-steph
   Description: Uses Bootstrap as primary visual framework
   Version: 1.0
   Author: Stephanie Pitman
   Author URI: http://www.stephanielynnpitman.com
*/

error_reporting(0);
add_action( 'wp_enqueue_scripts', 'add_bootstrap');
add_action('admin_menu','wbs_add_menu');
add_action('admin_init','wbs_settings_init');


function add_bootstrap(){
	//option to use boostrap file inside this plugin directory
	//wp_enqueue_style("bootstrap",content_url()."/plugins/bootstrap-steph/css/bootstrap.min.css");

	//option to use bootstrap files with boostrapCDN
	wp_enqueue_style("boostrap","https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
}

function wbs_add_menu(){
	add_options_page('WordPress and Bootstrap Settings Page','WordPress and Bootstrap Settings Page','manage_options','wbs-api-page','wbs_page_create');
}

function wbs_page_create(){
	?>
	<form method="POST">
		<h2>Website Card Settings</h2>
		<?php
		//add cards button
		//a section for each card currently already in site with...
			//a title textbox
			//a body textbox
			//a delete button for this card
		//submit button for changes made
		?>
			
	</form>





	<?php
	
	/*settings_fields('wbsHeaderPlugin');
	do_settings_sections('wbsHeaderPlugin');
	submit_button();*/

	//code that adds a card at the bottom of the index page
	//currently runs everytime the settings page loads (for testing)
	$indexFile = get_template_directory()."/index.php";
	$file = fopen($indexFile, 'a');
	$new_card = "\n".'<div class="card"><div class="card-body">SOME TEXT AND STUFF</div></div>';
	fwrite($file, $new_card);
	fclose($file);
	submit_button("Save Changes");
	?>
	
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
	
}
?>
