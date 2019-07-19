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

//enqueues bootstrap into the style of the website
function add_bootstrap(){
	//option to use boostrap file inside this plugin directory
	//wp_enqueue_style("bootstrap",content_url()."/plugins/bootstrap-steph/css/bootstrap.min.css");

	//option to use bootstrap files with boostrapCDN
	wp_enqueue_style("boostrap","https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css");
}

//adds the settings menu for the plugin in the "Settings" menu
function wbs_add_menu(){
	add_options_page('Card Settings Page','Card Settings Page','manage_options','wbs-api-page','wbs_page_create');
}

//creates the settings page
function wbs_page_create(){
	if(isset($_POST["cardTitleInput"]) && isset($_POST["cardTextInput"])){
		//read file into array
		$fileLines = file(get_template_directory()."/index.php");
 
		//pop old card html line
		array_pop($fileLines);
		//append new card html line
		array_push($fileLines,'<div class="card"><div class="card-title">'.$_POST["cardTitleInput"].'</div><div class="card-body">'.$_POST["cardTextInput"].'</div></div>');
 
		//connect array elements 
		$f = join('', $fileLines);
 
		//write updated file back to index.php
		$fileOpen = fopen(get_template_directory()."/index.php", 'w');
		fputs($fileOpen, $f);
		fclose($fileOpen);
	}
	?>
	<form method="post">
		<h2>Website Card Settings</h2>
		
		<?php
		//finds the line that produces the card (stored at the very bottom of index.php)
		$file = fopen(get_template_directory()."/index.php", 'r');
		//$line = "";
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
		Card Title:<input type="text" name="cardTitleInput" value="<?php echo $cardTitle; ?>">
		Card Text:<input type="text" name="cardTextInput" value="<?php echo $cardText; ?>">
		<?php
		submit_button("Save Changes");
		?>		
	
	</form>
	<?php
}

//initializes the settings for the plugin
function wbs_settings_init(){
	register_setting('wbsCardPlugin','wbs_card_settings');
	add_settings_section('wbs_plugin_card_section',__('Card Settings','wordpress'), 'wbs_section_call', 'wbsCardPlugin');
	add_settings_field('wbs_card',__('Card','wordpress'), 'wbs_select_field_call', 'wbsCardPlugin','wbs_plugin_card_section');
}
?>
