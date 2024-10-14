<?php
/**
 * Iconic One Extra Functions
 */
function iconic_one_excerpts() { ?>
		<div class="entry-summary">
				<!-- Ico nic One home page thumbnail with custom excerpt -->
			<div class="excerpt-thumb">
			<?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : ?>
				<a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'iconic-one' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<?php if ( ( wp_is_mobile() ) ) : ?>
					<?php the_post_thumbnail('excerpt-thumbnail-mobile', 'class=alignleft'); ?>
				<?php else : ?>
					<?php the_post_thumbnail('excerpt-thumbnail', 'class=alignleft'); ?>
				<?php endif;?>
				</a>
			<?php endif;?>
		</div>
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php }

function iop_social_icons() { ?>
		<div class="socialmedia">
			<?php if( get_theme_mod( 'twitter_url' ) !== '' ) { ?>
				<a href="<?php echo esc_url( get_theme_mod( 'twitter_url', 'default_value' ) ); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/img/twitter.png" alt="Follow us on Twitter"/></a> 
			<?php } ?>
			<?php if( get_theme_mod( 'facebook_url' ) !== '' ) { ?>
					<a href="<?php echo esc_url( get_theme_mod( 'facebook_url', 'default_value' ) ); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/img/facebook.png" alt="Follow us on Facebook"/></a>
			<?php } ?>
			<?php if( get_theme_mod( 'instagram_url' ) !== '' ) { ?>
					<a href="<?php echo esc_url(get_theme_mod( 'instagram_url', 'default_value' ) ); ?>" rel="author" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/img/instagram.png" alt="Follow us on Instagram"/></a>
			<?php } ?>
			<?php if( get_theme_mod( 'linkedin_url' ) !== '' ) { ?>
					<a href="<?php echo esc_url(get_theme_mod( 'linkedin_url', 'default_value' ) ); ?>" rel="author" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/img/linkedin.png" alt="Follow us on LinkedIn"/></a>
			<?php } ?>
			<?php if( get_theme_mod( 'rss_url' ) !== '' ) { ?>
			<a class="rss" href="<?php echo esc_url( get_theme_mod( 'rss_url', 'default_value' ) ); ?>" target="_blank"><img src="<?php echo esc_url( get_template_directory_uri()); ?>/img/rss.png" alt="Follow us on rss"/></a>			
			<?php } ?>
		</div>
		<?php }
?>
<?php class iow_screen {
 	public function __construct() {
		/* notice  Lines*/
		add_action( 'load-themes.php', array( $this, 'io_activation_admin_notice' ) );
	}
	public function io_activation_admin_notice() {
		global $pagenow;

		if ( is_admin() && ('themes.php' == $pagenow) && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'io_admin_notice' ), 99 );
		}
	}
	/**
	 * Display an admin notice linking to the welcome screen
	 */
	public function io_admin_notice() {
		?>			
		<div class="updated notice is-dismissible io-notice">
			<h1><?php
			$theme_info = wp_get_theme();
			printf( esc_html__('Congratulations, Welcome to %1$s Theme', 'iconic-one'), esc_html( $theme_info->Name ), esc_html( $theme_info->Version ) ); ?>
			</h1>
			<p><?php echo sprintf( esc_html__("Thank you for choosing Iconic One theme. Check out important first steps at %1\$s welcome page %2\$s.", "iconic-one"), '<a href="' . esc_url( admin_url( 'themes.php?page=iconic_one_theme_options' ) ) . '">', '</a>' ); ?></p>
			
			<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=iconic_one_theme_options' ) ); ?>" class="button button-blue-secondary button_info" style="text-decoration: none;"><?php echo esc_html__('Get started with Iconic One','iconic-one'); ?></a></p>
		</div>
		<?php
	}
	
}
$GLOBALS['iow_screen'] = new iow_screen();?>