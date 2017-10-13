<?php
/**
 * @package Betheme
 * @author Muffin group
 * @link http://muffingroup.com
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

/* ==============================================================================================================================
/*	Background																										Background
/* ============================================================================================================================ */
	
html { 
	background-color: <?php mfn_opts_show( 'background-html', '#FCFCFC' ) ?>;
}

#Wrapper, #Content { 
	background-color: <?php mfn_opts_show( 'background-body', '#FCFCFC' ) ?>;
}


/* ==============================================================================================================================
/*	Font | Family																									Font | Family
/* ============================================================================================================================ */

body, button, span.date_label, .timeline_items li h3 span, input[type="submit"], input[type="reset"], input[type="button"],
input[type="text"], input[type="password"], input[type="tel"], input[type="email"], textarea, select, .offer_li .title h3 {
	font-family: "<?php echo str_replace( '#', '', mfn_opts_get( 'font-content', 'Roboto' ) ); ?>", Arial, Tahoma, sans-serif;
}

#menu > ul > li > a, .action_button, #overlay-menu ul li a {
	font-family: "<?php echo str_replace( '#', '', mfn_opts_get( 'font-menu', 'Roboto' ) ); ?>", Arial, Tahoma, sans-serif;
}

#Subheader .title {
	font-family: "<?php echo str_replace( '#', '', mfn_opts_get( 'font-title', 'Lora' ) ); ?>", Arial, Tahoma, sans-serif;
}

h1, h2, h3, h4, .text-logo #logo {
	font-family: "<?php echo str_replace( '#', '', mfn_opts_get( 'font-headings', 'Roboto' ) ); ?>", Arial, Tahoma, sans-serif;
}

h5, h6 {
	font-family: "<?php echo str_replace( '#', '', mfn_opts_get( 'font-headings-small', 'Roboto' ) ); ?>", Arial, Tahoma, sans-serif;
}

blockquote {
	font-family: "<?php echo str_replace( '#', '', mfn_opts_get( 'font-blockquote', 'Roboto' ) ); ?>", Arial, Tahoma, sans-serif;
}

.chart_box .chart .num, .counter .desc_wrapper .number-wrapper, .how_it_works .image .number,
.pricing-box .plan-header .price, .quick_fact .number-wrapper, .woocommerce .product div.entry-summary .price {
	font-family: "<?php echo str_replace( '#', '', mfn_opts_get( 'font-decorative', 'Roboto' ) ); ?>", Arial, Tahoma, sans-serif;
}


/* ==============================================================================================================================
/*	Font | Size & Style																						Font | Size & Style
/* ============================================================================================================================ */

