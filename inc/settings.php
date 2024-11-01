<?php if ( ! defined( 'ABSPATH' ) ) exit; ?><div class="wrap wpsc">
<?php echo $wpsc_link = ($wpsc_pro?'': __('Exclude feature is a premium feature.', 'wp-secure').' <a href="'.esc_url($wpsc_premium_link).'" target="_blank" class="premium">'.__('Go Premium', 'wp-secure').'</a>'); ?>
<h2>WP Secure Content <?php echo '('.$wpsc_data['Version'].($wpsc_pro?') Pro':')'); ?> - <?php echo __('Settings', 'wp-secure'); ?></h2>

<?php 
	if(!empty($_POST) && isset($_POST['wpsc_exclude'])){
		update_option('wpsc_arr', sanitize_wpsc_data($_POST['wpsc_exclude']));
?>
		<div class="notice notice-success is-dismissible">
			<p><?php echo __( 'Successfully updated.'.$wpsc_link, 'wp-secure'); ?></p>
		</div>
<?php	
	}
	$wpsc_arr = get_option('wpsc_arr');
	//pree($wpsc_arr);
	$wpsc_arr = (is_array($wpsc_arr)?$wpsc_arr:array());
	$items = array();
	$args = array(
		'posts_per_page'   => -1,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'title',
		'order'            => 'ASC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'any',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'author'	   => '',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$posts_array = get_posts( $args );
	if(!empty($posts_array)){
		foreach($posts_array as $post){
			$items[$post->post_type][$post->ID] = array('guid'=>$post->guid, 'post_title'=>$post->post_title);
		}
	}
	
	//pree($items);
	if(!empty($items)){
?>
<form action="" method="post">		
<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php echo __( 'Save Changes', 'wp-secure'); ?>" /></p>  
<?php		
		foreach($items as $type=>$list){
?>
		<h4><?php echo __('Check/uncheck to exclude', 'wp-secure'); ?> <i><?php echo strtoupper($type); ?></i></h4>	
		<ul>
<?php     
		foreach($list as $id=>$item){       
?>
		<li><input type="checkbox" name="wpsc_exclude[]" value="<?php echo $id; ?>" <?php echo (in_array($id, $wpsc_arr)?'checked="checked"':''); ?> /><?php echo $item['post_title']; ?> - <a href="post.php?post=<?php echo $id; ?>&action=edit"><?php echo __('Edit', 'wp-secure'); ?></a>&nbsp;|&nbsp;<a href="<?php echo $item['guid']; ?>" target="_blank"><?php echo __('View', 'wp-secure'); ?></a></li>
<?php			
		}
?>
		</ul>
<?php			
		}
?>     
<p class="submit"><input type="submit" name="Submit" class="button-primary" value="<?php _e( 'Save Changes', 'wp-secure'); ?>" /></p>   
</form>
<?php		
	}
?>
</div>	
<style type="text/css">
.update-nag, #wpfooter{ display:none; }
</style>