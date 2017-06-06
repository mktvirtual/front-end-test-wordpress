<?php 

  $num_posts = ( is_front_page() ) ? 3 : 2;

//Protect against arbitrary paged values
//$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

if(isset($_GET['pg']))
{
$paged = $_GET['pg'];
}
else
{
   $paged = 1;	
	
	}



  $args = array(
    'post_type' => 'portfolio',
    'posts_per_page' => $num_posts,
	'paged' => $paged,
  );
  $query = new WP_Query( $args );

?>
<!-- the loop etc.. -->


<section class="row no-max pad">
  
  <?php if( $query->have_posts() ) : while( $query->have_posts() ) : $query->the_post(); ?>

  <div class="small-6 medium-4 large-3 columns grid-item">
    <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large'); ?></a>
  </div>

  <?php endwhile; endif; wp_reset_postdata(); ?>


<?php

$total = $query->max_num_pages;
?>
<table>
<tr>

<?php
for($i=1;$i<=$total;$i++)
{
	
 ?>
 <td>
   <?php
   if($i != $paged)
   {
   ?>
   <a href="http://177.11.54.160/~athospublicidade/wordpress/?pagename=portfolio&pg=<?php echo $i; ?>">
     <?php echo $i; ?>
   </a>
   <?php
   }
   else
   {
      echo $i;
   }
   ?>
 </td>  
 <?php  	
	}

?>

</tr>
</table>

</section>
