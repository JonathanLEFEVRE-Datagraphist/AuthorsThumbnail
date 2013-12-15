<?php
/**
 * Plugin Name: Author's thumbnail
 * Plugin URI: #
 * Description: This plugins makes it easier to display a thumbnail associated with the author of the post, just upload an image through your user's profile. Add the following code to your theme loop ( content.php for twenty-thirteen): <?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?>  or copy-paste the shortcode: [my_avatar] in your posts & pages.
 * Version: 1.0
 * Author: Jonathan LEFEVRE for Netmediaeurope
 * License: GPL2 Licence 
 */

 
 //Creation of the custom extra field in user's profile to upload their own avatar via an URL
function be_custom_avatar_field( $user ) { ?>
	<h3>Custom Avatar</h3>
	 
	<table>
	<tr>
	<th><label for="be_custom_avatar">Custom Avatar URL:</label></th>
	<td>
	<input type="text" name="be_custom_avatar" id="be_custom_avatar" value="<?php echo esc_attr( get_the_author_meta( 'be_custom_avatar', $user->ID ) ); ?>" /><br />
	<span>Type in the URL of the image you'd like to use as your avatar. This will override your default Gravatar, or show up if you don't have a Gravatar. <br /><strong>Image should be 70x70 pixels.</strong></span>
	</td>
	</tr>
	</table>
	<?php 
}
add_action( 'show_user_profile', 'be_custom_avatar_field' );
add_action( 'edit_user_profile', 'be_custom_avatar_field' );
 
/**
 * Save Custom Avatar Field
 * @author Bill Erickson
 * @link http://www.billerickson.net/wordpress-custom-avatar/
 *
 * @param int $user_id
 */
function be_save_custom_avatar_field( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
		update_usermeta( $user_id, 'be_custom_avatar', $_POST['be_custom_avatar'] );
}
add_action( 'personal_options_update', 'be_save_custom_avatar_field' );
add_action( 'edit_user_profile_update', 'be_save_custom_avatar_field' );

function be_gravatar_filter($avatar, $id_or_email, $size, $default, $alt) {
	$custom_avatar = get_the_author_meta('be_custom_avatar');
	if ($custom_avatar) 
		$return = '<img src="'.$custom_avatar.'" width="'.$size.'" height="'.$size.'" alt="'.$alt.'" />';
	elseif ($avatar) 
		$return = $avatar;
	else 
		$return = '<img src="'.$default.'" width="'.$size.'" height="'.$size.'" alt="'.$alt.'" />';
 
	return $return;
}
add_filter('get_avatar', 'be_gravatar_filter', 10, 5);



//Add a shortcode to display your custom avatar where you want in posts & pages, from : http://ithemes.com/codex/page/Add_the_Post_Author_Avatar
    function my_insert_avatar() {
    global $post;
    return get_avatar($post->post_author, 70 );
} 

add_shortcode('my_avatar', 'my_insert_avatar');



 

 
