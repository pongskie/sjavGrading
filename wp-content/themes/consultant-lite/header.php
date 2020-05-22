<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Consultant_Lite
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>

<script type="text/javascript" src="http://localhost/SJA-grading/wp-content/themes/consultant-lite/js/jquery-3.0.0.min.js"></script>
<script type="text/javascript" src="http://localhost/SJA-grading/wp-content/themes/consultant-lite/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">	

<style>
/* Popup box BEGIN */
.hover_bkgr_fricc{
    background:rgba(0,0,0,.4);
    cursor:pointer;
    display:none;
    height:100%;
    position:fixed;
    text-align:center;
    top:0;
    width:100%;
    z-index:100000;
	left: 0px;
}
.hover_bkgr_fricc .helper{
    display:inline-block;
    height:100%;
    vertical-align:middle;
}
.hover_bkgr_fricc > div {
    background-color: #fff;
    box-shadow: 10px 10px 60px #555;
    display: inline-block;
    height: auto;
    max-width: 651px;
    min-height: 100px;
    vertical-align: middle;
    width: 60%;
    position: relative;
    border-radius: 8px;
    padding: 5px 1%;
}
.popupCloseButton {
    background-color: #fff;
    border: 3px solid #999;
    border-radius: 50px;
    cursor: pointer;
    display: inline-block;
    font-family: arial;
    font-weight: bold;
    position: absolute;
    top: -10px;
    right: -20px;
    font-size: 25px;
    line-height: 30px;
    width: 30px;
    height: 30px;
    text-align: center;
}
.popupCloseButton:hover {
    background-color: #ccc;
}