<?php
	$defaults = array(
		'content' => array(
			'size' 				=> 14,
			'line_height' 		=> 25,
			'weight_style' 		=> '400',
			'letter_spacing' 	=> 0,
		),
		'big' => array(
			'size' 				=> 16,
			'line_height' 		=> 28,
			'weight_style' 		=> '400',
			'letter_spacing' 	=> 0,
		),
		'menu' => array(
			'size' 				=> 15,
			'line_height' 		=> 0,
			'weight_style' 		=> '400',
			'letter_spacing' 	=> 0,
		),	
		'title' => array(
			'size' 				=> 30,
			'line_height' 		=> 35,
			'weight_style' 		=> '400italic',
			'letter_spacing' 	=> 1,
		),	
		'h1' => array(
			'size' 				=> 48,
			'line_height' 		=> 50,
			'weight_style' 		=> '400',
			'letter_spacing' 	=> 0,
		),	
		'h2' => array(
			'size' 				=> 30,
			'line_height' 		=> 34,
			'weight_style' 		=> '300',
			'letter_spacing' 	=> 0,
		),	
		'h3' => array(
			'size' 				=> 25,
			'line_height' 		=> 29,
			'weight_style' 		=> '300',
			'letter_spacing' 	=> 0,
		),	
		'h4' => array(
			'size' 				=> 21,
			'line_height' 		=> 25,
			'weight_style' 		=> '500',
			'letter_spacing' 	=> 0,
		),	
		'h5' => array(
			'size' 				=> 15,
			'line_height' 		=> 25,
			'weight_style' 		=> '700',
			'letter_spacing' 	=> 0,
		),	
		'h6' => array(
			'size' 				=> 14,
			'line_height' 		=> 25,
			'weight_style' 		=> '400',
			'letter_spacing' 	=> 0,
		),	
		'intro' => array(
			'size' 				=> 70,
			'line_height' 		=> 70,
			'weight_style' 		=> '400',
			'letter_spacing' 	=> 0,
		),	
	);
	

	if( is_array( mfn_opts_get( 'font-size-content' ) ) ){
		
		$aFont = array(
			'content'	=> mfn_opts_get( 'font-size-content' ),
			'big'		=> mfn_opts_get( 'font-size-big' ),
			'menu'		=> mfn_opts_get( 'font-size-menu' ),
			'title'		=> mfn_opts_get( 'font-size-title' ),
			'h1'		=> mfn_opts_get( 'font-size-h1' ),
			'h2'		=> mfn_opts_get( 'font-size-h2' ),
			'h3'		=> mfn_opts_get( 'font-size-h3' ),
			'h4'		=> mfn_opts_get( 'font-size-h4' ),
			'h5'		=> mfn_opts_get( 'font-size-h5' ),
			'h6'		=> mfn_opts_get( 'font-size-h6' ),
			'intro'		=> mfn_opts_get( 'font-size-single-intro' ),
		);
		
		$aFont = array_replace_recursive( $defaults, $aFont);
		
	} else {
		
		// compatibility with Betheme < 13.5
	
		$defaults['content']['size'] = mfn_opts_get( 'font-size-content', 14 );
		$defaults['big']['size'] = mfn_opts_get( 'font-size-big', 16 );
		$defaults['menu']['size'] = mfn_opts_get( 'font-size-menu', 15 );
		$defaults['title']['size'] = mfn_opts_get( 'font-size-title', 30 );
		$defaults['h1']['size'] = mfn_opts_get( 'font-size-h1', 48 );
		$defaults['h2']['size'] = mfn_opts_get( 'font-size-h2', 30 );
		$defaults['h3']['size'] = mfn_opts_get( 'font-size-h3', 25 );
		$defaults['h4']['size'] = mfn_opts_get( 'font-size-h4', 21 );
		$defaults['h5']['size'] = mfn_opts_get( 'font-size-h5', 15 );
		$defaults['h6']['size'] = mfn_opts_get( 'font-size-h6', 14 );
		$defaults['intro']['size'] = mfn_opts_get( 'font-size-single-intro', 70 );
		
		$aFont = $defaults;
		
	}
	
	$aFontInit = $aFont;
?>

	
/* Body */

	body {
		font-size: <?php echo $aFont['content']['size']; ?>px;
		line-height: <?php echo $aFont['content']['line_height']; ?>px;
		font-weight: <?php echo str_replace( 'italic', '', $aFont['content']['weight_style'] ) ?>;	
		letter-spacing: <?php echo $aFont['content']['letter_spacing']; ?>px;
		<?php if( strpos( $aFont['content']['weight_style'], 'italic' ) ) echo 'font-style: italic;' ?>
	}
	
	big,.big {
		font-size: <?php echo $aFont['big']['size']; ?>px;
		line-height: <?php echo $aFont['big']['line_height']; ?>px;
		font-weight: <?php echo str_replace( 'italic', '', $aFont['big']['weight_style'] ) ?>;	
		letter-spacing: <?php echo $aFont['big']['letter_spacing']; ?>px;
		<?php if( strpos( $aFont['big']['weight_style'], 'italic' ) ) echo 'font-style: italic;' ?>
	}
	
	#menu > ul > li > a, .action_button {
		font-size: <?php echo $aFont['menu']['size']; ?>px;
		font-weight: <?php echo str_replace( 'italic', '', $aFont['menu']['weight_style'] ) ?>;	
		letter-spacing: <?php echo $aFont['menu']['letter_spacing']; ?>px;
		<?php if( strpos( $aFont['menu']['weight_style'], 'italic' ) ) echo 'font-style: italic;' ?>
	}
	#Subheader .title {
		font-size: <?php echo $aFont['title']['size']; ?>px;
		line-height: <?php echo $aFont['title']['line_height']; ?>px;
		font-weight: <?php echo str_replace( 'italic', '', $aFont['title']['weight_style'] ) ?>;	
		letter-spacing: <?php echo $aFont['title']['letter_spacing']; ?>px;
		<?php if( strpos( $aFont['title']['weight_style'], 'italic' ) ) echo 'font-style: italic;' ?>
	}
	
