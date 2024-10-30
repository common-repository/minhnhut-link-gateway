<?php

/*
 *  Link Gate Plugin Class
 *  By Minh Nhut
 *  Http://minhnhut.info
 *  
 *  Link back to http://minhnhut.info is required, if you used a part or all of bellow code.
 * 
 */

class LinkGate {

	const LINK_SHORTCODE = 'linkgate';
	const REDIRECT_SHORTCODE = 'linkgate-redirector';
	protected $rewrite_en = false;
	protected $rewrite_prefix = "redirect";

	public function __construct() {
		add_shortcode(self::LINK_SHORTCODE, array($this, 'link_shortcode'));
		add_shortcode(self::REDIRECT_SHORTCODE, array($this, 'redirector_shortcode'));
		add_action('admin_menu',array($this, 'admin_menu'));
	}

	/**
	 * 
	 * @param Atrributes $atts
	 * @param Inner content $content
	 */
	public function link_shortcode($atts, $content = '') {
		extract(shortcode_atts(array(
		'url' => get_site_url(),
		'title' => 'Redirect link',
		), $atts));
		//$url = (($this->rewrite_en) ? get_site_url().$this->rewrite_prefix.'/?=' : plugins_url().'/minhnhut-link-gate/redirector.php?url=') . urlencode($url);
		$url = get_site_url() . '/' . (get_option('mn_linkgate_page_slug') ?  get_option('mn_linkgate_page_slug') : 'redirect') . '/?url=' . urlencode($url);
		return '<a href="'.$url.'" title="'.$title.'">'.$content.'</a>';
	}
	
	/**
	 * Render redirector page
	 */
	public function redirector_shortcode() {
		$Redirector = new LinkGateRedirector($_GET);
		$Redirector -> render();
	}
	
	public function register_settings() {
		register_setting('linkgate-settings', 'mn_linkgate_page_slug');
		register_setting('linkgate-settings', 'mn_linkgate_delay');
		register_setting('linkgate-settings', 'mn_linkgate_back_url');
		register_setting('linkgate-settings', 'mn_linkgate_page_title');
		register_setting('linkgate-settings', 'mn_linkgate_page_description');
		register_setting('linkgate-settings', 'mn_linkgate_page_back');
		register_setting('linkgate-settings', 'mn_linkgate_page_go');
	}
	
	public function linkgate_option_page() {
		?>
			<div class='wrap'>
			<h2>Link Gate Redirector <small>by <a href="http://minhnhut.info">Minh Nhut</a></small></h2>
			<p>Linking Gateway for Outbound link. Take resposible for redirecting user to target external url. This plugin allow you to create a custom page that people will see before they leave your website.</p>
			<h3>Configuation</h3>
			<p><strong>Notice</strong>: Use shortcode <strong>[linkgate-redirector]</strong> in your page to make that page become redirect page</p>
			<form method="post" action="options.php">
				<?php settings_fields('linkgate-settings'); ?>
				<?php do_settings_sections( 'linkgate-settings' ); ?>
				<table class="form-table">
					<tr>
						<th>Redirect page's slug</th>
						<td><input id="page-slug" type='text' placeholder="redirect" class="regular-text" name="mn_linkgate_page_slug" value="<?php echo get_option('mn_linkgate_page_slug'); ?>" />
						<p class="description">Default: <strong>redirect</strong></p>
						<p>Redirect page will look like <?php echo get_site_url() ?>/<strong id="demo-page-slug">[page-slug]</strong>/</p></td>
					</tr>
					<tr>
						<th>Delay</th>
						<td><input type='number' min="0" class="regular-text" name="mn_linkgate_delay" value="<?php echo get_option('mn_linkgate_delay'); ?>" /> seconds
						<p class="description">Default: <strong>5</strong> seconds</p></td>
						
					</tr>
					<tr>
						<th>Default come back url</th>
						<td>
							<input type='text' placeholder="Enter url here" name="mn_linkgate_back_url" value="<?php echo get_option('mn_linkgate_back_url'); ?>" />
							<p class="description">Default url that user will be redirect to when referer's value in HTTP Header is empty.</p>
							<p class="description">Default: Your home page</p>
						</td>
					</tr>
				</table>
				<h3>Redirect display</h3>
				<p>You can customize text to be displayed on redirect page through bellow settings.</p>
				<table class="form-table">
					<tr>
						<th>Heading title</th>
						<td><input id="page-slug" type='text' placeholder="redirect" class="regular-text" name="mn_linkgate_page_title" value="<?php echo get_option('mn_linkgate_page_title'); ?>" />
						<p class="description">Default: <strong>You will be redirect soon</strong></p>				
					</tr>
					<tr>
						<th>Description</th>
						<td><textarea name="mn_linkgate_page_description" rows="10" cols="50" class="medium-text-code" ><?php echo get_option('mn_linkgate_page_description'); ?></textarea>						
					</tr>
					<tr>
						<th>Back button's text</th>
						<td>
							<input type='text' placeholder="Back" name="mn_linkgate_page_back" class="regular-text" value="<?php echo get_option('mn_linkgate_page_back'); ?>" />
						</td>
					</tr>
					<tr>
						<th>Go button's text</th>
						<td>
							<input type='text' placeholder="Back" name="mn_linkgate_page_go" class="regular-text" value="<?php echo get_option('mn_linkgate_page_go'); ?>" />
						</td>
					</tr>
				</table>
				<p>Notice: Redirect page is just a page of WordPress. You can create your own template in your theme's folder and use it for your redirect page.</p>
				
				<script>
					function updateUrl() {
						var slug = jQuery("#page-slug").val();
						if (slug == '') {
							slug = 'redirect';
						}
						jQuery("#demo-page-slug").html(slug);
					}
					updateUrl();
					jQuery("#page-slug").keyup(function(){
						updateUrl();
					});
				</script>
				
				<?php submit_button(); ?>
			</form>
			
			
			</div>
		<?php
	}
	
