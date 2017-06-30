<?php
/**
 * Widget Product 1
**/
 
add_action('widgets_init', 'register_product_widget2');
 
function register_product_widget2(){
    register_widget('accesspress_store_product2');
}

if( !class_exists( 'accesspress_store_product2' ) ) :
class accesspress_store_product2 extends WP_Widget {
    /**
     * Register Widget with Wordpress
    **/
    public function __construct() {
        parent::__construct(
            'accesspress_store_product2', 'AP: WooCommerce Product Category Banner', array(
            'description' => __('This widgets show the Category Image its Description and Product of that Category', 'accesspress-store')
        ));
    }

    /**
     * Helper function that holds widget fields
     * Array is used in update and form functions
     */
    private function widget_fields() {
        
          $prod_type = array(
            'right_align' => __('Right Align With Category Image', 'accesspress-store'),
            'left_align' => __('Left Align With Category Image', 'accesspress-store'),
          );
          $taxonomy     = 'product_cat';
          $empty        = 1;
          $orderby      = 'name';  
          $show_count   = 0;      // 1 for yes, 0 for no
          $pad_counts   = 0;      // 1 for yes, 0 for no
          $hierarchical = 1;      // 1 for yes, 0 for no  
          $title        = '';  
          $empty        = 0;
            $args = array(
              'taxonomy'     => $taxonomy,
              'orderby'      => $orderby,
              'show_count'   => $show_count,
              'pad_counts'   => $pad_counts,
              'hierarchical' => $hierarchical,
              'title_li'     => $title,
              'hide_empty'   => $empty  
            );

      $woocommerce_categories = array();
      $woocommerce_categories_obj = get_categories($args);
        $woocommerce_categories[''] = 'Select Product Category:';
      foreach ($woocommerce_categories_obj as $category) {
        $woocommerce_categories[$category->term_id] = $category->name;
      }
        
        $fields = array(
            
              'product_type' => array(
                  'accesspress_store_widgets_name' => 'product_alignment',
                  'accesspress_store_widgets_title' => __('Select the Display Style (Image Alignment)', 'accesspress-store'),
                  'accesspress_store_widgets_field_type' => 'select',
                  'accesspress_store_widgets_field_options' => $prod_type                
              ),

              'product_category' => array(
                  'accesspress_store_widgets_name' => 'product_category',
                  'accesspress_store_widgets_title' => __('Select Product Category', 'accesspress-store'),
                  'accesspress_store_widgets_field_type' => 'select',
                  'accesspress_store_widgets_field_options' => $woocommerce_categories                
              ),            
                    
          );

          return $fields;
    }
    
    public function widget($args, $instance){
        extract($args);
        $product_alignment       =   $instance['product_alignment'];
        $product_category   =   $instance['product_category'];
        $product_args =  array(
                      'post_type' => 'product',
                      'tax_query' => array(
                              array(
                                 'taxonomy'  => 'product_cat',
                                 'field'     => 'term_id', 
                                 'terms'     => $product_category                                                                 
                              )),
                      'posts_per_page' => '6'
        );
    
        ?>
        <section class="category_product">
            <div class="ak-container">
                <?php
                echo $before_widget;
                ?>
                <div class="feature-cat-product-wrap">
                      <div class="feature-cat-image <?php echo $product_alignment;?>">
                          <?php 
                              $thumbnail_id = get_woocommerce_term_meta($product_category, 'thumbnail_id', true);
                              if (!empty($thumbnail_id)) {
                                  $image = wp_get_attachment_image_src($thumbnail_id, 'accesspress-prod-cat-size');
                                  echo '<img src="' . esc_url($image[0]) . '" />';
                              }
                          ?>
                          <div class="product-cat-desc">
                              <?php                             
                                $taxonomy = 'product_cat';
                                $terms = term_description( $product_category, $taxonomy );
                                $terms_name = get_term( $product_category, $taxonomy );
                              ?>
                              <h3><?php echo $terms_name->name ?></h3>
                              <div class="cat_desc">  
                                <?php echo $terms; ?>   
                              </div>  
                          </div>
                    </div>
                    <div class="feature-cat-product <?php echo $product_alignment;?>">
                        <?php 
                            $prod_args = array(
                                                'post_type' => 'product',
                                                'tax_query' => array(array('taxonomy'  => 'product_cat',
                                                                   'field'     => 'term_id', 
                                                                   'terms'     => $product_category                                                                 
                                                                )),
                                                'posts_per_page' => '6'
                                                );
                            $product_query = new WP_Query($prod_args);
                            if($product_query->have_posts()):
                              $count = 1;
                                while($product_query->have_posts()):$product_query->the_post();
                                      $image_id = get_post_thumbnail_id();
                                      $image = wp_get_attachment_image_src($image_id, 'thumbnail', 'true');
                                    ?>
                                    <div class="feature-prod-wrap wow flipInY" data-wow-delay="<?php echo $count ?>s">
                                        <?php wc_get_template_part( 'content', 'feat-product' ); ?>
                                    </div>
                                    <?php
                                    $count+=0.5;
                                endwhile;
                            endif;
                        ?>
                    </div>                    
                    
                </div>
                
                <?php
                echo $after_widget;
                ?>
            </div>
        </section>
        <?php
    }
    
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @uses  accesspress_store_widgets_updated_field_value()   defined in widget-fields.php
     *
     * @return  array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            extract($widget_field);

            // Use helper function to get updated field values
            $instance[$accesspress_store_widgets_name] = accesspress_store_widgets_updated_field_value($widget_field, $new_instance[$accesspress_store_widgets_name]);
        }

        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     *
     * @uses  accesspress_store_widgets_show_widget_field()   defined in widget-fields.php
     */
    public function form($instance) {
        $widget_fields = $this->widget_fields();

        // Loop through fields
        foreach ($widget_fields as $widget_field) {

            // Make array elements available as variables
            extract($widget_field);
            $accesspress_store_widgets_field_value = !empty($instance[$accesspress_store_widgets_name]) ? esc_attr($instance[$accesspress_store_widgets_name]) : '';
            accesspress_store_widgets_show_widget_field($this, $widget_field, $accesspress_store_widgets_field_value);
        }
    }
}
endif;