/* Headings */

	h1, .text-logo #logo { 
		font-size: <?php echo $aFont['h1']['size']; ?>px;
		line-height: <?php echo $aFont['h1']['line_height']; ?>px;
		font-weight: <?php echo str_replace( 'italic', '', $aFont['h1']['weight_style'] ) ?>;	
		letter-spacing: <?php echo $aFont['h1']['letter_spacing']; ?>px;
		<?php if( strpos( $aFont['h1']['weight_style'], 'italic' ) ) echo 'font-style: italic;' ?>
	}	
	h2 { 
		font-size: <?php echo $aFont['h2']['size']; ?>px;
		line-height: <?php echo $aFont['h2']['line_height']; ?>px;
		font-weight: <?php echo str_replace( 'italic', '', $aFont['h2']['weight_style'] ) ?>;	
		letter-spacing: <?php echo $aFont['h2']['letter_spacing']; ?>px;
		<?php if( strpos( $aFont['h2']['weight_style'], 'italic' ) ) echo 'font-style: italic;' ?>
	}	
	h3 {
		font-size: <?php echo $aFont['h3']['size']; ?>px;
		line-height: <?php echo $aFont['h3']['line_height']; ?>px;
		font-weight: <?php echo str_replace( 'italic', '', $aFont['h3']['weight_style'] ) ?>;	
		letter-spacing: <?php echo $aFont['h3']['letter_spacing']; ?>px;
		<?php if( strpos( $aFont['h3']['weight_style'], 'italic' ) ) echo 'font-style: italic;' ?>
	}	
	h4 {
		font-size: <?php echo $aFont['h4']['size']; ?>px;
		line-height: <?php echo $aFont['h4']['line_height']; ?>px;
		font-weight: <?php echo str_replace( 'italic', '', $aFont['h4']['weight_style'] ) ?>;	
		letter-spacing: <?php echo $aFont['h4']['letter_spacing']; ?>px;
		<?php if( strpos( $aFont['h4']['weight_style'], 'italic' ) ) echo 'font-style: italic;' ?>
	}	
	h5 {
		font-size: <?php echo $aFont['h5']['size']; ?>px;
		line-height: <?php echo $aFont['h5']['line_height']; ?>px;
		font-weight: <?php echo str_replace( 'italic', '', $aFont['h5']['weight_style'] ) ?>;	
		letter-spacing: <?php echo $aFont['h5']['letter_spacing']; ?>px;
		<?php if( strpos( $aFont['h5']['weight_style'], 'italic' ) ) echo 'font-style: italic;' ?>
	}	
	h6 {
		font-size: <?php echo $aFont['h6']['size']; ?>px;
		line-height: <?php echo $aFont['h6']['line_height']; ?>px;
		font-weight: <?php echo str_replace( 'italic', '', $aFont['h6']['weight_style'] ) ?>;	
		letter-spacing: <?php echo $aFont['h6']['letter_spacing']; ?>px;
		<?php if( strpos( $aFont['h6']['weight_style'], 'italic' ) ) echo 'font-style: italic;' ?>
	}
	
