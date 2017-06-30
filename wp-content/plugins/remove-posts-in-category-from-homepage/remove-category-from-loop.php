<?php
/*
Plugin Name: Remove Posts in Category From Homepage
Plugin URI: http://davidwalsh.name/category-loop
Description: Allows the blogger to prevent posts within a given category from displaying in the main loop
Author: David Walsh
Version: 1.3
Author URI: http://davidwalsh.name
*/
?><?php

	$RCFH_LOOP_LABEL = 'Remove from main loop';
	$RCFH_LOOP_DESCRIPTION = 'Check this box if you would like posts in this category to be prevented from displaying within the main loop.';
	$RCFH_LOOP_OPTION_KEY = 'remove-loop-cats';

	$RCFH_LOOP_RSS_LABEL = 'Remove from RSS feed';
	$RCFH_LOOP_RSS_DESCRIPTION = 'Check this box if you would like posts in this category to be prevented from displaying within the main RSS feed.';
	$RCFH_LOOP_RSS_OPTION_KEY = 'remove-loop-rss-cats';

	function rcfh_loop_value_or_array($value) {
		return $value ? $value : array();
	}

	// Add the extra field to the EDIT category page
	add_action('category_edit_form_fields', 'rcfh_loop_field_edit');
	function rcfh_loop_field_edit($term) {
		global $RCFH_LOOP_LABEL, $RCFH_LOOP_DESCRIPTION, $RCFH_LOOP_OPTION_KEY,
			   $RCFH_LOOP_RSS_LABEL, $RCFH_LOOP_RSS_DESCRIPTION, $RCFH_LOOP_RSS_OPTION_KEY;

		$loop_value = rcfh_loop_value_or_array(get_option($RCFH_LOOP_OPTION_KEY));
		$loop_checked = in_array($term->term_id, $loop_value);

		$rss_value = rcfh_loop_value_or_array(get_option($RCFH_LOOP_RSS_OPTION_KEY));
		$rss_checked = in_array($term->term_id, $rss_value);
 ?>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="removeMainLoop"><?php _e($RCFH_LOOP_LABEL); ?></label></th>
		<td>
			<label for="removeMainLoop">
				&nbsp;&nbsp;<input type="checkbox" name="remove-loop" id="removeMainLoop"<?php echo $loop_checked ? ' checked="checked"' : ''; ?> value="1" style="width:auto;" />
				<span class="description"><?php _e($RCFH_LOOP_DESCRIPTION); ?></span>
			</label>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row" valign="top"><label for="removeMainLoopRSS"><?php _e($RCFH_LOOP_RSS_LABEL); ?></label></th>
		<td>
			<label for="removeMainLoopRSS">
				&nbsp;&nbsp;<input type="checkbox" name="remove-loop-rss" id="removeMainLoopRSS"<?php echo $rss_checked ? ' checked="checked"' : ''; ?> value="1" style="width:auto;" />
				<span class="description"><?php _e($RCFH_LOOP_RSS_DESCRIPTION); ?></span>
			</label>
		</td>
	</tr>
<?php }

	// Add the extra field to the ADD category page
	add_action('category_add_form_fields', 'rcfh_loop_field_create');
	function rcfh_loop_field_create() {
		global $RCFH_LOOP_LABEL, $RCFH_LOOP_DESCRIPTION,
			   $RCFH_LOOP_RSS_LABEL, $RCFH_LOOP_RSS_DESCRIPTION;
?>
	<div class="form-field">
		<label for="removeMainLoop"><?php _e($RCFH_LOOP_LABEL); ?><br />
		<p>
			<input type="checkbox" name="remove-loop" id="removeMainLoop" value="1" style="width:auto;" />
			<span style="display: inline-block;"><?php _e($RCFH_LOOP_DESCRIPTION); ?></span>
		</p>
		</label>
	</div>
	<div class="form-field">
		<label for="removeMainLoopRSS"><?php _e($RCFH_LOOP_RSS_LABEL); ?><br />
		<p>
			<input type="checkbox" name="remove-loop-rss" id="removeMainLoopRSS" value="1" style="width:auto;" />
			<span style="display: inline-block;"><?php _e($RCFH_LOOP_RSS_DESCRIPTION); ?></span>
		</p>
		</label>
	</div>
<?php }

	// Add action for saving extra category information
	add_action('edit_category', 'rcfh_save_loop_value');
	add_action('create_category', 'rcfh_save_loop_value');
	function rcfh_save_loop_value($id) {
		global $RCFH_LOOP_OPTION_KEY, $RCFH_LOOP_RSS_OPTION_KEY;

		// Save the loop option key
		$loop_value = rcfh_loop_value_or_array(get_option($RCFH_LOOP_OPTION_KEY));
		update_option($RCFH_LOOP_OPTION_KEY, rcfh_handle_value_setter('remove-loop', $loop_value, $id));

		// Save the RSS option key
		$rss_value = rcfh_loop_value_or_array(get_option($RCFH_LOOP_RSS_OPTION_KEY));
		update_option($RCFH_LOOP_RSS_OPTION_KEY, rcfh_handle_value_setter('remove-loop-rss', $rss_value, $id));
	}

	function rcfh_handle_value_setter($key, $arr, $id) {
		// Add or remove the loop value
		if(isset($_POST[$key])) {
			array_push($arr, $id);
		}
		else {
			$arr = array_diff($arr, array($id));
		}
		// Ensure no duplicates, just for cleanliness
		return array_unique(array_values($arr));
	}

	// Filter for removing said category posts from main loop
	add_action('pre_get_posts', 'rcfh_prevent_posts');
	function rcfh_prevent_posts($query) {
		global $RCFH_LOOP_OPTION_KEY, $RCFH_LOOP_RSS_OPTION_KEY;

		$c = '';

		// Only remove categories if it's the main query/homepage
		if($query->is_main_query()) {
			if($query->is_home()) {
				$loop_value = rcfh_loop_value_or_array(get_option($RCFH_LOOP_OPTION_KEY));
				if(count($loop_value)) {
					$c = '-'.implode(',-', $loop_value);
				}
			}
			if($query->is_feed) {
				$rss_value = rcfh_loop_value_or_array(get_option($RCFH_LOOP_RSS_OPTION_KEY));
				if(count($rss_value)) {
					$c = '-'.implode(',-', $rss_value);
				}
			}
		}

		// Set it
		$query->set('cat', $c);

	}
?>
