

<?php 
// COMO VOLVER AL HOME A TRAVES DE UN LINK
//============================================================================================= ?>

<a href='<?php echo home_url(); ?>' class=''>
    <img src='<?php echo get_template_directory_uri(); ?>/---/----.svg' alt="" title="" class="">
</a>


<?php // loop b�sico ------------------------------------------------------------------ ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
  <!-- loop -->
<?php endwhile; ?>
<?php endif; ?>

<?php // loop medio ------------------------------------------------------------------ ?>

<?php if(have_posts()) : ?>
	<?php while(have_posts()) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php the_content(); ?>
		</article>
	<?php endwhile; ?>
<?php endif; ?>

<?php // loop para widget ------------------------------------------------------------------ ?>

<div class="mis-noticias">     
        <ul>
			<?php
			$my_query = new WP_Query('category_name=my-category&posts_per_page=number-post');
				while ( $my_query -> have_posts() ) : $my_query -> the_post();
				?>
			        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>   
			<?php endwhile;?>
			<?php wp_reset_postdata(); ?>	              
        </ul>
</div>


<?php // loop WP_Query ------------------------------------------------------------------ ?>

<?php
$the_query = new WP_Query( $args );
while ( $the_query->have_posts() ) : $the_query->the_post();
// el loop...
endwhile;
// Reseteamos
wp_reset_query();
wp_reset_postdata();

//=========================================================================================
//con paginado:

 // Obtenemos todos los posts con 10 en cada p�gina
    $args = array(
        'post_type'         => 'post',
        'posts_per_page'    => 10,
        'paged'             => get_query_var('paged')
    );
    $nuestra_query = new WP_Query( $args );
    if ( $nuestra_query->have_posts() ) {
        while ( $nuestra_query->have_posts() ) {
            // Mostramos lo que queramos de cada post
        }
    }
    if (function_exists( 'wp_pagenavi' )) {
        wp_pagenavi( array( 'query' => $nuestra_query ) );
    }
    wp_reset_postdata();
	
//=======================================================================================================
	pre_get_posts()
	
	function hmuda_modificar_main_query($query){
    //Primero asegurar que es la consulta principal y que es la home
    if( is_home() && $query->is_main_query() ){
        //Hacer la modificaci�n que sea
        $query->set( 'posts_per_page', '4' );
        $query->set( 'cat', '-7' );
    }
}
add_action('pre_get_posts', 'hmuda_modificar_main_query');

//=======================================================================================================
	
	WP_Query()
	
	//Definir los par�metros de la consulta a la base de datos
$args = array(
    'posts_per_page' => 3,
    'cat'  => 8,
    'offset' => 1
);
$loop_alternativo = new WP_Query($args);
if( $loop_alternativo->have_posts() ):
    while( $loop_alternativo->have_posts() ): $loop_alternativo->the_post();
       //Ya estamos en el bucle alternativo
       the_title();
    endwhile;
endif;
wp_reset_postdata();

//=======================================================================================================
	
get_posts()	
	//Definir los par�metros de la consulta a la base de datos
$args = array(
    'posts_per_page' => 3,
    'cat'  => 8,
    'offset' => 1
);
global $post;
$myposts = get_posts( $args );
foreach( $myposts as $post ) : 
    //Ya estamos en el bucle alternativo
    setup_postdata($post); 
    the_title();
endforeach;
wp_reset_postdata();
?>s


