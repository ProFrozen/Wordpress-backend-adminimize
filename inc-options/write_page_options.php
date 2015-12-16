<?php
/**
 * @package Adminimize
 * @subpackage Page Options
 * @author Frank Bültge
 */
if ( ! function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a part of plugin, not much I can do when called directly.";
	exit;
}
?>
		<div id="poststuff" class="ui-sortable meta-box-sortables">
			<div class="postbox">
				<div class="handlediv" title="<?php _e('Click to toggle'); ?>"><br/></div>
				<h3 class="hndle" id="config_edit_page"><?php _e('Write options - Page', 'adminimize' ); ?></h3>
				<div class="inside">
					<br class="clear" />

					<table summary="config_edit_page" class="widefat">
						<thead>
							<tr>
								<th><?php _e('Write options - Page', 'adminimize' ); ?></th>
								<?php
									foreach ($user_roles_names as $role_name) { ?>
										<th><?php _e('Deactivate for', 'adminimize' ); echo '<br />' . $role_name; ?></th>
								<?php } ?>
							</tr>
							<tr>
								<td><?php esc_attr_e( 'Select all', 'adminimize' ); ?></td>
								<?php
								foreach ( $user_roles_names as $role_name ) {
									$role_name = strtolower( $role_name );
									$role_name = preg_replace( '/[^a-z0-9]+/', '', $role_name );
									echo '<td class="num">';
									echo '<input id="select_all" class="write_page_options_' . $role_name
											. '" type="checkbox" name="" value="" />';
									echo '</td>' . "\n";
								} ?>
							</tr>
						</thead>

						<tbody>
						<?php
							// pages
							$metaboxes_page = array(
								'#contextual-help-link-wrap',
								'#screen-options-link-wrap',
								'#title, #titlediv, th.column-title, td.title',
								'#pageslugdiv',
								'#pagepostcustom, #pagecustomdiv, #postcustom',
								'#pagecommentstatusdiv, #commentsdiv, #comments, th.column-comments, td.comments',
								'#date, #datediv, th.column-date, td.date, div.curtime',
								'#pagepassworddiv',
								'#pageparentdiv',
								'#pagetemplatediv',
								'#pageorderdiv',
								'#pageauthordiv, #author, #authordiv, th.column-author, td.author',
								'#revisionsdiv',
								'.side-info',
								'#notice',
								'#post-body h2',
								'#media-buttons, #wp-content-media-buttons',
								'#wp-word-count',
								'#slugdiv,#edit-slug-box',
								'#misc-publishing-actions',
								'#commentstatusdiv',
								'#editor-toolbar #edButtonHTML, #quicktags, #content-html'
							);
							
							$post_type = 'page';
							foreach ( $GLOBALS['_wp_post_type_features'][$post_type] as $post_type_support => $key ) {
								if ( post_type_supports( $post_type, $post_type_support ) )
									if ( 'excerpt' === $post_type_support )
										$post_type_support = $post_type . 'excerpt';
									if ( 'page-attributes' === $post_type_support )
										$post_type_support = 'pageparentdiv';
									if ( 'custom-fields' == $post_type_support )
										$post_type_support = $post_type . 'custom';
									if ( 'post-formats' === $post_type_support )
										$post_type_support = 'format';
									array_push( 
										$metaboxes, 
										'#' . $post_type_support . ', #' . $post_type_support . 'div, th.column-' . $post_type_support . ', td.' . $post_type_support
									); // td for raw in edit screen
							}
							
							if ( function_exists('current_theme_supports') && current_theme_supports( 'post-thumbnails', 'page' ) )
								array_push($metaboxes_page, '#postimagediv' );

							// quick edit areas, id and class
							$quickedit_page_areas = array(
								'div.row-actions, div.row-actions .inline',
								'fieldset.inline-edit-col-left',
								'fieldset.inline-edit-col-left label',
								'fieldset.inline-edit-col-left div.inline-edit-date',
								'fieldset.inline-edit-col-left label.inline-edit-author',
								'fieldset.inline-edit-col-left .inline-edit-group',
								'fieldset.inline-edit-col-right',
								'fieldset.inline-edit-col-right .inline-edit-col',
								'fieldset.inline-edit-col-right .inline-edit-group',
								'tr.inline-edit-page p.inline-edit-save'
							);
							$metaboxes_page = array_merge($metaboxes_page, $quickedit_page_areas);

							$metaboxes_names_page = array(
								__('Help'),
								__('Screen Options'),
								__('Title', 'adminimize'),
								__('Permalink', 'adminimize' ),
								__('Custom Fields'),
								__('Comments &amp; Pings', 'adminimize' ),
								__('Date'),
								__('Password Protect This Page', 'adminimize' ),
								__('Attributes', 'adminimize'),
								__('Page Template', 'adminimize' ),
								__('Page Order', 'adminimize' ),
								__('Page Author'),
								__('Page Revisions'),
								__('Related', 'adminimize' ),
								__('Messages', 'adminimize' ),
								__('h2: Advanced Options', 'adminimize' ),
								__('Media Buttons (all)', 'adminimize' ),
								__('Word count', 'adminimize' ),
								__('Page Slug', 'adminimize'),
								__('Publish Actions', 'adminimize' ),
								__('Discussion', 'adminimize'),
								__('HTML Editor Button', 'adminimize')
							);
							
							foreach ( $GLOBALS['_wp_post_type_features'][$post_type] as $post_type_support => $key ) {
								if ( post_type_supports( $post_type, $post_type_support ) )
									array_push( $metaboxes_names, ucfirst($post_type_support) );
							}
							
							if ( function_exists('current_theme_supports') && current_theme_supports( 'post-thumbnails', 'page' ) )
								array_push($metaboxes_names_page, __('Page Image', 'adminimize') );
							
							// quick edit names
							$quickedit_page_names = array(
								'<strong>' .__('Quick Edit Link', 'adminimize') . '</strong>',
								__('QE', 'adminimize') . ' ' . __('Inline Edit Left', 'adminimize'),
								'&emsp;QE &rArr;' . ' ' . __('All Labels', 'adminimize'),
								'&emsp;QE &rArr;' . ' ' . __('Date', 'adminimize'),
								'&emsp;QE &rArr;' . ' ' . __('Author'),
								'&emsp;QE &rArr;' . ' ' . __('Password and Private', 'adminimize'),
								__('QE', 'adminimize') . ' ' . __('Inline Edit Right', 'adminimize'),
								'&emsp;QE &rArr;' . ' ' . __('Parent, Order, Template', 'adminimize'),
								'&emsp;QE &rArr;' . ' ' . __('Status', 'adminimize'),
								__('QE', 'adminimize') . ' ' . __('Cancel/Save Button', 'adminimize')
							);
							$metaboxes_names_page = array_merge($metaboxes_names_page, $quickedit_page_names);
							
							// add own page options
							$_mw_adminimize_own_page_values = _mw_adminimize_get_option_value('_mw_adminimize_own_page_values');
							$_mw_adminimize_own_page_values = preg_split( "/\r\n/", $_mw_adminimize_own_page_values );
							foreach ( (array) $_mw_adminimize_own_page_values as $key => $_mw_adminimize_own_page_value ) {
								$_mw_adminimize_own_page_value = trim($_mw_adminimize_own_page_value);
								array_push($metaboxes_page, $_mw_adminimize_own_page_value);
							}
							
							$_mw_adminimize_own_page_options = _mw_adminimize_get_option_value('_mw_adminimize_own_page_options');
							$_mw_adminimize_own_page_options = preg_split( "/\r\n/", $_mw_adminimize_own_page_options );
							foreach ( (array) $_mw_adminimize_own_page_options as $key => $_mw_adminimize_own_page_option ) {
								$_mw_adminimize_own_page_option = trim($_mw_adminimize_own_page_option);
								array_push($metaboxes_names_page, $_mw_adminimize_own_page_option);
							}
							
							$x = 0;
							$class = '';
							foreach ($metaboxes_page as $index => $metabox) {
								if ($metabox != '') {
									$class = ( ' class="alternate"' == $class ) ? '' : ' class="alternate"';
									$checked_user_role_ = array();
									foreach ($user_roles as $role) {
										$checked_user_role_[$role] = ( isset($disabled_metaboxes_page_[$role]) && in_array($metabox, $disabled_metaboxes_page_[$role]) ) ? ' checked="checked"' : '';
									}
									echo '<tr' . $class . '>' . "\n";
									echo '<td>' . $metaboxes_names_page[$index] . ' <span>(' . $metabox . ')</span> </td>' . "\n";
									foreach ($user_roles as $role) {
										echo '<td class="num">';
										echo '<input id="check_page'. $role.$x .'" class="write_page_options_'
											. preg_replace( '/[^a-z0-9]+/', '', $role ) . '" type="checkbox"'
											. $checked_user_role_[$role] . ' name="mw_adminimize_disabled_metaboxes_page_'
											. $role . '_items[]" value="' . $metabox . '" />';
										echo '</td>' . "\n";
									}
									echo '</tr>' . "\n";
									$x++;
								}
							}
						?>
						</tbody>
					</table>
					
					<?php
					//ypur own page options
					?>
					<br style="margin-top: 10px;" />
					<table summary="config_own_page" class="widefat">
						<thead>
							<tr>
								<th><?php _e('Your own page options', 'adminimize' ); echo '<br />'; _e('ID or class', 'adminimize' ); ?></th>
								<th><?php echo '<br />'; _e('Option', 'adminimize' ); ?></th>
							</tr>
						</thead>

						<tbody>
							<tr valign="top">
								<td colspan="2"><?php _e('It is possible to add your own IDs or classes from elements and tags. You can find IDs and classes with the FireBug Add-on for Firefox. Assign a value and the associate name per line.', 'adminimize' ); ?></td>
							</tr>
							<tr valign="top">
								<td>
									<textarea name="_mw_adminimize_own_page_options" cols="60" rows="3" id="_mw_adminimize_own_page_options" style="width: 95%;" ><?php echo _mw_adminimize_get_option_value('_mw_adminimize_own_page_options'); ?></textarea>
									<br />
									<?php _e('Possible nomination for ID or class. Separate multiple nominations through a carriage return.', 'adminimize' ); ?>
								</td>
								<td>
									<textarea class="code" name="_mw_adminimize_own_page_values" cols="60" rows="3" id="_mw_adminimize_own_page_values" style="width: 95%;" ><?php echo _mw_adminimize_get_option_value('_mw_adminimize_own_page_values'); ?></textarea>
									<br />
									<?php _e('Possible IDs or classes. Separate multiple values through a carriage return.', 'adminimize' ); ?>
								</td>
							</tr>
						</tbody>
					</table>
					
					<p id="submitbutton">
						<input type="hidden" name="_mw_adminimize_action" value="_mw_adminimize_insert" />
						<input class="button button-primary" type="submit" name="_mw_adminimize_save" value="<?php _e('Update Options', 'adminimize' ); ?> &raquo;" /><input type="hidden" name="page_options" value="'dofollow_timeout'" />
					</p>
					<p><a class="alignright button" href="javascript:void(0);" onclick="window.scrollTo(0,0);" style="margin:3px 0 0 30px;"><?php _e('scroll to top', 'adminimize'); ?></a><br class="clear" /></p>

				</div>
			</div>
		</div>