/* Advanced */

	#Intro .intro-title { 
		font-size: <?php echo $aFont['intro']['size']; ?>px;
		line-height: <?php echo $aFont['intro']['line_height']; ?>px;
		font-weight: <?php echo str_replace( 'italic', '', $aFont['intro']['weight_style'] ) ?>;	
		letter-spacing: <?php echo $aFont['intro']['letter_spacing']; ?>px;
		<?php if( strpos( $aFont['intro']['weight_style'], 'italic' ) ) echo 'font-style: italic;' ?>
	}
	
	
		
/* ==============================================================================================================================
/*	Font | Size	Responsive																					Font | Size Responsive
/* ============================================================================================================================ */
	
<?php if( mfn_opts_get('responsive') && mfn_opts_get('font-size-responsive') ): ?>

	<?php
		$min_size = 13;
		$min_line = 19;
	
		// Tablet (Landscape) ------------------------- 768 - 959
		$multiplier = 0.85;
		
		foreach( $aFont as $key => $font ){
			
			$aFont[$key]['size'] = round( $font['size'] * $multiplier );
			if( $aFont[$key]['size'] < $min_size ) $aFont[$key]['size'] = $min_size;
			
			$aFont[$key]['line_height'] = round( $font['line_height'] * $multiplier );
			if( $aFont[$key]['line_height'] < $min_line ) $aFont[$key]['line_height'] = $min_line;
			
		}
	?>
	
	@media only screen and (min-width: 768px) and (max-width: 959px){
		body {
			font-size: <?php echo $aFont['content']['size']; ?>px;
			line-height: <?php echo $aFont['content']['line_height']; ?>px;
		}
		big,.big {
			font-size: <?php echo $aFont['big']['size']; ?>px;
			line-height: <?php echo $aFont['big']['line_height']; ?>px;
		}
		#menu > ul > li > a, .action_button {
			font-size: <?php echo $aFont['menu']['size']; ?>px;
		}
		#Subheader .title {
			font-size: <?php echo $aFont['title']['size']; ?>px;
			line-height: <?php echo $aFont['title']['line_height']; ?>px;
		}
		h1, .text-logo #logo { 
			font-size: <?php echo $aFont['h1']['size']; ?>px;
			line-height: <?php echo $aFont['h1']['line_height']; ?>px;
		}	
		h2 { 
			font-size: <?php echo $aFont['h2']['size']; ?>px;
			line-height: <?php echo $aFont['h2']['line_height']; ?>px;
		}	
		h3 {
			font-size: <?php echo $aFont['h3']['size']; ?>px;
			line-height: <?php echo $aFont['h3']['line_height']; ?>px;
		}	
		h4 {
			font-size: <?php echo $aFont['h4']['size']; ?>px;
			line-height: <?php echo $aFont['h4']['line_height']; ?>px;
		}	
		h5 {
			font-size: <?php echo $aFont['h5']['size']; ?>px;
			line-height: <?php echo $aFont['h5']['line_height']; ?>px;
		}	
		h6 {
			font-size: <?php echo $aFont['h6']['size']; ?>px;
			line-height: <?php echo $aFont['h6']['line_height']; ?>px;
		}
		#Intro .intro-title { 
			font-size: <?php echo $aFont['intro']['size']; ?>px;
			line-height: <?php echo $aFont['intro']['line_height']; ?>px;
		}
		
		blockquote { font-size: 15px;}
		
		.chart_box .chart .num { font-size: 45px; line-height: 45px; }
		
		.counter .desc_wrapper .number-wrapper { font-size: 45px; line-height: 45px;}
		.counter .desc_wrapper .title { font-size: 14px; line-height: 18px;}
		
		.faq .question .title { font-size: 14px; }
		
		.fancy_heading .title { font-size: 38px; line-height: 38px; }
		
		.offer .offer_li .desc_wrapper .title h3 { font-size: 32px; line-height: 32px; }
		.offer_thumb_ul li.offer_thumb_li .desc_wrapper .title h3 {  font-size: 32px; line-height: 32px; }
		
		.pricing-box .plan-header h2 { font-size: 27px; line-height: 27px; }
		.pricing-box .plan-header .price > span { font-size: 40px; line-height: 40px; }
		.pricing-box .plan-header .price sup.currency { font-size: 18px; line-height: 18px; }
		.pricing-box .plan-header .price sup.period { font-size: 14px; line-height: 14px;}
		
		.quick_fact .number { font-size: 80px; line-height: 80px;}

		.trailer_box .desc h2 { font-size: 27px; line-height: 27px; }
	}
	
	<?php
		// Tablet (Portrait) & Mobile (Landscape) ----- 480 - 767
		$multiplier = 0.75;
		
		$aFont = $aFontInit;
		
		foreach( $aFont as $key => $font ){
			
			$aFont[$key]['size'] = round( $font['size'] * $multiplier );
			if( $aFont[$key]['size'] < $min_size ) $aFont[$key]['size'] = $min_size;
			
			$aFont[$key]['line_height'] = round( $font['line_height'] * $multiplier );
			if( $aFont[$key]['line_height'] < $min_line ) $aFont[$key]['line_height'] = $min_line;
			
		}
	?>
	
	@media only screen and (min-width: 480px) and (max-width: 767px){
		body {
			font-size: <?php echo $aFont['content']['size']; ?>px;
			line-height: <?php echo $aFont['content']['line_height']; ?>px;
		}
		big,.big {
			font-size: <?php echo $aFont['big']['size']; ?>px;
			line-height: <?php echo $aFont['big']['line_height']; ?>px;
		}
		#menu > ul > li > a, .action_button {
			font-size: <?php echo $aFont['menu']['size']; ?>px;
		}
		#Subheader .title {
			font-size: <?php echo $aFont['title']['size']; ?>px;
			line-height: <?php echo $aFont['title']['line_height']; ?>px;
		}
		h1, .text-logo #logo { 
			font-size: <?php echo $aFont['h1']['size']; ?>px;
			line-height: <?php echo $aFont['h1']['line_height']; ?>px;
		}	
		h2 { 
			font-size: <?php echo $aFont['h2']['size']; ?>px;
			line-height: <?php echo $aFont['h2']['line_height']; ?>px;
		}	
		h3 {
			font-size: <?php echo $aFont['h3']['size']; ?>px;
			line-height: <?php echo $aFont['h3']['line_height']; ?>px;
		}	
		h4 {
			font-size: <?php echo $aFont['h4']['size']; ?>px;
			line-height: <?php echo $aFont['h4']['line_height']; ?>px;
		}	
		h5 {
			font-size: <?php echo $aFont['h5']['size']; ?>px;
			line-height: <?php echo $aFont['h5']['line_height']; ?>px;
		}	
		h6 {
			font-size: <?php echo $aFont['h6']['size']; ?>px;
			line-height: <?php echo $aFont['h6']['line_height']; ?>px;
		}
		#Intro .intro-title { 
			font-size: <?php echo $aFont['intro']['size']; ?>px;
			line-height: <?php echo $aFont['intro']['line_height']; ?>px;
		}
		
		blockquote { font-size: 14px;}
		
		.chart_box .chart .num { font-size: 40px; line-height: 40px; }
		
		.counter .desc_wrapper .number-wrapper { font-size: 40px; line-height: 40px;}
		.counter .desc_wrapper .title { font-size: 13px; line-height: 16px;}

		.faq .question .title { font-size: 13px; }

		.fancy_heading .title { font-size: 34px; line-height: 34px; }
		
		.offer .offer_li .desc_wrapper .title h3 { font-size: 28px; line-height: 28px; }
		.offer_thumb_ul li.offer_thumb_li .desc_wrapper .title h3 {  font-size: 28px; line-height: 28px; }
		
		.pricing-box .plan-header h2 { font-size: 24px; line-height: 24px; }
		.pricing-box .plan-header .price > span { font-size: 34px; line-height: 34px; }
		.pricing-box .plan-header .price sup.currency { font-size: 16px; line-height: 16px; }
		.pricing-box .plan-header .price sup.period { font-size: 13px; line-height: 13px;}
		
		.quick_fact .number { font-size: 70px; line-height: 70px;}

		.trailer_box .desc h2 { font-size: 24px; line-height: 24px; }
	}
	
	<?php
		// Mobile (Portrait) ------------------------------ < 479
		$multiplier = 0.6;
		
		$aFont = $aFontInit;
		
		foreach( $aFont as $key => $font ){
			
			$aFont[$key]['size'] = round( $font['size'] * $multiplier );
			if( $aFont[$key]['size'] < $min_size ) $aFont[$key]['size'] = $min_size;
			
			$aFont[$key]['line_height'] = round( $font['line_height'] * $multiplier );
			if( $aFont[$key]['line_height'] < $min_line ) $aFont[$key]['line_height'] = $min_line;
			
		}
	?>
	
	@media only screen and (max-width: 479px){
		body {
			font-size: <?php echo $aFont['content']['size']; ?>px;
			line-height: <?php echo $aFont['content']['line_height']; ?>px;
		}
		big,.big {
			font-size: <?php echo $aFont['big']['size']; ?>px;
			line-height: <?php echo $aFont['big']['line_height']; ?>px;
		}
		#menu > ul > li > a, .action_button {
			font-size: <?php echo $aFont['menu']['size']; ?>px;
		}
		#Subheader .title {
			font-size: <?php echo $aFont['title']['size']; ?>px;
			line-height: <?php echo $aFont['title']['line_height']; ?>px;
		}
		h1, .text-logo #logo { 
			font-size: <?php echo $aFont['h1']['size']; ?>px;
			line-height: <?php echo $aFont['h1']['line_height']; ?>px;
		}	
		h2 { 
			font-size: <?php echo $aFont['h2']['size']; ?>px;
			line-height: <?php echo $aFont['h2']['line_height']; ?>px;
		}	
		h3 {
			font-size: <?php echo $aFont['h3']['size']; ?>px;
			line-height: <?php echo $aFont['h3']['line_height']; ?>px;
		}	
		h4 {
			font-size: <?php echo $aFont['h4']['size']; ?>px;
			line-height: <?php echo $aFont['h4']['line_height']; ?>px;
		}	
		h5 {
			font-size: <?php echo $aFont['h5']['size']; ?>px;
			line-height: <?php echo $aFont['h5']['line_height']; ?>px;
		}	
		h6 {
			font-size: <?php echo $aFont['h6']['size']; ?>px;
			line-height: <?php echo $aFont['h6']['line_height']; ?>px;
		}
		#Intro .intro-title { 
			font-size: <?php echo $aFont['intro']['size']; ?>px;
			line-height: <?php echo $aFont['intro']['line_height']; ?>px;
		}
		
		blockquote { font-size: 13px;}
		
		.chart_box .chart .num { font-size: 35px; line-height: 35px; }
		
		.counter .desc_wrapper .number-wrapper { font-size: 35px; line-height: 35px;}
		.counter .desc_wrapper .title { font-size: 13px; line-height: 26px;}

		.faq .question .title { font-size: 13px; }
		
		.fancy_heading .title { font-size: 30px; line-height: 30px; }
		
		.offer .offer_li .desc_wrapper .title h3 { font-size: 26px; line-height: 26px; }
		.offer_thumb_ul li.offer_thumb_li .desc_wrapper .title h3 {  font-size: 26px; line-height: 26px; }
		
		.pricing-box .plan-header h2 { font-size: 21px; line-height: 21px; }
		.pricing-box .plan-header .price > span { font-size: 32px; line-height: 32px; }
		.pricing-box .plan-header .price sup.currency { font-size: 14px; line-height: 14px; }
		.pricing-box .plan-header .price sup.period { font-size: 13px; line-height: 13px;}
		
		.quick_fact .number { font-size: 60px; line-height: 60px;}

		.trailer_box .desc h2 { font-size: 21px; line-height: 21px; }
	}
	
