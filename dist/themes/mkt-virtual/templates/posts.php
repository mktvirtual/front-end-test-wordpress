<?php
/**
 * @link       https://github.com/paulovitorwd/front-end-test-wordpress
 * @package    WordPress
 * @subpackage MKT_Virtual
 * @since      MKT Virtual 1.0.0
 */
 ?>


<?php

$tags = '';
$posttags = get_the_tags();

if ($posttags) {
	foreach($posttags as $tag) {
		$tags .= $tag->name . ' ';
	}

	foreach($posttags as $tag) {
		if($tag->name === 'featured') {

?>

<div class="preview">

	<?php the_post_thumbnail(); ?>

	<div class="info <?php echo $tags; ?>">
		<div class="itens">
			<div class="category">

				<?php

				foreach((get_the_category()) as $category) {
					if($category->cat_name !== 'Promoções') {
					    echo $category->cat_name;
					}
				}

				?>

			</div>
			<h3><?php the_title(); ?></h3>
			<p><?php the_excerpt(); ?></p>

			<?php

			foreach((get_the_category()) as $category) {
				if($category->cat_name !== 'Promoções') {
				    echo '<a href="<?php the_permalink(); ?>">Saiba mais</a>';
				}
				else {
					echo '<a href="<?php the_permalink(); ?>">Continue Lendo</a>';
				}
			}

			?>

		</div>
	</div>
</div>

<?php

		}

	}
}

?>