<?php
/*
* COMO LLAMAR LOS TITULOS DE UN page.php, single.php, index.php:
**/
?>
<!-- Versi�n 1: te entrega el nombre de la categoria -->
<h2><a href="<?php echo get_category_link(ej.3); ?>" title="ir a<?php the_title_attribute(); ?>"><?php echo get_cat_name(3);?></a></h2>
<!-- Versi�n 2: Puede usarse tambien el siguiente -->
<h2><a href="<?php echo get_category_link(ej.3); ?>" title="ir a<?php the_title_attribute(); ?>">****<?php the_title(); ?>****</a></h2>
<h2><a href="<?php the_permalink(); ?>" title="ir a<?php the_title_attribute(); ?>">****<?php the_title(); ?>****</a></h2>
<!-- Versi�n 3: Puede usarse tambien el siguiente -->
<?php the_title( '<h3>', '</h3>' ); ?>
<?php the_title_attribute('before=<h3>&after=</h3>'); ?>
<!-- Version 4: Puede usarse tambien el siguiente -->
<?php the_title('<h1 class="entry-title"><a href="' . get_permalink() . '"title="' . the_title_attribute('echo=0') . '" rel="bookmark">','</a></h1>'); ?>


<!-- Mostrar las categorias:  -->
<?php the_category( $separator, $parents, $post_id ); ?> 

<p>Categoria: <?php the_category(''); ?></p>

<!-- con comas o algun c�digo ascii -->

<p>Categoria: <?php the_category(', '); ?></p>
<p>Categoria: <?php the_category(' &gt; '); ?></p>
<p>Categoria: <?php the_category(' &bull; '); ?></p>

<!-- COMO MOSTRAR LOS METAS: --> 
<?php the_meta(); ?>

<p>Meta information for this post:</p>
<?php the_meta(); ?>

<ul class='post-meta'>
<li><span class='post-meta-key'>your_key:</span> your_value</li>
</ul>

<!-- COMO MOSTRAR LOS TAGS: -->
<?php the_tags( $before, $sep, $after ); ?>
<p><?php the_tags(); ?></p>
por comas:
<?php the_tags('Tags: ', ', ', '<br />'); ?>
<?php the_tags('Social tagging: ',' > '); ?>
<?php the_tags('Tagged with: ',' � ','<br />'); ?>
<?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>

<!-- WordPress: NUMERO TOTAL DE POST DE UNA CATEGORIA
 insertar la funci�n dentro del archivo functions.php de vuestro theme: -->
<?php
function numero_total_post($idcat) {
    global $wpdb;
    $query = "SELECT count FROM $wpdb->term_taxonomy WHERE term_id = $idcat";
    $numero = $wpdb->get_col($query);
    echo $numero[0];
}
?>
<!-- Usar de la siguiente forma: -->
<p>Esta categor�a tiene un total de: <?php echo numero_total_post(23); ?> entradas.</p>

<!-- INFORMACION PARA LOS SINGLES: -->
<div class="metabox">
 <span class="time meta">Publicado el <?php the_time('j') ?> de <?php the_time('F, Y') ?> | </span><span class="author meta">Por <?php the_author_posts_link(); ?> | </span>
 <span class="comments meta"><?php comments_popup_link('Sin Comentarios', '1 Comentario', '% Comentarios'); ?> | </span><span class="category meta">En la categor&iacute;a <?php the_category(' '); ?> | </span>
 <span class="tags meta">Con las siguientes etiquetas <?php the_tags(); ?></span>
 </div>

<p>Escrito por: <?php the_author(); ?></p>
 
<p>Publicado el <?php the_time('j') ?> de <?php the_time('F, Y') ?></p>

<span class="comments meta"><?php comments_popup_link('Sin Comentarios', '1 Comentario', '% Comentarios'); ?> | </span>

<!-- MOSTRAR FECHA EN ESPA�OL -->
<?php the_time('d \d\e\ F \d\e\ Y');?>

<!-- PARA ENVOLVER EL POST CON UN CLASS O ID PERSONALIZADO -->

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
<a class="leermas" href="<?php the_permalink(); ?>">Leer m�s &rarr;</a>

<!-- PAGINACION NUMERICA: -->
<!-- AGREGAR EN function.php -->

