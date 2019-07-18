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
register_activation_hook( __FILE__, 'add_card' );
add_action( 'wp_enqueue_scripts', 'add_bootstrap');
add_action('admin_menu','wbs_add_menu');
add_action('admin_init','wbs_settings_init');

//creates the card on the bottom of the index page when the plugin is activated
function add_card(){
	$indexFile = get_template_directory()."/index.php";
	$file = fopen($indexFile, 'a');
	$new_card = "\n".'<div class="card"><div class="card-title">CARD TITLE</div><div class="card-body">SOME TEXT AND STUFF</div></div>';
	fwrite($file, $new_card);
	fclose($file);
}

//optional function that can be used later if multiple cards are wanted
/*global $card_db_version;
$card_db_version = '1.0';
function card_db_install(){	

	global $wpdb;
	global $card_db_version;

	$message = $wpdb->prefix;
	echo "<script type='text/javascript'>alert('$message');</script>";

	$table_name = $wpdb->prefix . 'cards';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		cardId mediumint(9) NOT NULL AUTO_INCREMENT,
		title text NOT NULL,
		PRIMARY KEY  (cardId)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'card_db_version', $card_db_version );

	$table_name = $wpdb->prefix . 'cards_titles';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		titleId mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		cardId mediumint(9) NOT NULL,
		title text NOT NULL,
		FOREIGN KEY (cardId) REFERENCES cards(cardId)
	) $charset_collate;";	

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'card_db_version', $card_db_version );

	$table_name = $wpdb->prefix . 'cards_text';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		textId mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		cardId mediumint(9) NOT NULL,
		text text NOT NULL,
		FOREIGN KEY (cardId) REFERENCES cards(cardId)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'card_db_version', $card_db_version );

}*/

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
		//finds the line that produces the card
		$file = fopen(get_template_directory()."/index.php", 'r');
		$line = "";
		$prevLine = "";
		$line = fgets($file);
		while($line != ""){
			$prevLine = $line;
			$line = fgets($file);
		}

		//gets the card's title and text
		$str_arr = preg_split ("/\=/", $prevLine);  

		//cardTitle
		//trim beginning
		$cardTitle = substr($str_arr[2], strpos($str_arr[2], '">')+2, strlen($str_arr[2]));
		//trim ending
		$cardTitle = substr($cardTitle, 0, strpos($cardTitle,"</"));

		//cardText
		//trim beginning
		$cardText = substr($str_arr[3], strpos($str_arr[3], '">')+2, strlen($str_arr[3]));
		//trim ending
		$cardText = substr($cardText, 0, strpos($cardText,"</"));
		fclose($file);
		
		//places both title and text into textboxes
		?>
		<input type="text" id="cardTitleInput" value="<?php echo $cardTitle; ?>">
		<input type="text" id="cardTextInput" value="<?php echo $cardText; ?>">
			
	</form>
	<?php
	
	/*settings_fields('wbsHeaderPlugin');
	do_settings_sections('wbsHeaderPlugin');*/

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