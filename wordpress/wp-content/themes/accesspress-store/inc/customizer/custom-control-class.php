<?php
/**
 * Custom Control Class
*/

if( class_exists( 'WP_Customize_control') ){
    
    class AccessPress_Store_WP_Customize_Switch_Control extends WP_Customize_Control {
		public $type = 'switch';
        
		public function render_content() {
		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		        <div class="switch_options">
                  <span class="switch_enable"> <?php _e('Enable', 'accesspress-store'); ?> </span>
                  <span class="switch_disable"> <?php _e('Disable', 'accesspress-store'); ?> </span>  
                  <input type="hidden" id="enable_prev_next" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" />							
                </div>
            </label>
		<?php
       
		}
	}
    
    class AccessPress_Store_WP_Customize_Switch_Control_YesNo extends WP_Customize_Control {
		public $type = 'switch_yesno';        
		public function render_content() {
		?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		        <div class="switch_options">
                  <span class="switch_enable"> <?php _e('Yes', 'accesspress-store'); ?> </span>
                  <span class="switch_disable"> <?php _e('No', 'accesspress-store'); ?> </span>  
                  <input type="hidden" id="enable_prev_next_yn" <?php $this->link(); ?> value="<?php echo $this->value(); ?>" />
                </div>
            </label>
		<?php
       
		}
	}

	class AccessPress_Store_WP_Customize_Radioimage_Control extends WP_Customize_Control {
		public $type = 'radioimage';
		public function enqueue() {
			wp_enqueue_script( 'jquery-ui-button' );
		}
	    public function render_content() {
			$name = '_customize-radio-' . $this->id;
			?>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<div id="input_<?php echo $this->id; ?>" class="image">
				<?php foreach ( $this->choices as $value => $label ) : ?>
					<input class="image-select" type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo $this->id . $value; ?>" <?php $this->link(); checked( $this->value(), $value ); ?>>
						<label for="<?php echo $this->id . $value; ?>">
							<img src="<?php echo esc_html( $label ); ?>"/>
						</label>
					</input>
				<?php endforeach; ?>
			</div>
			<script>jQuery(document).ready(function($) { $( '[id="input_<?php echo $this->id; ?>"]' ).buttonset(); });</script>
			<?php 
		}
	}

	class AccessPress_Store_WP_Category_Checkboxes_Control extends WP_Customize_Control {

	    public $type = 'category-checkboxes';

	    public function render_content() {
	        echo '<script src="' . get_template_directory_uri() . '/js/theme-customizer.js"></script>';
	        echo '<span class="customize-control-title">' . esc_html($this->label) . '</span>';
	        foreach (get_categories() as $category) {
	            echo '<label><input type="checkbox" name="category-' . $category->term_id . '" id="category-' . $category->term_id . '" class="cstmzr-category-checkbox"> ' . $category->cat_name . '</label><br>';
	        }
	        ?>
	        <input type="hidden" id="<?php echo $this->id; ?>" class="cstmzr-hidden-categories" <?php $this->link(); ?> value="<?php echo sanitize_text_field($this->value()); ?>">
	        <?php
	    }
	}

	/**
	 * AccessPress Store Pro Features
	*/
	class AccessPress_Store_Theme_Info_Product_Custom_Control extends WP_Customize_Control{
	    public function render_content(){ ?>
	        <label>
	            <span class="customize-text_editor_desc button">
	                <?php echo wp_kses_post( $this->description ); ?>
	            </span>
	        </label>
	        <?php
	    }
	}

	if(!class_exists( 'AccessPress_Store_Theme_Info_Custom_Control' )){
		class AccessPress_Store_Theme_Info_Custom_Control extends WP_Customize_Control{
		    public function render_content(){ ?>
		        <label>
		        	<div class="user_sticky_note">
		    	        <span class="sticky_info_row"><a class="button" href="http://demo.accesspressthemes.com/accesspress-store/" target="_blank">Live Demo</a>
		    	        <span class="sticky_info_row"><a class="button" href="http://doc.accesspressthemes.com/accespress-store-doc/" target="_blank">Documentation</a></span>
		    	        <span class="sticky_info_row"><a class="button" href="https://accesspressthemes.com/support/forum/themes/free-themes/theme-accesspress-store/" target="_blank">Support Forum</a></span>
		    	        <span class="sticky_info_row"><a class="button" href="https://www.youtube.com/watch?v=Czj2XF6tuU0&list=PLdSqn2S_qFxG-DoVjc-Dp2Z-FpNg7BHwa" target="_blank">Video Tutorial</a></span>
		    	        <span class="sticky_info_row"><a class="button" href="http://wpall.club/" target="_blank">More WordPress Resources<a/></span>
	    	        </div>
		            <h2 class="customize-title"><?php echo esc_html( $this->label ); ?></h2>
		            <span class="customize-text_editor_desc">                  
		                <img src="<?php echo get_template_directory_uri() ?>/inc/images/feature-list-pro.jpg"/>
		                <ul class="admin-pro-feature-list">   
		                    <li><span><?php _e('Fully built on customizer!','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Next generation WooCommerce theme','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Deep WooCommerce Integration!','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Mega menu','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Advanced product search','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Boxed and full layout','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Unlimited slider options','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Background configuration','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Color configuration','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Highly configurable home page','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Youtube video integration','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Multiple Category display layout','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Product and content search','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Promo Ticker','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Unlimited SSL Badge and credit card icons upload','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('WooCommerce settings','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('4 WooCommerce Archive layout','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('4 Page layout','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('4 Post layout','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Grid / list Archive view','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('4 Blog layout','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('14 Widgets','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Page banner','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Beautiful product page','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Beautiful checkout pages','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Widget for latest product with accordance','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Tab section to show category','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Tab section to show products','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Team section','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Testimonial section','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Client Logo Section','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Fully SEO optimized','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('Fast loading','accesspress-store'); ?> </span></li>
		                    <li><span><?php _e('A perfect theme to start your online shop of any kind!','accesspress-store'); ?> </span></li>
		                </ul>
		                <?php $buy_now = 'https://accesspressthemes.com/wordpress-themes/accesspress-store-pro'; ?>
		                <a href="<?php echo esc_url( $buy_now ); ?>" class="button button-primary buynow" target="_blank"><?php _e('Buy Now','accesspress-store'); ?></a>
		            </span>
		        </label>
		        <?php
		    }
		}
	}
}