.addbtn {
	box-shadow:inset 0px 1px 0px 0px #d9fbbe !important;
	background:linear-gradient(to bottom, #b8e356 5%, #a5cc52 100%) !important;
	background-color:#b8e356 !important;
	border-radius:6px !important;
	border:1px solid #83c41a !important;
	display:inline-block !important;
	cursor:pointer !important;
	color:#ffffff !important;
	font-family:Arial !important;
	font-size:15px !important;
	font-weight:bold !important;
	padding:10px 24px !important;
	text-decoration:none !important;
	text-shadow:0px 1px 0px #86ae47 !important;
	margin: 30px !important;
}
.addbtn:hover {
	background:linear-gradient(to bottom, #a5cc52 5%, #b8e356 100%) !important;
	background-color:#a5cc52 !important;
}
.addbtn:active {
	position:relative !important;
	top:1px !important;
}


.editbtn {
	box-shadow:inset 0px 1px 0px 0px #fce2c1 !important;
	background:linear-gradient(to bottom, #ffc477 5%, #fb9e25 100%) !important;
	background-color:#ffc477 !important;
	border-radius:6px !important;
	border:1px solid #ffc477 !important;
	display:inline-block !important;
	cursor:pointer !important;
	color:#ffffff !important;
	font-family:Arial !important;
	font-size:15px !important;
	font-weight:bold !important;
	padding:6px 24px !important;
	text-decoration:none !important;
	text-shadow:0px 1px 0px #cc9f52 !important;
}
.editbtn:hover {
	background:linear-gradient(to bottom, #fb9e25 5%, #ffc477 100%) !important;
	background-color:#fb9e25 !important;
}
.editbtn:active {
	position:relative !important;
	top:1px !important;
}


.deletebtn {
	box-shadow:inset 0px 1px 0px 0px #f5978e !important;
	background:linear-gradient(to bottom, #f24537 5%, #c62d1f 100%) !important;
	background-color:#f24537 !important;
	border-radius:6px !important;
	border:1px solid #d02718 !important;
	display:inline-block !important;
	cursor:pointer !important;
	color:#ffffff !important;
	font-family:Arial !important;
	font-size:15px !important;
	font-weight:bold !important;
	padding:6px 24px !important;
	text-decoration:none !important;
	text-shadow:0px 1px 0px #810e05 !important;
}
.deletebtn:hover {
	background:linear-gradient(to bottom, #c62d1f 5%, #f24537 100%) !important;
	background-color:#c62d1f !important;
}
.deletebtn:active {
	position:relative !important;
	top:1px !important;
}


.saveCancelbtn {
	box-shadow:inset 0px 1px 0px 0px #dcecfb !important;
	background:linear-gradient(to bottom, #bddbfa 5%, #80b5ea 100%) !important;
	background-color:#bddbfa !important;
	border-radius:6px !important;
	border:1px solid #dcdcdc !important;
	display:inline-block !important;
	cursor:pointer !important;
	color:#777777 !important;
	font-family:Arial !important;
	font-size:15px !important;
	font-weight:bold !important;
	padding:6px 24px !important;
	text-decoration:none !important;
	text-shadow:0px 1px 0px #528ecc; !important;
}
.saveCancelbtn:hover {
	background:linear-gradient(to bottom, #80b5ea 5%, #bddbfa 100%) !important;
	background-color:#80b5ea !important;
}
.saveCancelbtn:active {
	position:relative !important;
	top:1px !important;
}


.computebtn {
	box-shadow:inset 0px 0px 14px -3px #f2fadc !important;
	background:linear-gradient(to bottom, #dbe6c4 5%, #9ba892 100%) !important;
	background-color:#dbe6c4  !important;
	border-radius:6px  !important;
	border:1px solid #b2b8ad !important;
	display:inline-block !important;
	cursor:pointer !important;
	color:#5D6D7E !important;
	font-family:Arial !important;
	font-size:15px !important;
	font-weight:bold !important;
	padding:6px 24px !important;
	text-decoration:none !important;
	text-shadow:0px 1px 0px white !important;
}
.computebtn:hover {
	background:linear-gradient(to bottom, #9ba892 5%, #dbe6c4 100%) !important;
	background-color:#9ba892 !important;
}
.computebtn:active {
	position:relative !important;
	top:1px !important;
}


.savebtn {
	box-shadow:inset 0px 0px 14px -3px #dcecfb !important;
	background:linear-gradient(to bottom, #bddbfa 5%, #80b5ea 100%) !important;
	background-color:#bddbfa !important;
	border-radius:6px !important;
	border:1px solid #84bbf3 !important;
	display:inline-block !important;
	cursor:pointer !important;
	color:#5D6D7E !important;
	font-family:Arial !important;
	font-size:15px !important;
	font-weight:bold !important;
	padding:6px 24px !important;
	text-decoration:none !important;
	text-shadow:0px 1px 0px white !important;
}
.savebtn:hover {
	background:linear-gradient(to bottom, #80b5ea 5%, #bddbfa 100%) !important;
	background-color:#80b5ea !important;
}
.savebtn:active {
	position:relative !important;
	top:1px !important;
}





table.dataTable thead {background-color:#EAECEE}

tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }

</style>	
	
	
</head>

<script>
//paul pong added to hide header buttons for admin dashboard
setTimeout(
  function() 
  {
	$('#wp-admin-bar-customize').hide();
	$('#wp-admin-bar-wp-logo').hide();
	
	$('#wp-admin-bar-updates').hide();
	$('#wp-admin-bar-comments').hide();
	$('#wp-admin-bar-new-content').hide();
	$('#wp-admin-bar-edit').hide();
	
	$('#wp-admin-bar-dashboard').hide();
	$('#wp-admin-bar-themes').hide();
	$('#wp-admin-bar-widgets').hide();
	$('#wp-admin-bar-menus').hide();
  }, 500);
</script>

<body <?php body_class(); ?>>
<?php if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
	}
?>
<?php if (consultant_lite_get_option('enable_preloader') == 1) { ?>
	<div class="tm-preloader" id="preloader">
		<div class="status" id="status">
			<div class="tm-preloader-wrapper" style="--n: 5">
				<div class="tm-dot" style="--i: 0"> </div>
				<div class="tm-dot" style="--i: 1"> </div>
				<div class="tm-dot" style="--i: 2"> </div>
				<div class="tm-dot" style="--i: 3"> </div>
				<div class="tm-dot" style="--i: 4"> </div>
			</div>
		</div>
	</div>
<?php } ?>
	<div id="page" class="site">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'consultant-lite' ); ?></a>
		<!-- header start -->
		<header class="tm-main-header" id="header">
			<div class="tm-container-fluid">
				<div class="tm-d-flex">
					<!-- logo section -->
					<div class="site-branding">
						<?php 
						$tm_site_logo = "tm-site-logo-disable";
						if ( has_custom_logo() ) {
							$tm_site_logo = "tm-site-logo-with-title";
							if ( ! display_header_text() ) {
								$tm_site_logo = "tm-only-logo-enable";
							}
						} ?>
						<div class="tm-logo-section <?php echo esc_attr($tm_site_logo); ?>">
							<div  style="margin-left: -20px; height: 20px;" class="tm-logo"><?php the_custom_logo(); ?></div>
							<h1 style="margin-left: 80px;" class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<?php	
							$consultant_lite_description = get_bloginfo( 'description', 'display' );
							if ( $consultant_lite_description || is_customize_preview() ) :
								?>
								<p style="margin-left: 70px;" class="site-description"><?php echo esc_html($consultant_lite_description); /* WPCS: xss ok. */ ?></p>
							<?php endif; ?>
						</div>
					</div><!-- .site-branding -->
					<div class="tm-site-features">
						<div class="tm-address-with-social-section" id="tm-address-with-social-icon">
							<!-- top address bat -->
							<div class="tm-address-section tm-d-flex tm-font-semi-bold">
								<!-- location -->
								<?php if (!empty(consultant_lite_get_option('top_header_location'))) { ?>
									<div class="tm-address">
										<div class="tm-icon-section">
											<i class="ion ion-ios-pin"></i>
										</div>
										<div class="tm-desc">
											<h5 class="icon-box-title"><?php esc_html_e( 'Location', 'consultant-lite' ); ?></h5>
											<?php echo esc_html(consultant_lite_get_option('top_header_location'));?>
										</div>
										
									</div>
								<?php } ?>
								
								<!-- telephone -->
								<?php if (!empty(consultant_lite_get_option('top_header_telephone'))) { ?>
									<div class="tm-telephone">
										<div class="tm-icon-section">
											<i class="ion ion-ios-call"></i>
										</div>
										<div class="tm-desc">
											<h5 class="icon-box-title"><?php esc_html_e( 'Telephone', 'consultant-lite' ); ?></h5>
											<a href="tel:<?php echo preg_replace( '/\D+/', '', esc_attr( consultant_lite_get_option('top_header_telephone') ) ); ?>">
												<?php echo esc_attr( consultant_lite_get_option('top_header_telephone') ); ?>
											</a>
										</div>
									</div>
								<?php } ?>

								<?php if (!empty(consultant_lite_get_option('top_header_email'))) { ?>
									<div class="tm-email">
										<div class="tm-icon-section">
											<i class="ion ion-ios-mail"></i>
										</div>
										<div class="tm-desc">
											<h5 class="icon-box-title"><?php esc_html_e( 'Email', 'consultant-lite' ); ?></h5>
											<a href="mailto:<?php echo esc_attr(consultant_lite_get_option('top_header_email') ); ?>">
												<?php echo esc_attr( antispambot(consultant_lite_get_option('top_header_email'))); ?>
											</a>
										</div>
									</div>
								<?php } ?>
	
							</div>
							<!-- social menu -->
							<div class="tm-social-section">
								<?php wp_nav_menu(
									array('theme_location' => 'social-menu',
										'link_before' => '<span>',
										'link_after' => '</span>',
										'menu_id' => 'social-menu',
										'fallback_cb' => false,
										'menu_class'=> 'tm-social-icons tm-social-icons-no-text'
								)); ?>
							</div>
							<!-- primary menu -->
							
						</div>
	
						<div class="tm-menu-button-section">
							<div class="tm-menu-section desktop">
								<div class="tm-menu-icon-section">
									<div class="tm-menu-btn" id="tm-menu-icon">
										<button>
											<?php esc_html_e( 'Menu', 'consultant-lite' ); ?>
											<span><i class="ion ion-ios-list"></i></span> 
										</button>
									</div>
									<div class="tm-social-menu-icon" id="tm-social-menu-icon">
										<button>
											<span></span>
										</button>
									</div>
								</div>
								<nav id="site-navigation" class="main-navigation">
									<?php
									wp_nav_menu( array(
										'theme_location' => 'primary-menu',
										'menu_id'        => 'primary-menu',
										'container' => 'div',
										'container_class' => 'tm-nav-menu-section',
										'menu_class' => 'tm-nav-menu'
									) );
									?>
								</nav><!-- #site-navigation -->
							</div>
							<?php if ( is_active_sidebar( 'consultant-lite-off-canvas-widget' ) ) { ?>
								<!-- button -->
								<div class="tm-btn-section">
									<button  class="tm-btn-border tm-btn-border-primary" id="tm-nav-off-canvas">
										<?php echo esc_html(consultant_lite_get_option('top_call_to_action_button_title')); ?>
										<i class="ion ion-md-arrow-forward"></i>
									</button>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				
			</div>
		</header>
		<div class="tm-mobile-menu">
			<div class="tm-mobile-close-section">
				<div class="tm-close-icon" id="tm-mobile-close">
					<span></span>
					<span></span>
				</div>
			</div>
		</div>
		
	<div id="tm-body-overlay" class="tm-body-overlay"></div>
	<?php if (is_home() &&  is_front_page()) {
		do_action( 'consultant_lite_action_front_page_slider' );
	} ?>
	<?php if (!is_page_template()) { ?>
		<div id="content" class="site-content">
	<?php } ?>
