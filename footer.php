	<footer class="footer">
		<div class="row">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
			<div class="footer__brand">
				<span>sac loja logo</span>
				<span><?php the_field('sac-tel', 5); ?></span>				
				<a href="<?php the_field('2boleto', 5); ?>" class="footer__segunda-via">solicitar 2ª via do boleto</a>
			</div>  
		</div>
		<div class="row">
			<div class="footer__copyright">
				<p><?php echo date("Y") ?>, Lojas Logo. Todos os direitos reservados.</p>
				<a href="http://www.mktvirtual.com.br/" class="mkt-virtual" title="MKT Virtual"></a>
			</div>
		</div>
	</footer>
</main>
<?php wp_footer(); ?>
</body>
</html>