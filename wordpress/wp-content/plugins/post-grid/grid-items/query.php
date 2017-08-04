<?php
/*
* @Author 		pickplugins
* Copyright: 	2015 pickplugins.com
*/

if ( ! defined('ABSPATH')) exit;  // if direct access


if(isset($_GET['keyword'])){
	
	$keyword = sanitize_text_field($_GET['keyword']);
	
	}

/* ################################ tax_query ######################################*/

foreach($categories as $category){
	
	$tax_cat = explode(',',$category);
	
	$tax_terms[$tax_cat[0]][] = $tax_cat[1];
	
	}

if(empty($tax_terms)){
	
	$tax_terms = array(); 
	}


foreach($tax_terms as $taxonomy=>$terms){
	
		$tax_query[] = array(
							'taxonomy' => $taxonomy,
							'field'    => 'term_id',
							'terms'    => $terms,
							'operator'    => $terms_relation,
							);
		
		
	}

if(empty($tax_query)){
	
	$tax_query = array();
	
	}

$tax_query_relation = array( 'relation' => $categories_relation );

$tax_query = array_merge($tax_query_relation, $tax_query );

//echo '<pre>'.var_export($tax_query,true).'</pre>';

/* ################################ tax_query ######################################*/




if(is_search()){
	
	$keyword = get_search_query();
	

	
	}



	$default_query = array (
			'post_type' => $post_types,
			'post_status' => $post_status,
			's' => $keyword,
			'post__not_in' => $exclude_post_id,
			'order' => $query_order,	
			'orderby' => $query_orderby,
			'meta_key' => $query_orderby_meta_key,
			'tax_query' => $tax_query,
			'posts_per_page' => (int)$posts_per_page,
			'paged' => (int)$paged,
			'offset' => $offset,


			);
			


	$query_merge = apply_filters('post_grid_filter_query_args', $default_query);	
	
	//echo '<pre>'.var_export($query_merge,true).'</pre>';

	$wp_query = new WP_Query($query_merge);


	
	
	
	
	
	
	
	
	
	
	