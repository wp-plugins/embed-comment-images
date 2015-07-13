<?php
/*
Plugin Name: Embed Images in Comments
Plugin URI: http://www.ascic.net/embed-images-in-comments/
Description: This plugin embeds all image URLs (.jpg, .gif, .png) with an IMG tag.
Author: Zeljko Ascic
Version: 0.3
Author URI: http://www.ascic.net/
*/   
   
/*  Copyright 2015

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php
// create custom plugin settings menu
add_action('admin_menu', 'eiic_create_menu');

function eiic_create_menu() {
	add_options_page('Embed Images in Comments - Plugin Settings', 'Embed Comment Images', 'administrator', __FILE__, 'eiic_settings_page');

	//call register settings function
	add_action( 'admin_init', 'register_eiicsettings' );
}

function register_eiicsettings() {
	//register our settings
	register_setting( 'eiic-settings-group', 'option_eiic' );
}

function eiic_settings_page() {
?>
<div class="wrap">
<h2>Embed Images in Comments</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'eiic-settings-group' ); ?>
    <?php do_settings_sections( 'eiic-settings-group' ); ?>
    <table class="form-table">      
        <tr valign="top">
        <th>Comment image size in pixels: </th>
        <td><input type="text" name="option_eiic" value="<?php echo get_option('option_eiic'); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } ?>
<?php
add_action('comment_text', 'comments_img_embed', 2);
function comments_img_embed($comment) {
  $size = get_option('option_eiic');
  $comment = preg_replace(array('#(http://([^\s]*)\.(jpg|gif|png))#','#(https://([^\s]*)\.(jpg|gif|png))#'),'<img src="$1" alt="" width="'.$size.'" height="" />', $comment);
  return $comment;
}
?>