<?php endif; ?>

	
/* ==============================================================================================================================
/*	Sidebar | Width																								Sidebar | Width
/* ============================================================================================================================ */
	
<?php 
	$sidebarW 	= mfn_opts_get( 'sidebar-width', '23' );
	$contentW 	= 100 - $sidebarW;
	$sidebar2W 	= $sidebarW - 5;
	$content2W 	= 100 - ( $sidebar2W * 2 );
	$sidebar2M 	= $content2W + $sidebar2W;
	$content2M 	= $sidebar2W;
?>

.with_aside .sidebar.columns {
	width: <?php echo $sidebarW; ?>%;
}
.with_aside .sections_group {
	width: <?php echo $contentW; ?>%;
}

.aside_both .sidebar.columns {
	width: <?php echo $sidebar2W; ?>%;
}
.aside_both .sidebar.sidebar-1{ 
	margin-left: -<?php echo $sidebar2M; ?>%;
}
.aside_both .sections_group {
	width: <?php echo $content2W; ?>%;
	margin-left: <?php echo $content2M; ?>%;
}
	
	
/* ==============================================================================================================================
/*	Grid | Width																									Grid | Width
/* ============================================================================================================================ */

<?php if( mfn_opts_get('responsive') ): ?>

	<?php 
		$gridW = mfn_opts_get( 'grid-width', 1240 );
	?>
	
	@media only screen and (min-width:1240px){
		#Wrapper, .with_aside .content_wrapper {
			max-width: <?php echo $gridW; ?>px;
		}
		.section_wrapper, .container {
			max-width: <?php echo $gridW - 20; ?>px;
		}
		.layout-boxed.header-boxed #Top_bar.is-sticky{
			max-width: <?php echo $gridW; ?>px;
		}
	}
	
	<?php 
		if( $box_padding = mfn_opts_get( 'layout-boxed-padding' ) ):
	?>
	
		@media only screen and (min-width:768px){
		
			.layout-boxed #Subheader .container,
			.layout-boxed:not(.with_aside) .section:not(.full-width),
			.layout-boxed.with_aside .content_wrapper,
			.layout-boxed #Footer .container { padding-left: <?php echo $box_padding; ?>; padding-right: <?php echo $box_padding; ?>;}
			
			.layout-boxed.header-modern #Action_bar .container,
			.layout-boxed.header-modern #Top_bar:not(.is-sticky) .container { padding-left: <?php echo $box_padding; ?>; padding-right: <?php echo $box_padding; ?>;}
		}
	
	<?php endif; ?>
	
	<?php 
		$mobileGridW = mfn_opts_get( 'mobile-grid-width', 700 );
	?>
	
	@media only screen and (max-width: 767px){
		.section_wrapper,
		.container,
		.four.columns .widget-area { max-width: <?php echo $mobileGridW; ?>px !important; }
	}

