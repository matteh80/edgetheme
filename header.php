<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php');?>";
</script>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action( 'before' ); ?>

<!--SLIDER-->
<?php
    echo do_shortcode('[smartslider2 slider="1"]');
?>

<nav class="site-navigation">
    <div class="container">
        <div class="row">
            <div class="site-navigation-inner col-sm-12">
                <div class="navbar navbar-default">
                    <div class="navbar-header">
                        <!-- .navbar-toggle is used as the toggle for collapsed navbar content -->
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Your site title as branding in the menu -->
                        <!--<a class="navbar-brand" href="<?php /*echo esc_url( home_url( '/' ) ); */?>" title="<?php /*echo esc_attr( get_bloginfo( 'name', 'display' ) ); */?>" rel="home"><?php /*bloginfo( 'name' ); */?></a>-->
                    </div>

                    <!-- The WordPress Menu goes here -->
                    <?php wp_nav_menu(
                        array(
                            'theme_location' => 'primary',
                            'container_class' => 'collapse navbar-collapse navbar-responsive-collapse',
                            'menu_class' => 'nav navbar-nav',
                            'fallback_cb' => '',
                            'menu_id' => 'main-menu',
                            'walker' => new wp_bootstrap_navwalker()
                        )
                    ); ?>

                </div><!-- .navbar -->
            </div>
        </div>
    </div>

</nav><!-- .site-navigation -->

<div class="main-content">

