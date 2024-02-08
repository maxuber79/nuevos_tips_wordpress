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
			<?php if ( get_edit_post_link() ) : ?>
					<div class="wrapp-btn btn-right">													
						<?php edit_post_link( __( 'Editar post', 'Colunga' ), '<p>', '</p>', null, 'btn btn-getstarted colunga-secundary' ); ?>
					</div><!-- .entry-footer -->
					
			<?php endif; ?>
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
### Categorias y tags
Estos tips  tiene como proposito ayudar a mostrar algun contenido desde la BD segun la plantilla que se quiere aplicar, dentro o fuera del loop de wordpress, En algunos ejemplos se utiliza los icons de [bootstrap icons](https://icons.getbootstrap.com/).

**Ejemplos:**
```php
<!--@Mostrar categorias:  -->
<p><i class="bi bi-bookmark-fill"></i> <?php the_category( $separator, $parents, $post_id ); ?></p>
<p><i class="bi bi-bookmark-fill"></i> <?php the_category(''); ?></p>

<!--@Mostrar con comas o algun codigo ascii -->
<p><i class="bi bi-bookmark-fill"></i> <?php the_category(', '); ?></p>
<p><i class="bi bi-bookmark-fill"></i> <?php the_category(' &gt; '); ?></p>
<p><i class="bi bi-bookmark-fill"></i> <?php the_category(' &bull; '); ?></p>

<!--@Mostrar nombre de categoria se objeto -->
<h1>&#151 <?php $category = get_the_category(); echo $category[0]->cat_name; ?> &#151</h1>

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

### Metadatos byline
Estos tips  tiene como proposito ayudar a mostrar algun dato del post, desde la BD segun la plantilla que se quiere aplicar, dentro o fuera del loop de wordpress, En algunos ejemplos, se utiliza [bootstrap 5.3](https://getbootstrap.com/docs/5.3/).

**Ejemplos:**
```php
<!--@información full de byline -->
<div class="byline">
	<ul class="byline-meta">
		<!--@Author post-->
		<li><i class="bi bi-person-fill"></i> By <?php the_author(); ?></li>
		<!--@Date post-->
		<li><i class="bi bi-calendar-event-fill"></i> <?php echo get_the_date('j F , Y') ; ?></li>
		<!--@Category(s) post-->
		<li><i class="bi bi-bookmark-fill"></i> <?php echo the_category(', '); ?></li>
		<!--@Tag(s) post-->
		<li><i class="bi bi-tag-fill"></i> <?php the_tags('Tags: ', ', ', '<br />'); ?></li>
	</ul>
</div>

<!--@Show date in Spanish -->
<?php the_time('d \d\e\ F \d\e\ Y');?>

<!--@Other: ideas-->
<span class="wrapp-date">
<!--@Other: aplicar el print para que los textos se muestren en minusculas -->
	<i class="bi bi-calendar-event-fill"></i> <?php echo strtolower(get_the_date('j F,Y')); ?>
</span>
<!--@Other: aplicar el print para que los textos se muestren en minusculas -->
<span class="wrapp-date">
	<i class="bi bi-bookmark-fill"></i> <?php echo strtolower(the_category(', ')); ?>
</span>

<!--@Other: aplicar en comentarios -->
<span class="comments meta"><?php comments_popup_link('Sin Comentarios', '1 Comentario', '% Comentarios'); ?> | </span>

<div class="metabox">
 <span class="time meta">Publicado el <?php the_time('j') ?> de <?php the_time('F, Y') ?> | </span><span class="author meta">Por <?php the_author_posts_link(); ?> | </span>
 <span class="comments meta"><?php comments_popup_link('Sin Comentarios', '1 Comentario', '% Comentarios'); ?> | </span><span class="category meta">En la categor&iacute;a <?php the_category(' '); ?> | </span>
 <span class="tags meta">Con las siguientes etiquetas <?php the_tags(); ?></span>
 </div>
```

### Thumbnails
Estos tips  tiene como proposito ayudar a mostrar un thumbnail , segun nombre u otra forma que se confgure desde el function.php. En algunos ejemplos se utiliza [bootstrap 5.3](https://getbootstrap.com/docs/5.3/).

**Ejemplos:**
```php
<!--@Calling a thumbnail / use it as background -->
<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'name_thumb-Ej:full' ); ?>
<div class="attachment-thumbnail" style="width: 1024px;height: 1024px;background-image: url('<?php echo $image[0]; ?>')"></div>

<!--@Calling a thumbnail use images -->
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'name_thumb' );?>
<img src="<?php echo $thumb['0'];?>" width="" height="" class="attachment-thumbnail" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"> 

