<div class="wrap">
	<h2><?php _e('Gallery Overview', 'gallery_overview'); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields('gallery_overview-settings'); ?>
		<?php do_settings_sections('gallery_overview-settings_sections'); ?>
		<?php submit_button(); ?> 
	</form>
</div>