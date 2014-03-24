<?php
/**
 * @package    Adminimize
 * @subpackage Admin Bar Options, settings page
 * @author     Frank Bültge
 * @since      1.8.1  01/10/2013
 */
if ( ! function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a part of plugin, not much I can do when called directly.";
	exit;
}

if ( ! isset( $wp_admin_bar ) )
	$wp_admin_bar = '';

?>
<div id="poststuff" class="ui-sortable meta-box-sortables">
	<div class="postbox">
		<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br/></div>
		<h3 class="hndle" id="admin_bar_options"><?php _e('Admin Bar options', FB_ADMINIMIZE_TEXTDOMAIN ); ?> <em>&middot; Beta</em></h3>
		<div class="inside">
			<br class="clear" />
			<?php
			// add items to array for select
			$admin_bar_items = _mw_adminimize_get_admin_bar_items();
			
			if ( ! isset( $admin_bar_items ) ) {
				echo '<p class="form-invalid">';
				_e( 'To complete the installation for Admin Bar items you must save the settings of Adminimize.', FB_ADMINIMIZE_TEXTDOMAIN );
				echo '</p>';
			} else {
			?>
			<table summary="config_widget" class="widefat">
				<colgroup>
				<?php
				$col = 0;
				foreach ($user_roles_names as $role_name) {
					echo '<col class="col' . $col . '">' . "\n";
					$col ++;
				}
				?>
				</colgroup>
				<thead>
					<tr>
						<th><?php _e('Option', FB_ADMINIMIZE_TEXTDOMAIN ); ?></th>
						<?php
							foreach ($user_roles_names as $role_name) { ?>
								<th><?php _e('Deactivate for', FB_ADMINIMIZE_TEXTDOMAIN ); echo '<br/>' . $role_name; ?></th>
						<?php } ?>
					</tr>
				</thead>

				<tbody>
				<?php
				foreach ( $user_roles as $role ) {
					$disabled_admin_bar_option_[$role] = _mw_adminimize_get_option_value(
						'mw_adminimize_disabled_admin_bar_' . $role .'_items'
					);
				}

				$x = 0;
<<<<<<< HEAD
				
				if ( ! empty( $admin_bar_items ) ) { 
					foreach ( $admin_bar_items as $key => $value ) {
						
						$is_parent = ! empty( $value->parent );
						$has_link  = ! empty( $node->href );
						
=======
				// add items to array for select
				$admin_bar_items = _mw_adminimize_get_admin_bar_items();
				if ( ! empty( $admin_bar_items ) ) {
					foreach ( $admin_bar_items as $key => $value ) {

						$is_parent = ! empty( $value->parent );
						$has_link  = ! empty( $node->href );

>>>>>>> 08e8f8625fdba4a132e500e5dbff64d0fed0265b
						$item_class = ' class="form-invalid"';
						$item_string = '';
						if ( $is_parent ) {
							$item_class = '';
							$item_string = ' &mdash; ';
						}
<<<<<<< HEAD
						
						$checked_user_role_ = array();
						foreach ( $user_roles as $role ) {
							$checked_user_role_[$role]  = ( isset( $disabled_admin_bar_option_[$role] ) && 
								in_array( $key, $disabled_admin_bar_option_[$role] ) 
							) ? ' checked="checked"' : '';
						}
						
						echo '<tr' . $item_class . '>' . "\n";
						echo '<td>' . $item_string . strip_tags( $value->title )
							. ' <span style="color:#ccc; font-weight: 400;">(' 
							. $key . ')</span> </td>' . "\n";
						foreach ( $user_roles as $role ) {
							echo '<td class="num"><input id="check_post'. $role . $x .'" type="checkbox"' 
=======

						$checked_user_role_ = array();
						foreach ( $user_roles as $role ) {
							$checked_user_role_[$role]  = ( isset( $disabled_admin_bar_option_[$role] ) &&
								in_array( $key, $disabled_admin_bar_option_[$role] )
							) ? ' checked="checked"' : '';
						}

						echo '<tr' . $item_class . '>' . "\n";
						echo '<td>' . $item_string . strip_tags( $value->title )
							. ' <span style="color:#ccc; font-weight: 400;">('
							. $key . ')</span> </td>' . "\n";
						foreach ( $user_roles as $role ) {
							echo '<td class="num"><input id="check_post'. $role . $x .'" type="checkbox"'
>>>>>>> 08e8f8625fdba4a132e500e5dbff64d0fed0265b
								. $checked_user_role_[$role] . ' name="mw_adminimize_disabled_admin_bar_'
								. $role .'_items[]" value="' . $key . '" /></td>' . "\n";
						}
						echo '</tr>' . "\n";
						$x ++;
					}
<<<<<<< HEAD
				} // end if
				?>
				</tbody>
			</table>
			
			<?php } ?>
			
=======
				}
				?>
				</tbody>
			</table>

>>>>>>> 08e8f8625fdba4a132e500e5dbff64d0fed0265b
			<p id="submitbutton">
				<input type="hidden" name="_mw_adminimize_action" value="_mw_adminimize_insert" />
				<input class="button button-primary" type="submit" name="_mw_adminimize_save" value="<?php _e('Update Options', FB_ADMINIMIZE_TEXTDOMAIN ); ?> &raquo;" /><input type="hidden" name="page_options" value="'dofollow_timeout'" />
			</p>
			
			<p><a class="alignright button" href="javascript:void(0);" onclick="window.scrollTo(0,0);" style="margin:3px 0 0 30px;"><?php _e('scroll to top', FB_ADMINIMIZE_TEXTDOMAIN); ?></a><br class="clear" /></p>

		</div>
	</div>
</div>