<?php
function paginado() {
    global $wp_query, $wp_rewrite;
    $wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
 
    $pagination = array(
        'base' => @add_query_arg('page','%#%'),
        'format' => '',
        'total' => $wp_query->max_num_pages,
        'current' => $current,
        'show_all' => true,
        'type' => 'list',
        'next_text' => '&raquo;',
        'prev_text' => '&laquo;'
        );
 
    if( $wp_rewrite->using_permalinks() )
        $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
 
    if( !empty($wp_query->query_vars['s']) )
        $pagination['add_args'] = array( 's' => get_query_var( 's' ) );
 
    echo paginate_links( $pagination );
}
?>

<!-- CODIGO A UTILIZAR EN EL TEMPLATE: --> 
<?php paginado(); ?>


<?php /*
SIDEBAR DINAMICOS PARA WIDGET
Copiar en el archivo function.php
1.- name: El nombre del Sidebar, por defecto es �Sidebar�.
2.- id: El id del sidebar (ej: sidebar-derecha), por defecto es el ID numerico auto-generado.
3.- description: Texto de descripcion del sidebar a registrar, se muestra en la pagina de Widgets, por defecto esta vacio
4.- class: Clase CSS a asignar a los widgets de este Sidebar.
5.- before_widget: C�digo HTML que ira antes de cada widget, por defecto es <li>
6.- after_widget: C�digo HTML que ira despu�s de cada widget, por defecto es </li>
7.- before_title: C�digo HTML que ira antes del t�tulo del Widget, por defecto es <h2>
8.- after_title: C�digo HTML que ira despu�s del t�tulo del Widget, por defecto es </h2>
**/?>
<?php
register_sidebar( 
	array(
  		'name' => 'Zona de Anuncios',
  		'id' => 'ad-zone',
  		'description' => 'Aqu� ir�n los anuncios del sitio',
  		'before_widget' => '<div class="widget ad">',
  		'after_widget'  => '</div>',
  		'before_title' => '<strong class="adtitle">',
  		'after_title' => '</strong>'
  	)
);
?>

<!-- CODIGO A UTILIZAR EN EL TEMPLATE: --> 
<?php dynamic_sidebar( 'ad-zone' ); ?>

<!-- LOOP para ordenar los post por ABC -->
<?php 

        //Conttrolas si ya estamos paginando
        $paged = (get_query_var('paged'))? get_query_var('paged'): 1;

        //Argumentos para filtrar los posts
            $args = array(
                    'paged' => $paged,
                    'cat' => 20, // Whatever the category ID is for your aerial category
                    'posts_per_page' => 100,
                    'orderby' => 'title', // date - comment_count - meta_value_num - 
                    'order' => 'ASC' // DESC o ASC          

            );
            //Y creamos el nuevo query

        $my_socio = new WP_Query( $args );
        ?>

        

        <?php
            //loop para mostrar los post

        if ($my_socio -> have_posts() ) : while ($my_socio -> have_posts() ) : $my_socio -> the_post(); ?>

<!-- FORMAS DE LLAMAR UN THUMBNAILS: -->

<?php if (has_post_thumbnail( $post->ID ) ): ?>
        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumb-banner-page' ); ?>
        <div class="portada-thumbnail" style="width: 1400px;height:300px;background-image: url('<?php echo $image[0]; ?>')">


<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumb-testimonio' );?>
        <img src="<?php echo $thumb['0'];?>" width="" height="" class="img-circle"> 

<?php 
$id = $post->ID;
if( ! has_post_thumbnail( $id ) ) {
    // the current page has no feature image
    // so we'll see if a) it has a parent and b) the parent has a featured image
    $ancestors = get_ancestors( $post->ID, 'page' );
    $parent_id = $ancestors[0];
    if( has_post_thumbnail( $parent_id ) ) {
        // we'll use the parent's featured image
        $id = $parent_id;
    }

}
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
?><img src="<?php echo $thumb['0']; ?>" width="230" height="230" class="img-circle">
 <div class='guideHeader' style='background-image: url(<?php echo $thumb['0']; ?>);'></div>


               <?php $image_id = get_post_thumbnail_id(); // attachment ID
                                   $image_attributes = wp_get_attachment_image_src( $image_id, 'full' ); 
                                                     ?>                                            
                                                      <img src="<?php echo $image_attributes[0]; ?>" width="230" height="230" class="img-circle"> 



 <!-- PRUEBA COMO BACKGROUND: --> 
