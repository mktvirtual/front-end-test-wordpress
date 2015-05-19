			<?php get_header(); ?>
			
			<div id='cssmenu'>
				<ul>
				<li class='active'><a href='index.php'><span>LOREM</span></a></li>	
				<?php wp_list_pages('title_li='); ?>					
				</ul>
			</div>
			
		
			
			<div id="quadro">
				<div id="qimg1"><img src="<?php bloginfo('template_url'); ?>/images/fp1.jpg"></img></div>
				<div id="qimg2"><img src="<?php bloginfo('template_url'); ?>/images/fp2.jpg"></img></div>
				<div id="qimg3"><img src="<?php bloginfo('template_url'); ?>/images/fp3.jpg"></img></div>
				<div id="qimg4"><img src="<?php bloginfo('template_url'); ?>/images/fp4.jpg"></img></div>			
			</div>
			
			<div id="ultimas" class="fleft"><p><font id="title">Ultimas</font></p>  <!-- DIV PARA CATEGORIA ULTIMAS -->
			
			<!-- CADA POST NOVO ENTRA NO LUGAR DO ÚLTIMO E EMPURRA O POST ANTIGO PRA DIREITA DINAMICAMENTE -->
			
				<div id="uleft" class="fleft">  <!-- DIV CONTAINER DAS 2 NEWS DA ESQUERDA -->

					<div id="ul1" class="fleft"> <!-- primeiro da esquerda -->	
						
					<?php query_posts('category_name=ultimas&offset=0&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="u1" class="imgl">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="u1news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>					
					
					
					<div id="ul2" class="fright">	<!-- segundo da esquerda -->
						
					<?php query_posts('category_name=ultimas&offset=1&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="u2" class="imgr">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="u1news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>
					
					
					
				</div>
				
				
				<div id="uright" class="fright"> <!-- DIV CONTAINER DOS 2 DA DIREITA -->
				
				
				<!-- CADA POST NOVO ENTRA NO LUGAR DO ÚLTIMO E EMPURRA O POST ANTIGO PRA DIREITA DINAMICAMENTE -->
				
					<div id="ul1" class="fleft"> <!-- primeiro da direita -->	
						
					<?php query_posts('category_name=ultimas&offset=2&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="u1" class="imgl">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="u1news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>					
					
					
					<div id="ul2" class="fright">	<!-- segundo da direita -->
						
					<?php query_posts('category_name=ultimas&offset=3&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="u2" class="imgr">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="u1news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>
					
				</div>				
			
			</div>
			
			
			
			<div id="loren" class="fleft"><p><font id="title">Loren</font></p>
			
				<!-- CADA POST NOVO ENTRA NO LUGAR DO ÚLTIMO E EMPURRA O POST ANTIGO PRA DIREITA DINAMICAMENTE -->
			
				<div id="lleft" class="fleft">  <!-- DIV CONTAINER DAS 2 NEWS DA ESQUERDA -->

					<div id="lo1" class="fleft"> <!-- primeiro da esquerda -->	
						
					<?php query_posts('category_name=loren&offset=0&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="l1" class="imgl">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="l1news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>					
					
					
					<div id="lo2" class="fright">	<!-- segundo da esquerda -->
						
					<?php query_posts('category_name=loren&offset=1&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="l2" class="imgr">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="l2news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>
					
					
					
				</div>
				
				
				<div id="lright" class="fright"> <!-- DIV CONTAINER DOS 2 DA DIREITA -->
				
				
				<!-- CADA POST NOVO ENTRA NO LUGAR DO ÚLTIMO E EMPURRA O POST ANTIGO PRA DIREITA DINAMICAMENTE -->
				
					<div id="lo3" class="fleft"> <!-- primeiro da direita -->	
						
					<?php query_posts('category_name=loren&offset=2&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="l3" class="imgl">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="l3news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>					
					
					
					<div id="lo4" class="fright">	<!-- segundo da direita -->
						
					<?php query_posts('category_name=loren&offset=3&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="l4" class="imgr">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="l4news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>
					
				</div>				
			
			</div>
			
			
			
			<div id="ipsun" class="fleft"><p><font id="title">Ipsun</font></p>
			
				<!-- CADA POST NOVO ENTRA NO LUGAR DO ÚLTIMO E EMPURRA O POST ANTIGO PRA DIREITA DINAMICAMENTE -->
			
				<div id="ileft" class="fleft">  <!-- DIV CONTAINER DAS 2 NEWS DA ESQUERDA -->

					<div id="ip1" class="fleft"> <!-- primeiro da esquerda -->	
						
					<?php query_posts('category_name=ipsum&offset=0&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="i1" class="imgl">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="i1news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>					
					
					
					<div id="ip2" class="fright">	<!-- segundo da esquerda -->
						
					<?php query_posts('category_name=ipsum&offset=1&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="i2" class="imgr">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="i2news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>
					
					
					
				</div>
				
				
				<div id="iright" class="fright"> <!-- DIV CONTAINER DOS 2 DA DIREITA -->
				
				
				<!-- CADA POST NOVO ENTRA NO LUGAR DO ÚLTIMO E EMPURRA O POST ANTIGO PRA DIREITA DINAMICAMENTE -->
				
					<div id="ip3" class="fleft"> <!-- primeiro da direita -->	
						
					<?php query_posts('category_name=ipsum&offset=2&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="i3" class="imgl">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="i3news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>					
					
					
					<div id="ip4" class="fright">	<!-- segundo da direita -->
						
					<?php query_posts('category_name=ipsum&offset=3&showposts=1'); ?>
					<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
					<div id="i4" class="imgr">
						<a href="<?php the_Permalink(); ?>"><?php the_post_thumbnail(); ?></a>
					</div><br>				
					<div id="i4news" class="newsl">
						<a href="<?php the_Permalink(); ?>"><font id="news"><?php the_title(); ?></font></a>
					</div>					
					<?php endwhile; else: ?>
					<?php endif; ?>
					
					</div>
					
				</div>				
			
			</div>
			
			
			<?php get_footer(); ?>
			
			
			
		</div>
		
		<?php wp_footer(); ?>
	</body>

</html>