<?php endif; ?>


/* ==============================================================================================================================
/*	Other																													Other
/* ============================================================================================================================ */

/* Logo Height */

<?php
	$aLogo = array(
		'height' => intval( mfn_opts_get( 'logo-height', 60 ) ),
		'vertical_padding' => intval( mfn_opts_get( 'logo-vertical-padding', 15 ) ),
	);

	$aLogo['top_bar_right_H'] = $aLogo['height'] + ( $aLogo['vertical_padding'] * 2 );
	$aLogo['top_bar_right_T'] = ( $aLogo['top_bar_right_H'] / 2 ) - 20;
	
	$aLogo['menu_padding'] = ( $aLogo['top_bar_right_H'] / 2 ) - 30;
	$aLogo['menu_margin'] = ( $aLogo['top_bar_right_H'] / 2 ) - 25;
	$aLogo['responsive_menu_T'] = ( $aLogo['height'] / 2 ) + 10; /* mobile logo | margin: 10px */
	
	$aLogo['header_fixed_LH'] = ( $aLogo['top_bar_right_H'] - 30 ) / 2 ;
?>

#Top_bar #logo,
.header-fixed #Top_bar #logo,
.header-plain #Top_bar #logo,
.header-transparent #Top_bar #logo {
	height: <?php echo $aLogo['height']; ?>px;
	line-height: <?php echo $aLogo['height']; ?>px;
	padding: <?php echo $aLogo['vertical_padding']; ?>px 0;
}
.logo-overflow #Top_bar:not(.is-sticky) .logo {
    height: <?php echo $aLogo['top_bar_right_H']; ?>px;
}
#Top_bar .menu > li > a {
    padding: <?php echo $aLogo['menu_padding']; ?>px 0;
}
.menu-highlight:not(.header-creative) #Top_bar .menu > li > a {
	margin: <?php echo $aLogo['menu_margin']; ?>px 0;
}
.header-plain:not(.menu-highlight) #Top_bar .menu > li > a span:not(.description) {
    line-height: <?php echo $aLogo['top_bar_right_H']; ?>px;
}
.header-fixed #Top_bar .menu > li > a {
    padding: <?php echo $aLogo['header_fixed_LH']; ?>px 0;
}