<?php 
$id = $post->ID;
if( ! has_post_thumbnail( $id ) ) {
    // the current page has no feature image
    // so we'll see if a) it has a parent and b) the parent has a featured image
    $ancestors = get_ancestors( $post->ID, 'nombre del thumbnail' );
    $parent_id = $ancestors[0];
    if( has_post_thumbnail( $parent_id ) ) {
        // we'll use the parent's featured image
        $id = $parent_id;
    }

}
$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full' );
?><div class='thumbnailTestimonio' style='background-image: url(<?php echo $thumb['0']; ?>);'></div>

<!-- PRUEBA COMO ETIQUETA IMG: -->
    <?php $thumb_id = get_post_thumbnail_id();
       $thumb_url = wp_get_attachment_image_src($thumb_id,'Mi THUMBNAIL PERSONALIZADO', true); 
    ?>
    <img src="<?php echo $thumb_url[0]; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="mi clase personalizada" width="n" height="n">

<!-- PRUEBA COMO BACKGROUND SIMPLE: -->
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );?>
<div id="post" class"your-class" style="background-image: url('<?php echo $thumb['0'];?>')">

<!-- VINCULAR CSS EN FUNCTION.PHP --> 
<?php
wp_enqueue_style('styleTheme', get_stylesheet_uri());
wp_register_style('boostrap', get_template_directory_uri().'/library/bootstrap/bootstrap.min.css');
wp_enqueue_style( 'boostrap');

wp_register_style('limpiar_css', get_template_directory_uri().'/css/normalize.css');
wp_enqueue_style('limpiar_css' );

wp_register_style('fancybox', get_template_directory_uri().'/library/fancyBox/jquery.fancybox.css');
wp_enqueue_style( 'fancybox' );

wp_register_style('newstyle', get_template_directory_uri().'/css/style-2.css');
wp_enqueue_style( 'newstyle' ); 
}
add_action( 'wp_enqueue_scripts', 'add_styles_theme' );
?>
<?php 
add_action('wp_enqueue_scripts', 'miplugin_google_fonts');
function miplugin_google_fonts( ){
    wp_enqueue_script('google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans');
}

function wpb_add_google_fonts() {
    wp_enqueue_style( 'wpb-google-fonts', 'http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,400,700,300', false ); 
}
add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );
?>
<?php //======================================================================================================= 
      //    VINCULAR JS EN FUNCTION.PHP
     //=======================================================================================================  ?>

 <?php 
    add_action("wp_enqueue_scripts", "incrustar_estilos", 11);
        function incrustar_estilos(){
    // nos aseguramos que no estamos en el area de administracion
        if( !is_admin() ){

        // registramos nuestro script con el nombre "mi-script" y decimos que es dependiente de jQuery para que wordpress se asegure de incluir jQuery antes de este archivo
        // en adicion a las dependencias podemos indicar que este aarchivo debe ser insertado en el footer del sitio, en el lugar donde se encuente la funcion wp_footer
        //wp_register_script('mi-script', get_bloginfo('template_directory'). '/js/custom.js', array('jquery'), '1', true );
        wp_register_script('mi-script', get_bloginfo('template_directory'). '/js/custom.js', array(), '1', true );
        wp_register_script('mi-script-2', get_bloginfo('template_directory'). '/library/bootstrap/bootstrap.min.js', array('mi-script'), '1', true );
        wp_register_script('mi-script-3', get_bloginfo('template_directory'). '/library/fancyBox/jquery.fancybox.pack.js', array('mi-script-2'), '1', true );
        wp_register_script('mi-script-4', get_bloginfo('template_directory'). '/js/fancy-custom.js', array('mi-script-3'), '1', true);
        wp_enqueue_script('mi-script');
        wp_enqueue_script('mi-script-2');
        wp_enqueue_script('mi-script-3');
        wp_enqueue_script('mi-script-4');
       
    }
}
?>
<?php//======================================================================================================= 
// COMO LLAMAR EL NOMBRE DE UNA CATEGORIA
//======================================================================================================= ?>

