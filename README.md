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
Este loop avanzado tiene como parametros adicionales para llamar al content o exerpt y adicionalmente mostrar errores si es que no existe el contenido y el thumbnail si es que hay muestra una imagen defafult.
La paginación esta porporsionada por bootstrap el cual es una dependencia que se debe incluir en la plantilla en function.php.
Para la libreria de paginación se puede descargar desde el siguiente [link de referencia](https://gist.github.com/mtx-z/af85d3abd4c19a84a9713e69956e1507).

[!NOTE]
> Este loop es ideal para utilizarlo en un category.php para mosotrar todos los post totales.

**Ejemplo:**
```php

<?php if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } else { $paged = 1; }
	$custom_query_args = array(
			//'post_type' => 'post', //--> array( 'post', 'page', 'movie', 'book' )
			//'post_type' => 'post', 
			//'category__not_in' => array( 1,2,3),
			'category_name' => 'name_category',
			'posts_per_page' => 5,  //-->
			'paged' => $paged, //-->
			'post_status' => 'publish', //-->
			'ignore_sticky_posts' => true, //-->
			'order' => 'ASC', //--> 'DESC' | 'ASC'
			'orderby' => 'date' //--> modified | title | name | ID | rand
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

### Loop reducido para mostrar categorias 
Este loop reducido es hecho con [WP_Query](https://developer.wordpress.org/reference/classes/wp_query/) tiene como parametros adicionales para llamar al content o exerpt y el thumbnail si es que existe, para esto implemento un disño segun [bootstrap media object](https://getbootstrap.com/docs/5.3/utilities/flex/#media-object).

[!NOTE]
> Este loop es ideal para utilizarlo en un category.php o widget para mosotrar todos los post totales.

**Ejemplo:**
```php
<div class="mi-class">
	<ul>
		<?php $my_query = new WP_Query('category_name=my-category&posts_per_page=number-post');
				while ( $my_query -> have_posts() ) : $my_query -> the_post(); ?>
				<li><div class="d-flex align-items-center">
					<div class="flex-shrink-0">
						<img src="..." alt="...">
					</div>
					<div class="flex-grow-1 ms-3">
						<?php the_title( '<h2>', '</h2>' ); ?>
						<?php if ( is_category() || is_archive() ) {
								the_excerpt();
							} else {
								the_content();
							} ?>
						<a href="<?php the_permalink(); ?>" title="ir a <?php the_title_attribute(); ?>" class="asidevermas"> Leer m�s</a>
					</div>
				</div></li>   
		<?php endwhile;?>
		<?php wp_reset_postdata(); ?>	              
  </ul>
</div>
```


## Tips varios

### Titulos
Estos tips  tiene como proposito ayudar a mostrar algun contenido desde la BD segun la plantilla que se quiere aplicar, dentro o fuera del loop de wordpress, En algunos ejemplos, se utiliza [bootstrap 5.3](https://getbootstrap.com/docs/5.3/).

**Ejemplo de titulos:**
```php
<!--@Version 1: Entrega el nombre de la categoria -->
<h2><a href="<?php echo get_category_link(ej.3); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_cat_name(3);?></a></h2>

<!--@Version 2: Puede usarse tambien el siguiente -->
<h2><a href="<?php echo get_category_link(ej.3); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
<h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

<!--@Version 3: Puede usarse tambien el siguiente -->

<?php the_title( '<h3>', '</h3>' ); ?>
<?php the_title_attribute('before=<h3>&after=</h3>'); ?>
<?php the_title(sprintf( '<h2 class="title"><a class="blog-title" href="%s" rel="bookmark">', esc_attr( esc_url( get_permalink() ) ) ), '</a></h2>');?>

<!--@Version 4: Puede usarse tambien el siguiente -->
<?php the_title('<h1 class="entry-title"><a href="' . get_permalink() . '"title="' . the_title_attribute('echo=0') . '" rel="bookmark">','</a></h1>'); ?>
```
### Categorias
Estos tips  tiene como proposito ayudar a mostrar algun contenido desde la BD segun la plantilla que se quiere aplicar, dentro o fuera del loop de wordpress, En algunos ejemplos, se utiliza [bootstrap 5.3](https://getbootstrap.com/docs/5.3/).

**Ejemplos:**
```php
<!--@Mostrar categorias:  -->
<p><i class="bi bi-bookmark-fill"></i> <?php the_category( $separator, $parents, $post_id ); ?></p>
<p><i class="bi bi-bookmark-fill"></i> <?php the_category(''); ?></p>

<!--@Mostrar con comas o algun codigo ascii -->
<p><i class="bi bi-bookmark-fill"></i> <?php the_category(', '); ?></p>
<p><i class="bi bi-bookmark-fill"></i> <?php the_category(' &gt; '); ?></p>
<p><i class="bi bi-bookmark-fill"></i> <?php the_category(' &bull; '); ?></p>

<!--@Mostrar tags --> 
<p>Meta information for this post:</p>
<p><i class="bi bi-tag-fill"></i> <?php the_meta(); ?></p>

<!--@Mostrar tags con comas o algun codigo ascii -->
<p><i class="bi bi-tag-fill"></i><?php the_tags( $before, $sep, $after ); ?></p>
<p><i class="bi bi-tag-fill"></i><?php the_tags('Tags: ', ', ', '<br />'); ?></p>
<p><i class="bi bi-tag-fill"></i><?php the_tags('Social tagging: ',' > '); ?></p>
<p><i class="bi bi-tag-fill"></i><?php the_tags('Tagged with: ',' � ','<br />'); ?></p>
<p><i class="bi bi-tag-fill"></i><?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?></p>
```