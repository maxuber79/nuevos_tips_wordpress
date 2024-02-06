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


### Loop Avanzado para categorias y paginación
Este loop avanzado tiene como parametros adicionales para llamar al content o exerpt y adicionalmente mostrar errores si es que no existe el contenido y el thumbnail si es que hay.

[!NOTE]
> Este loop es ideal para utilizarlo en un category.php para mosotrar todos los post totales.

**Ejemplo:**
```php

<?php if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } else { $paged = 1; }
	$custom_query_args = array(
			//'post_type' => 'post', //--> array( 'post', 'page', 'movie', 'book' )
			//'post_type' => 'post', 
			//'category__not_in' => array( 1,2,3),
			'category_name' => 'blog',
			'posts_per_page' => 5,  //-->
			'paged' => $paged, //-->
			'post_status' => 'publish', //-->
			'ignore_sticky_posts' => true, //-->
			'order' => 'ASC', //--> 'DESC' | 'ASC'
			//'orderby' => 'date' //--> modified | title | name | ID | rand
	);
	$custom_query = new WP_Query( $custom_query_args );
	if ( $custom_query->have_posts() ) : while( $custom_query->have_posts() ) : $custom_query->the_post(); ?>

	<!--@START: Entry post -->	
	/* title */
	<?php the_title(sprintf( '<h2 class="title"><a class="blog-title" href="%s" rel="bookmark">', esc_attr( esc_url( get_permalink() ) ) ), '</a></h2>');?>
	/* thumbnail */
	<?php if( !empty(get_the_post_thumbnail())) :?>
		<?php the_post_thumbnail('thumb_category', array( 'class' => 'thumbnail-card-elev' ));?>
	<?php else:?>
		<img class="thumbnail-card-elev" src="https://fakeimg.pl/600x600/fd4a6b/ffffff?text=Elev.cl&font=bebas" alt="<?php the_title_attribute(); ?>" title="ir a: <?php the_title(); ?>"/>
	<?php endif; ?>
	/* byline */
	<div class="byline"> 
		<?php echo strtolower(get_the_date('j F,Y')); ?>
		<?php echo strtolower(the_category(', ')); ?>
	</div>												 
	<?php endwhile; wp_reset_postdata(); ?>
	<!--@END: entry post -->
								
	<!--@START: message article does not exist -->
	<?php else : ?>								 
		<div class="alert alert-warning alert-dismissible " role="alert">
			<strong>Oops!</strong>  Lo sentimos este contenido ya no exite
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	<?php endif; ?>
	<!--@END: message article does not exist -->

	<!--@START:Pagination-->
	<div class="row">
		<div class="col-12">
			<div id="wrapper-pagination" class="light text-center py-2 mt-3">
				<?php get_template_part('inc/custom', 'pagination'); ?>							 
			</div>
		</div> 
	</div> 
	<!--@END:End pagination-->

```