<h1>&#151 <?php $category = get_the_category(); echo $category[0]->cat_name; ?> &#151</h1>



<?php //======================================================================================================= 
// MODIFICAR Y CREAR THUMNAILS DEL SISTEMA
//======================================================================================================= ?>
<?php
add_theme_support('post-thumbnails');
add_image_size ('thumb-news-home', 350, 150, true);
add_image_size ('thumb-news-blog', 280, 180, true);
add_image_size('large', 700, 600);           // Tama�o grande (defecto 640px x 640px max)
add_image_size('full', 700, 600);            // Tama�o real (tama�o original de la imagen subida)
the_post_thumbnail('thumbnail');       // Thumbnail (defecto 150px x 150px max)
the_post_thumbnail('medium');          // Tama�o medio (defecto 300px x 300px max)

?>
//======================================================================================================= 
// MODIFICAR Y CREAR THUMNAILS DEL SISTEMA
//======================================================================================================= 
//LOGOTIPO INICIO
<?php
 //* Cambia el logotipo de la p�gina inicio de sesi�n de WordPress (usar imagen de 80x80px)
function mi_logo_personalizado() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/my-imagen.png);
                background-size: 100%;
                width: 100px;
                height: 100px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'mi_logo_personalizado' );

//SOPORTE WOOCOMERCE

 add_action('after_setup_theme','woocommerce_support');
    function woocommerce_support() {
        add_theme_support('woocommerce');
    }


?>
<!-- LOOP FINAL PARA UN THEME -->

    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>

        //Thumnail code opcional
        <?php $thumb_id = get_post_thumbnail_id();
            $thumb_url = wp_get_attachment_image_src($thumb_id,'Mi_thumbnail_perzonalizado_desde_Function', true); ?>
            <img src="<?php echo $thumb_url[0]; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="mi_clase_personalizada" width="---" height="---">
    
        <h2><?php the_title(); ?></h2>
        <span class="byline">Publicado el <?php the_time('d F Y'); ?> | en <?php the_category(', '); ?> | por  <?php the_author(); ?></span>
        <div class="sumary">
            <?php the_content(); ?>
        </div>
        <?php endwhile; else: ?>        
            <div class="msj-error">   
                <h2>404</h2>
                <h3>Algo sali� mal</h3>
                <p>Oops! Lo sentimos este contenido ya no exite</p>
                <a href="#" class="btn red" title="---" alt="---">Regresa al inicio</a>
            </div><!-- mensaje de error -->
        <?php endif; ?>

<!-- CREAR UN TEMPLATE PARA LOS PAGE.PHP -->

<?php /* Template name: blog */ ?>

<!-- CAMBIAR UN HEADER EN EL THEME -->
<?php get_header('landing'); ?> 
<!-- El nombre langin hace referencia al nombre del archivo header-landing.php -->
<!-- COMO LLAMAR UN ARCHIVO PHP AL THEME -->
<?php include (TEMPLATEPATH. '/nombre-archivo.php'); ?>


<!-- VARIOS SCRIPT -->

<a href="<?php the_permalink() ?>" rel="bookmark" title="Permalink a <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
<span><?php the_time('F jS, Y') ?> | en <?php the_author_posts_link() ?></span>
<p class="postmetadata">Pubblicato in <?php the_category(', '); ?></p>

