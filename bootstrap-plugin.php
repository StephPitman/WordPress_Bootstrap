/**
 * Plugin Name: Bootstrap Implementation (Steph)
 * Plugin URI: http://www.stephanielynnpitman.com/bootstrap-steph
 * Description: Uses Bootstrap as primary visual framework.
 * Version: 1.0
 * Author: Stephanie Pitman
 * Author URI: http://www.stephanielynnpitman.com
 */
<?php
/*creates new page options page, which will be the setting page for the plugin*/
add_action('admin_menu','add_setting_page');
function add_setting_page(){
	add_options_page('Customize Page With Bootstrap', 'Plugin Menu', 'manage_options','plugin','setting_page_creation');
}
/*Creates visual representation of settings page*/
function setting_page_creation(){
	?>
	<div>
		<h2>Customize Page With Bootstrap</h2>
		<form action="custom_bootstrap.php" method="post">
			<input name="Submit" type="submit" value="Save Changes"/>
		</form>
	</div>
	<?php
}
?>