	public function admin_menu() {
		add_options_page("MinhNhut - Link Gate", "Link Gate Redirector", "manage_options", "linkgate", array($this, 'linkgate_option_page'));
		
		add_action( 'admin_init', array($this, 'register_settings') );
	}

	/*
	 * Run during the activation of the plugin
	*/
	function activate() {

		if (!get_option('mn_linkgate_created', false)) {
			global $wpdb;
	
			$my_page = array (
					'post_title' => 'Redirect',
					'post_content' => '[linkgate-redirector]',
					'post_status' => 'publish',
					'post_type' => 'page',
					'post_author' => 2,
					'post_date' => date ( "Y-m-d H:i:s", time () )
			);
	
			$post_id = wp_insert_post ( $my_page );
			$post = get_post($post_id);
			$slug = $post->post_name;
			
			if (!add_option('mn_linkgate_page_slug', $slug)) {
				update_option('mn_linkgate_page_slug', $slug);
			}
			
			
			add_option('mn_linkgate_page_created', true);
		}
		$this->add_options();
	}
	
	/**
	 * set default value for all options
	 */
	protected function add_options() {
		add_option('mn_linkgate_page_slug', 'redirect');
		add_option('mn_linkgate_back_url', get_site_url());
		add_option('mn_linkgate_page_delay', '5');
		add_option('mn_linkgate_page_title', 'Your will be redirect soon');
		add_option('mn_linkgate_page_description', 'You will be redirect to this url which is not a part of our website:');
		add_option('mn_linkgate_page_back', 'Back');
		add_option('mn_linkgate_page_go', 'Go');
	}
	
	/**
	 * remove all options, used by reset options function. However, not implemented yet.
	 */
	protected function remove_options() {
		delete_option('mn_linkgate_page_slug');
		delete_option('mn_linkgate_delay');
		delete_option('mn_linkgate_back_url');
		delete_option('mn_linkgate_page_title');
		delete_option('mn_linkgate_page_description');
		delete_option('mn_linkgate_page_back');
		delete_option('mn_linkgate_page_go');
	}

	function deactivate() {
		global $wp_rewrite;
		$wp_rewrite -> flush_rules();
	}

	/*
	 * Run during the initialization of Wordpress
	*/
	function initialize() {
		
	}
}

/*
 *  Redirector Class
 *
 */

class LinkGateRedirector {
	protected $template;
	protected $template_url;
	protected $template_path;

	protected $title;
	protected $description;
	protected $back;
	protected $go;
	
	protected $url;
	protected $back_url; // back to url - default blog's home page
	protected $redirect_time = 5; // in seconds - default 5 second

	protected $args;

	public function __construct($args) {
		// default attributes
		// $this->title = "Test title"; decapreted
		$this->redirect_time = get_option('mn_linkgate_delay') ? get_option('mn_linkgate_delay') : 5;
		$this->back_url = get_option('mn_linkgate_back_url') ? get_option('mn_linkgate_back_url') : get_site_url();

		$this->title = get_option('mn_linkgate_page_title', 'Your will be redirect soon');
		$this->description = get_option('mn_linkgate_page_description', 'You will be redirect to this url which is not a part of our website:');
		$this->back = get_option('mn_linkgate_page_back', 'Back');
		$this->go = get_option('mn_linkgate_page_go', 'Go');
		
		// template
		$this->template = "default";
		$this->template_path = dirname ( __FILE__ ) . '/templates/'. $this->template . '/';
		$this->template_url = plugin_dir_url(__FILE__) . '/templates/'. $this->template . '/';

		if (isset($_SERVER['HTTP_REFERER'])) {
			$this->back_url = $_SERVER['HTTP_REFERER'];
		} else {
			$this->back_url = get_site_url();
		}

		if (isset($args['title'])) {
			$this->title = $args['title'];
		}

		if (isset($args['url'])) {
			$this->url =  urldecode($args['url']);
		}

		if (isset($args['back_url'])) {
			$this->back_url = $args['back_url'];
		}

		if (isset($args['redirect_time'])) {
			$this->redirect_time = $args['redirect_time'];
		}
	}

	public function render() {
		include ($this->template_path . 'index.php'); // show it
	}

	public function getCssPath() {
		echo $this->template_url . 'style.css';
	}
}