<div id="post-<?php the_ID(); ?>" <?php post_class(); //Optener ID o Clase del Post ?>>  
<div id="post-<?php the_ID(); ?>" <?php post_class( 'class-name' ); //Optener ID o Clase del Post ?>>

<body <?php body_class(); ?>>

<body class="page page-id-2 page-parent page-template-default logged-in">

<style type="text/css"> 
    .page {
        /* styles for all posts within the page class */
    }
    .page-id-2 {
        /* styles for only page ID number 2 */
    }
    .logged-in {
        /* styles for all pageviews when the user is logged in */
    }
</style>

<!-- LOOP WP_query corto con orden --> 

<?php $the_query = new WP_query('cat=20&posts_per_page=70&orderby=title&order=asc');
			while ($the_query -> have_posts() ) : $the_query -> the_post(); ?>
                
	<a class="" id="" href="#" title="ir a <?php the_title_attribute(); ?>" alt="">
			<?php if ( has_post_thumbnail() ) { the_post_thumbnail('name-thumb'); }       
			else { ?>
				<img class="" id="" src="<?php echo get_template_directory_uri(); ?>/images/thumbnail-default-socios2.png" alt="" title=""> 
			<?php } ?>
	</a>    
                    
<?php endwhile; wp_reset_query(); ?>     



<?php// Switch default core markup for search form, comment form, and comments to output valid HTML5.
add_theme_support('html5', array(
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
));

// Enable support for Post Formats.
add_theme_support('post-formats', array(
    'aside',
    'image',
    'video',
    'audio',
    'quote',
    'link',
));

?>

<?php 
/* 
*Templatepegar en functions.php �ra eliminar la version del wordrpess
**/
	remove_action('wp_head', 'wp_generator');
?>

<?php 
/* 
*para actualizacion automaticas del wordpress
**/

//Todas las actualizaciones del n�cleo desactivadas
define( 'WP_AUTO_UPDATE_CORE', false );
//Todas las actualizaciones del n�cleo activadas
define( 'WP_AUTO_UPDATE_CORE', true );
//S�lo actualizaciones menores del n�cleo activadas
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
?>

<?php 
/* 
* translProtege el archivo de configuraci�n de WordPress 
<Files wp-config.php>
order allow,deny
deny from all
</Files>
//Protege la carpeta de archivos subidos
<Files ~ ".*\..*">
	Order Allow,Deny
	Deny from all
</Files>
<FilesMatch "\.(jpg|jpeg|jpe|gif|png|bmp|tif|tiff|doc|pdf|rtf|xls|numbers|odt|pages|key|zip|rar)$">
	Order Deny,Allow
	Allow from all
</FilesMatch>

//Protege el archivo .htaccess
<files .htaccess>
order allow,deny
deny from all
</files>
**/
?>

<?php
/* 
* Bubuscador para un widget
**/
?>
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div>
        <label class="screen-reader-text" for="s"><?php _x( 'Search for:', 'label' ); ?></label>
        <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Buscar" />
        <input type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" />
    </div>
</form>

<!-- lista de ultimas noticias -->
<ul class="media-list">
    <?php $my_query = new WP_Query('cat=2&posts_per_page=6');
    while ( $my_query -> have_posts() ) : $my_query -> the_post(); 
		?>
  <li class="media">
    <div class="media-left">
      <a href="#">
        <?php $thumb_id = get_post_thumbnail_id();
       $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail', true); 
       ?>
        <img id="thumbSidebar" class="media-object" src="<?php echo $thumb_url[0]; ?>" alt="<?php the_title(); ?>" title="<?php echo get_cat_name(2);?>">
      </a>
    </div>
    <div id="sumaryAside" class="media-body">
      <h4 class="media-heading"><?php the_title(); ?></h4>
      <p><?php if (is_category() || is_archive() ) {
                echo excerpt('10');
                } else {
                echo content('10');
                }
        ?></p>
        <a href="<?php the_permalink(); ?>" title="ir a <?php the_title_attribute(); ?>" class="asidevermas"> Leer m�s</a>
    </div>
  </li>
  <?php endwhile; ?>