#Top_bar .top_bar_right,
.header-plain #Top_bar .top_bar_right {
	height: <?php echo $aLogo['top_bar_right_H']; ?>px;
}
#Top_bar .top_bar_right_wrapper { 
	top: <?php echo $aLogo['top_bar_right_T']; ?>px;
}
.header-plain #Top_bar a#header_cart, 
.header-plain #Top_bar a#search_button,
.header-plain #Top_bar .wpml-languages,
.header-plain #Top_bar a.button.action_button {
	line-height: <?php echo $aLogo['top_bar_right_H']; ?>px;
}
.header-plain #Top_bar .wpml-languages,
.header-plain #Top_bar a.button.action_button {
	height: <?php echo $aLogo['top_bar_right_H']; ?>px;
}

<?php if( ! $aLogo['vertical_padding'] ): ?>
.logo-overflow #Top_bar.is-sticky #logo{padding:0!important;}
<?php endif; ?>

@media only screen and (max-width: 767px){
	#Top_bar a.responsive-menu-toggle { 
		top: <?php echo $aLogo['responsive_menu_T']; ?>px;
	}
	<?php if( $aLogo['vertical_padding'] ): ?>
	
	.mobile-header-mini #Top_bar #logo{
		height:50px!important;
		line-height:50px!important;
		margin:5px 0!important;
	}
	.mobile-sticky #Top_bar.is-sticky #logo{
		height:50px!important;
		line-height:50px!important;
		margin:5px 50px;
	}
	<?php endif; ?>
}


/* Before After Item */

<?php 
	$translate['before'] 	= mfn_opts_get('translate') ? mfn_opts_get('translate-before','Before') : __('Before','betheme');
	$translate['after'] 	= mfn_opts_get('translate') ? mfn_opts_get('translate-after','After') : __('After','betheme');
?>

.twentytwenty-before-label::before { content: "<?php echo $translate['before']; ?>";}
.twentytwenty-after-label::before { content: "<?php echo $translate['after']; ?>";}


/* Other */

/* Blog teaser | Android phones 1pt line fix - do NOT move it somewhere else */
.blog-teaser li .desc-wrapper .desc{background-position-y:-1px;}
