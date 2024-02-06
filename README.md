# Snippet para Wordpress y construcción de un theme desde 0
========================================================

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