<?php wp_reset_postdata(); ?>   
</ul>
?>

<!-- Loop para categorias -->
<section class="">
	<?php if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } elseif ( get_query_var('page') ) { $paged = get_query_var('page'); } else { $paged = 1; } 
		/* $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1; */
		$custom_query_args = array(
				//'category_name' => 'custom-cat',
				//'post_type' => 'post', //--> array( 'post', 'page', 'movie', 'book' )
				'post_type' => 'post', 
				'posts_per_page' => -1,  //-->
				'paged' => $paged, //-->
				'post_status' => 'publish', //-->
				'ignore_sticky_posts' => true, //-->
				'order' => 'DESC', //--> 'DESC' | 'ASC'
				'orderby' => 'date' //--> modified | title | name | ID | rand
		);
		$custom_query = new WP_Query( $custom_query_args );
		if ( $custom_query->have_posts() ) : while( $custom_query->have_posts() ) : $custom_query->the_post(); ?>
		<div class="col-sm-12 col-md-4 col-lg-4 post-item grid-item p0 <?php $catID = the_category_ID($echo=false); echo $catID; ?> <?php $categories = get_the_category(); $category_list = join( ' ', wp_list_pluck( $categories, 'name' ) ); echo strtolower(wp_kses_post( $category_list )); ?>" >
						
			<?php $classes = array('post-entry', 'wow', 'animate__animated', 'animate__fadeIn', $termsString, $custom_values); ?>
			<div <?php post_class($classes);?> data-wow-duration=".6s" data-wow-delay=".5s" data-wow-offset="5">

				<div class="wrapp-thumbnail">
					<!-- thumbnail-post -->
						<p class="title-entry" style=""><?php the_title(); ?></p>
						<small class="byline"><?php echo strtolower(get_the_date('j F , Y')); ?></small>
						<?php $thumb_id = get_post_thumbnail_id(); $thumb_url = wp_get_attachment_image_src( $thumb_id, 'full'); ?>
							<?php if(has_post_thumbnail() ): ?>
								<picture class="thumb-category" style="background: url(<?php echo $thumb_url['0'];?>) no-repeat center center;background-size: cover;"></picture>
							<?php else : ?>
								<!-- <img src="<?php //echo get_template_directory_uri(); ?>/images/default-carousel.jpg ?>" class="img-fluid" alt=""> -->
								<picture class="thumb-category" style="background: url('<?php echo get_template_directory_uri(); ?>/assets/images/default-category.jpg') no-repeat center center;background-size: cover;"></picture>
						<?php endif; ?>							
					<!-- end thumbnail-post -->
				</div>


				<div class="post-info">
					<h4 class="title"><a href="<?php the_permalink(); ?>" title="ir a: <?php the_title(); ?>"><?php the_title(); ?></a></h4>
					<p class="sumary"><?php echo strtolower(get_the_date('j F , Y')); ?></p>
					<div class="">
						<a href="<?php the_permalink();?>" class="link-details" title="ir a <?php the_title_attribute(); ?>"><i class="fa fa-link"></i></a>
					</div>
				</div><!--./post-info -->


			</div><!--./post-wrapp -->


		</div><!--./grid-item -->

	

		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
		<?php else : get_template_part( 'template-parts/content', 'oops' );  endif; ?>
</section><!-- ./grid --> 


<!-- Agregar clases personalizadas de forma dinamica -->
<?php $classes = array('post-entry', 'wow', 'animate__animated', 'animate__fadeIn', $termsString, $custom_values); ?>
<div <?php post_class($classes);?> data-wow-duration=".6s" data-wow-delay=".5s" data-wow-offset="5"></div>