<!--@Calling a thumbnail use images -->
<?php $thumb_id = get_post_thumbnail_id(); $thumb_url = wp_get_attachment_image_src($thumb_id,'Mi THUMBNAIL PERSONALIZADO', true); ?>
<img src="<?php echo $thumb_url[0]; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="---" width="---" height="---">
```

### Clases personalizadas o Id personalizados
Estos tips  tiene como proposito aplicar clases personalizadas en la plantilla. En algunos ejemplos se utiliza [bootstrap 5.3](https://getbootstrap.com/docs/5.3/).

**Ejemplos:**
```php
<!--@Add: class dynamic -->
<?php $classes = array('first-class', 'second-class', 'animate__animated', 'animate__fadeIn', $termsString, $custom_values); ?>
<div <?php post_class($classes);?> data-wow-duration=".6s" data-wow-delay=".5s" data-wow-offset="5"></div>
```

```php
<!--@Add: class dynamic / agrego un ID segun su categoria -->
<?php $category_id = get_cat_ID( 'blog' );$category_link = get_category_link( $category_id );$category_name = get_cat_name($category_id); ?>
<section id="<?php echo strtolower($category_name);?>" <?php post_class('my-class'); ?>></section>
```

```php
<!--@Add: class dynamic / agrego un ID segun su id de una page -->
<?php $page_slug = get_post_field('post_name', get_post()); ?>	
<section id="<?php echo strtolower(esc_attr($page_slug)); ?>" <?php post_class('my-class'); ?>></section>
```


```php
<!--@Add: class dynamic / agrego un ID segun su id de una categoria -->
<?php  $category_id = get_cat_ID( 'name_slug_category' ); $category_link = get_category_link( $category_id );	?>
<a href="<?php echo strtolower(esc_url( $category_link )); ?>"></a>
```

```php
<?php
	// Obtiene el slug de la página actual y llamarla en el theme
	$page_slug = get_post_field('post_name', get_post());
	?>
 <section id="<?php echo esc_attr($page_slug); ?> | <?php echo esc_html( get_the_title() ); ?> | post-<?php  the_ID(); ?> <?php echo get_the_id();?>" <?php post_class('wrapp-header-page'); ?> style="background-image: url(<?php  the_post_thumbnail_url(); ?>);"> 
```

```php
<?php
// Obtiene el ID de la página actual y llamarla en el theme
// The post ID: 192 
echo "<h2>The post ID: ".get_the_ID()."</h2>";
// The Queried Object ID: 134 
echo "<h2>The Queried Object ID: ".get_queried_object_id()."</h2>";
echo "<h2>The Queried Object ID: ".esc_html( get_the_title() )."</h2>";
echo "<h2>The Queried Object ID: ".wp_kses_post( get_the_title() ) ."</h2>";    
echo "<h2>The Queried Object ID: ".the_title_attribute()."</h2>";
?>
<li>category-blogs.php | <?php echo get_cat_name( $category_id = 5 );?></li> 
<li><p>cat test1: <?php $category = get_the_category(); echo $category[0]->cat_name; ?></p></li>						
<li><p>cat test2: <?php $catname = get_cat_name( 5 ); echo $catname;?></p></li> 
<li><p>cat test3: <?php echo get_cat_name( $category_id = 5 )  ?></p></li>
```


### Links personalizados
Estos tips  tiene como proposito aplicar url personalizadas en la plantilla segun su ID category o Id page. En algunos ejemplos se utiliza [bootstrap 5.3](https://getbootstrap.com/docs/5.3/).

```php
<!-- para llamar a una pagina -->
<a href="<?php echo get_page_link( get_page_by_path( 'name_page' ) ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title(); ?>">my link</a>
```
```php
<?php $category_id = get_cat_ID( 'my-category' ); $category_link = get_category_link( $category_id );	?>
<a href="<?php echo esc_url( $category_link ); ?>" class="my-class" title="<?php the_title_attribute(); ?>" alt="<?php the_title(); ?>">my link</a>
```		
```php
<!-- para llamar a una pagina -->
<a href="<?php echo get_page_link( get_page_by_path( 'my-category' ) ); ?>" class="my-class" title="<?php the_title_attribute(); ?>" alt="<?php the_title(); ?>">más información</a>
```	

```php
<a href="<?php the_permalink();?>" <?php post_class('link-details'); ?> title="ir a <?php the_title_attribute(); ?>" alt="<?php the_title(); ?>">my link <i class="fa fa-link"></i></a>
```	
