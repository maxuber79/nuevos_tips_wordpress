# Snippet para Wordpress y construcción de un theme desde 0
 

Este repositorio tiene como proposito mostrar snippet [WordPress CODEX](http://developer.wordpress.org) para la construción de un plantilla de Wordpress. Si tienes nociones de construcción de plantilla de Wordpress desde cero, podrás implementar estos ejemplos y personalizarlos a tu gusto.



### Loop básico

Este es un loop básico para implementar en un theme de Wordpress.

**Ejemplo:**
```php
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	<!-- AQUÍ VA EL CONTENIDO QUE SE LLAMA A LA BD -->
  
<?php endwhile; ?>
<?php endif; ?>
```
**[⬆ vuelve hasta arriba](#contenido)**

### Loop medio
Este loop medio tiene como parametros adicionales para llamar al content o exerpt.

**Ejemplo:**
```php
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php the_content(); ?>
		</article>

<?php endwhile; ?>
<?php endif; ?>
```

### Loop Avanzado
Este loop avanzado tiene como parametros adicionales para llamar al content o exerpt y adicionalmente mostrar errores si es que no existe el contenido y el thumbnail si es que hay.

[!NOTE]
> Este loop es ideal para utilizarlo en un category.php / page.php / single.php.

**Ejemplo:**
```php
	<?php if(have_posts()) : while(have_posts()) : the_post(); ?>

		<a class="---" id="---" href="#" title="ir a <?php the_title_attribute(); ?>" alt="ir a <?php the_title_attribute(); ?>">
			<?php if ( has_post_thumbnail() ) { the_post_thumbnail('name-thumb'); }       
			else { ?>
				<img class="---" id="---" src="<?php echo get_template_directory_uri(); ?>/images/thumbnail-default" alt="<?php the_title(); ?>" title="<?php the_title_attribute(); ?>"> 
			<?php } ?>
		</a> 
		<h2><?php the_title(); ?></h2>
		<span class="byline">Publicado el <?php the_time('d F Y'); ?> | en <?php the_category(', '); ?> | por  <?php the_author(); ?></span>
			<div class="entry">
				<?php the_content(); ?>
			</div>
	<?php endwhile; else: ?> 
		<div class="msj-error">   
			<h2>404</h2>
			<h3>Algo salió mal</h3>
			<p>Oops! Lo sentimos este contenido ya no exite</p>
			<a href="#" class="---" title="---" alt="---">Regresa al inicio</a>
		</div> 
	<?php endif; ?>

```