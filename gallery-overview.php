<?php
/*
Plugin Name: Gallery Overview
Plugin URI: http://www.antwortzeit.de/plugins/gallery
Description: This plugin fixes the one thing that is really wrong with WordPress' Core Gallery:  You don't have an Gallery Overview Page, that lists all your galleries. Well, now you do.
Version: 0.1
Text Domain: gallery_overview
Domain Path: /languages
Author: Antwortzeit Kommunikationsagentur
Author URI: http://www.antwortzeit.de
License: GPLv2 or later
*/

if(!class_exists('Gallery_Overview')) {
	class Gallery_Overview {
		
		/** * Construct the plugin object */
		public function __construct() { 
			add_action('admin_init', array(&$this, 'admin_init'));
			add_action('admin_menu', array(&$this, 'add_menu'));
			add_action('init', array(&$this, 'wp_init'));
		} 
		
		/** * Activate the plugin */
		public static function activate() {
			
		} 
		
		/** * Deactivate the plugin */
		public static function deactivate() {
			
		}
		
		/** * hook into WP's admin_init action hook */
		public function admin_init() {
			$this->init_settings();
		}
		
		/** * add a menu */
		public function add_menu() {
			add_options_page(__('Gallery Overview Settings', 'gallery_overview'), __('Gallery Overview', 'gallery_overview'), 'manage_options', 'gallery_overview', array(&$this, 'plugin_settings_page')); 
		}
		
		/** * Menu Callback */
		public function plugin_settings_page() {
			if(!current_user_can('manage_options')) { 
				wp_die(__('You do not have sufficient permissions to access this page.'));
			}
			include(sprintf("%s/admin.php", dirname(__FILE__)));
		}

		/** * hook into WP's init action hook */
		public function wp_init() {
			load_plugin_textdomain('gallery_overview', false, basename( dirname( __FILE__ ) ) . '/languages' );
			add_filter('the_content', array(&$this, 'gallery_overview_output'));
		}
		
		/** * initialize our settings */
		public function init_settings() {
			register_setting('gallery_overview-settings', 'gallery_overview', array($this, 'settings_sanitization') );
			add_settings_section('gallery_overview-main', '', array($this, 'settings_text_header'), 'gallery_overview-settings_sections');
			add_settings_field('page_id', __('Add to Page', 'gallery_overview'), array($this, 'settings_page_id'), 'gallery_overview-settings_sections', 'gallery_overview-main');
			add_settings_field('all_galleries', __('List all Galleries (Not only from Child Pages)?', 'gallery_overview'), array($this, 'settings_all_galleries'), 'gallery_overview-settings_sections', 'gallery_overview-main');
			add_settings_field('size', __('Thumbnail Size', 'gallery_overview'), array($this, 'settings_size'), 'gallery_overview-settings_sections', 'gallery_overview-main');
			add_settings_field('limit', __('Limit Images to', 'gallery_overview'), array($this, 'settings_limit'), 'gallery_overview-settings_sections', 'gallery_overview-main');
			add_settings_field('columns', __('Columns', 'gallery_overview'), array($this, 'settings_columns'), 'gallery_overview-settings_sections', 'gallery_overview-main');
			add_settings_field('link', __('Link to Gallery', 'gallery_overview'), array($this, 'settings_link'), 'gallery_overview-settings_sections', 'gallery_overview-main');
			add_settings_section('gallery_overview-footer', __('Shortcode [gallery_overview]', 'gallery_overview'), array($this, 'settings_text_footer'), 'gallery_overview-settings_sections');
		}
		
		/** * make sure limit and colums are numbers */
		function settings_sanitization($values) {
			$values['limit'] = (absint($values['limit'])) ?  $values['limit']: 3;
			$values['columns'] = (absint($values['columns'])) ?  $values['columns']: 3;
			return $values;
		}
		
		/** * all the settings are following */
		function settings_text_header() {
			echo __('<p>This plugin fixes the one thing that is really wrong with WordPress\' Core Gallery:  You don\'t have an Gallery Overview Page, that lists all your galleries. So now all you have to do is add the Gallery Overview to a page and, if you like, fine tune the settings below to your needs. This plugin uses only WordPress\' own code, so you can be sure, that the Gallery Overview will look exactly like your Theme wants it to.</p>', 'gallery_overview');
		}
		
		function settings_page_id() {
			$options = get_option('gallery_overview');
			$pages = get_pages(array(
				'sort_order' => 'ASC',
				'sort_column' => 'post_title',
			));
			if(!isset($options['page_id'])) $options['page_id'] = 0;

			echo '<select id="page_id" name="gallery_overview[page_id]">';
				echo '<option value="0" ' . $selected . '> </option>';
				foreach($pages as $page) {
					$selected = ($options['page_id'] == $page->ID) ? 'selected="selected"' : '';
					$title = '';
					foreach($page->ancestors as $loop)
						$title .= '&nbsp;&nbsp;&nbsp;';
					if($page->ancestors)
						$title .= ' - ';
					$title .= $page->post_title;
					echo '<option value="' . $page->ID . '" ' . $selected . '>' . $title . '</option>';
				}
			echo '</select>';
		}
		
		function settings_all_galleries() {
			$options = get_option('gallery_overview');
			$checked = ($options['all_galleries']) ? 'checked="checked" ' : '';
			echo '<input ' . $checked . ' id="all_galleries" name="gallery_overview[all_galleries]" type="checkbox" />';
		}

		function settings_size() {
			$options = get_option('gallery_overview');
			$sizes = get_thumbnail_sizes();
			if(!isset($options['size'])) $options['size'] = 'thumbnail';
			
			echo '<select id="size" name="gallery_overview[size]">';
			foreach($sizes as $name => $size) {
				$selected = ($options['size'] == $name) ? 'selected="selected"' : '';
				$crop = ($size['crop']) ? ', ' . __('Cropped') : '';
				echo '<option value="' . $name . '" ' . $selected . '>' . $name . ' (' . $size['width'] . 'x' . $size['height'] . $crop . ')</option>';
			}
			echo '</select>';
		}
		
		function settings_limit() {
			$options = get_option('gallery_overview');
			if(!isset($options['columns'])) $options['columns'] = 3;
			echo '<input id="limit" name="gallery_overview[limit]" size="5" type="text" value="' . $options['limit']. '" />';
		}

		function settings_columns() {
			$options = get_option('gallery_overview');
			if(!isset($options['columns'])) $options['columns'] = 3;
			echo '<input id="columns" name="gallery_overview[columns]" size="5" type="text" value="' . $options['columns']. '" />';
		}
		
		function settings_link() {
			$options = get_option('gallery_overview');
			$items = array('heading' => __('Heading', 'gallery_overview'), 'gallery' => __('Gallery', 'gallery_overview'), 'both' => __('Heading and Gallery', 'gallery_overview'), 'none' => __('None', 'gallery_overview'));
			if(!isset($options['link'])) $options['link'] = 'both';
			foreach($items as $key => $name) {
				$checked = ($options['link'] == $key) ? ' checked="checked" ' : '';
				echo '<label><input ' . $checked . ' value="' . $key . '" name="gallery_overview[link]" type="radio" /> ' . $name . '</label><br />';
			}
		}

		function settings_text_footer() {
			echo   __('<p><small>In case these options aren\'t enough for you, you can switch to the shortcode [gallery_overview]. With this <a href="http://codex.wordpress.org/Shortcode_API" title="Shortcode API">shortcode</a> you can place the Gallery Overview on other Post Types and include oder exclude certain Galleries by ID. If you want to use the Shortcode, you might want to set "Add to Page" to blank. Our Shortcode accepts the following parameters:</small></p>
					<small>
						<ul>
							<li><em>all_galleries</em>: List all Galleries (not only from Child Pages). Doesn\'t accept any Parameters.</li>
							<li><em>pages</em>: Include only Galleries from Pages listed comma-separated by ID. Parameters needed like pages="30,42"</li>
							<li><em>limit</em>: Limit the number of images shown. Parameter needed as integer like limit=5</li>
							<li><em>columns</em>: Set the number of columns. Parameter needed as integer like columns=2</li>
							<li><em>size</em>: Chooses an existing thumbnail size. Parameter needed as string like size="medium"</li>
							<li><em>header</em>: Disables the header, if you want to. Remember to put a link on the gallery. Parameter needed is header=false</li>
							<li><em>before</em>: Simple HTML-Output before any other Gallery-Code. Parameter needed is before="&lt;ul&gt;".</li>
							<li><em>after</em>: Simple HTML-Output after any other Gallery-Code. Parameter needed is after="&lt;/ul&gt;".</li>
							<li><em>layout</em>: Well, now it\s getting kind of tricky. With this attribute you can change the appearance of each gallery. There are 4 variables available: "%linkopen%", "%linkclose%", "%heading%" and "%gallery%". You can pass any HTML you\'d like. Example: layout="%linkopen%&lt;h3&gt;%heading%&lt;/h3&gt;%linkclose%" will print you just the heading, wrapped in a link.</li>
							<li><em>link</em>: Let\'s you choose, what will be wrapped in the link. Available Options are "heading", "gallery" and "both". To be used like link="heading".</li>
						</ul>
					</small>
					<p><small>If you have any ideas on how to improve this Shortcode, just send us an email to <a href="mailto:gallery@antwortzeit.de">gallery@antwortzeit.de</a></small></p>', 'gallery_overview');
		}
		
		/** main function to generate the output */
		public function get_gallery_overview( $content = '', $settings = false) {
			$options = get_option('gallery_overview');
			$galleries_string = '';
			
			if(isset($settings) && !empty($settings)) {
				// if our shortcode runs
				$shortcode = shortcode_atts( array(
					'all_galleries'	=> false,
					'pages'			=> false,
					'limit'			=> false,
					'columns'		=> false,
					'size'			=> false,
					'header'		=> false,
					'before'		=> false,
					'after'			=> false,
					'layout'		=> false,
					'link'			=> false,
				), $settings );
				
				$options['page_id'] = get_the_ID();
				$options['all_galleries'] = $shortcode['all_galleries'];
				if($shortcode['limit']) $options['limit'] = $shortcode['limit'];
				if($shortcode['columns']) $options['columns'] = $shortcode['columns'];
				if($shortcode['size']) $options['size'] = $shortcode['size'];
				if($shortcode['link']) $options['link'] = $shortcode['link'];
				if($shortcode['pages']) $options['pages'] = $shortcode['pages'];
				if($shortcode['before']) $options['before'] = $shortcode['before'];
				if($shortcode['after']) $options['after'] = $shortcode['after'];
				if($shortcode['layout']) $options['layout'] = $shortcode['layout'];
				if($shortcode['header'] == 'false') $options['header'] = 'hide';
			} else {
				// if the_content filter runs, let's make sure we're on the right page
				if(!isset($options['page_id']) || $options['page_id'] == '0')
					return $content;
				
				if(!is_page($options['page_id']))
					return $content;
			}
			
			// do we have all the right values? if not, switch to defaults
			$limit 		= (isset($options['limit'])) ? $options['limit'] : 3;
			$columns 	= (isset($options['columns'])) ? $options['columns'] : 3;
			$size 		= (isset($options['size'])) ? $options['size'] : 'thumbnail';
			$link 		= (isset($options['link'])) ? $options['link'] : 'both';
			$pages		= (isset($options['pages'])) ? $options['pages'] : false;
			$before		= (isset($options['before'])) ? $options['before'] : '';
			$after		= (isset($options['after'])) ? $options['after'] : '';
			
			// if you include pages, they should be numeric IDs
			if(isset($pages)) {
				$pages = explode(',', $pages);
				$pages = array_filter($pages, 'is_numeric');
				if(empty($pages)) unset($pages);
			}

			// get the pages requested
			if(isset($options['page_id'])) {
				$children_args = array( 
				    'post_parent' => $options['page_id'],
				    'post_type'   => 'page', 
				    'numberposts' => -1,
				    'post_status' => 'publish'
				);
				if($options['all_galleries']) {
					unset($children_args['post_parent']);
				}
				if($pages) {
					$children_args['include'] = $pages;
					$children_args['post_type'] = 'any';
					unset($children_args['post_parent']);
				}
				$children = get_posts($children_args);
			}
			
			// find the galleries in those pages
			if($children) {
				foreach($children as $child) {
					if(has_shortcode( $child->post_content, 'gallery')) {
					    $pattern = get_shortcode_regex();
					
					    if ( preg_match_all( '/'. $pattern .'/s', $child->post_content, $matches )
					        && array_key_exists( 2, $matches )
					        && in_array( 'gallery', $matches[2] ) ) {
					        	$gallery_posts[$child->ID] = $child;
					        	$gallery_posts[$child->ID]->galleries = $matches[0];
					    }						
					}
				}
			}
			
			// yeah, we're building the gallery-code
			if($gallery_posts) {
				foreach($gallery_posts as $gallery_post) {
					$gallery_string = '';

					$linkopen = '<a href="' . get_permalink( $gallery_post->ID ) . '" title="' . the_title_attribute( array( 'post' => $gallery_post->ID, 'echo' => FALSE) ) . '">';
					$linkclose = '</a>';
					$heading = $gallery_post->post_title;
					
					if($gallery_post->galleries) {
						foreach($gallery_post->galleries as $gallery) {
							$attr = shortcode_parse_atts(rtrim(str_replace('[gallery ', '', $gallery), ']'));

							// adopting the order rules by gallery_shortcode()
							if ( ! empty( $attr['ids'] ) ) {
								// 'ids' is explicitly ordered, unless you specify otherwise.
								if ( empty( $attr['orderby'] ) )
									$attr['orderby'] = 'post__in';
									
								$attr['include'] = $attr['ids'];
							}

							// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
							if ( isset( $attr['orderby'] ) ) {
								$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
								if ( !$attr['orderby'] )
									unset( $attr['orderby'] );
							}

							// let's filter the users shortcode attributes against
							// our defaults and overwrite some of them 
							$args = shortcode_atts(array(
								'order'      => 'ASC',
								'orderby'    => 'menu_order ID',
								'include'    => '',
								'exclude'    => '',
								'columns'	 => $columns,
								'size'		 => $size
							), $attr, 'gallery');
							$args['link'] = 'none';
							$args['id'] = $gallery_post->ID;
							if ( 'RAND' == $args['order'] )
								$args['orderby'] = 'none';

							// we want to limit the gallery images, but we have to respect
							// the users ordering. so we have to build our own include-list
							if( ! empty( $args['include'] ) ) {
								$attachments = explode(',', $args['include']);
							} else {
								$get_children_args = array(
									'post_parent' => $args['id'],
									'exclude' => $args['exclude'],
									'post_status' => 'inherit',
									'post_type' => 'attachment',
									'post_mime_type' => 'image',
									'numberposts' => $limit,
									'order' => $args['order'],
									'orderby' => $args['orderby'],
									'fields' => 'ids'
								);
								if( ! empty( $attr['exclude'] ) ) 
									$get_children_args['exclude'] =  $args['exclude'];
								$attachments = get_children( $get_children_args );
							}
							if($attachments) {
								$attachments = array_slice( $attachments, 0, $limit);
								$args['include'] = implode( ',', $attachments);
							}
															
							// build up the attributes for our very own instance of the shortcode
							$build_args = '';
							if($args) {
								foreach($args as $key => $arg) {
									$build_args .= ' ' . $key . '="' . $arg . '"';
								}
							}
							
							// finally prepend the new gallery to the content,
							// wrapped in the code above and below
							$gallery_string .= do_shortcode("[gallery $build_args]");
						}
					}

					// last hacks to our output
					if($options['header'] == 'hide')
						$heading = '';
					
					// you can specify your own layout in the shortcode
					// use %linkopen% %linkclose% %heading% and %gallery% to build it
					// if you dont provide your layout or if we're not using the shortcode
					// we should build the regular layout right here
					if(isset($options['layout']) && !empty($options['layout'])) {
						$layout = $options['layout'];
						$layout = str_replace(array('\r', '\n', '<br />', '</br>', '<p>', '</p>'), '', $layout);
						
						$layout = str_replace('%linkopen%', '%1$s', $layout);
						$layout = str_replace('%linkclose%', '%2$s', $layout);
						$layout = str_replace('%heading%', '%3$s', $layout);
						$layout = str_replace('%gallery%', '%4$s', $layout);
						
						$galleries_string .= sprintf($layout, $linkopen, $linkclose, $heading, $gallery_string);
					} else {
						switch($link) {
							case 'gallery' :
								$galleries_string .= sprintf('%3$s%1$s%4$s%2$s', $linkopen, $linkclose, '<h2>' . $heading . '</h2>', $gallery_string);
								break;
							case 'heading' :
								$galleries_string .= sprintf('%1$s%3$s%2$s%4$s', $linkopen, $linkclose, '<h2>' . $heading . '</h2>', $gallery_string);
								break;
							default :
								$galleries_string .= sprintf('%1$s%3$s%4$s%2$s', $linkopen, $linkclose, '<h2>' . $heading . '</h2>', $gallery_string);
						}
					}

				}
			}
			
			// content is what you threw in as first parameter,
			// before and after can only be specified by shortcode
			// and galleries_string does the magic
			return $content . $before . $galleries_string . $after;
		}
		
		/** * output the galery overview on post_content filter */
		public function gallery_overview_output( $content ) {
			return $this::get_gallery_overview($content);
		}
	}
}

if(class_exists('Gallery_Overview')) {
	register_activation_hook(__FILE__, array('Gallery_Overview', 'activate'));
	register_deactivation_hook(__FILE__, array('Gallery_Overview', 'deactivate'));
	
	$gallery_overview = new Gallery_Overview();
}

/** * Add a link to the settings page onto the plugin page */
if(isset($wp_plugin_template)) {
	function plugin_settings_link($links) {
		$settings_link = '<a href="options-general.php?page=gallery_overview">Settings</a>';
		array_unshift($links, $settings_link);
		return $links;
	}
	$plugin = plugin_basename(__FILE__);
	add_filter("plugin_action_links_$plugin", 'plugin_settings_link');
}

/** * This provides our very own shortcode */
function gallery_overview_shortcode($atts) {
	$settings = shortcode_atts( array(
		'all_galleries'	=> false,
		'pages'			=> false,
		'limit'			=> false,
		'columns'		=> false,
		'size'			=> false,
		'header'		=> false,
		'before'		=> false,
		'after'			=> false,
		'layout'		=> false,
		'link'			=> false,
	), normalize_empty_atts($atts), 'gallery_overview' );
	
	return Gallery_Overview::get_gallery_overview( '', $settings);
}
add_shortcode('gallery_overview', 'gallery_overview_shortcode');

/** * WordPress doesn't bring a function to list thumbnail sizes.
	  At least it didn't while we wrote this */
if(!function_exists('get_thumbnail_sizes')) {
	function get_thumbnail_sizes(){
		global $_wp_additional_image_sizes;
		$sizes = array();
		foreach( get_intermediate_image_sizes() as $s ){
			$sizes[ $s ] = array( 0, 0 );
			if( in_array( $s, array( 'thumbnail', 'medium', 'large' ) ) ){
				$sizes[ $s ]['width'] = get_option( $s . '_size_w' );
				$sizes[ $s ]['height'] = get_option( $s . '_size_h' );
				$sizes[ $s ]['crop'] = (bool) get_option( $s . '_crop');
			}else{
				if( isset( $_wp_additional_image_sizes ) && isset( $_wp_additional_image_sizes[ $s ] ) )
					$sizes[ $s ] = array(
						'width' => $_wp_additional_image_sizes[ $s ]['width'],
						'height' => $_wp_additional_image_sizes[ $s ]['height'],
						'crop' => $_wp_additional_image_sizes[ $s ]['crop']
					);
			}
		}
		
		return $sizes;
	}
}

/** * WordPress also doesn't like empty shortcode atts. But we do */
if (!function_exists('normalize_empty_atts')) {
	function normalize_empty_atts ($atts) {
		foreach ($atts as $attribute => $value) {
			if (is_int($attribute)) {
				$atts[strtolower($value)] = true;
				unset($atts[$attribute]);
			}
		}
		return $atts;
	}
}