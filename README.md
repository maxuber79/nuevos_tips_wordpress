<div align="center">

# 🧠 Nuevos Tips WordPress — Snippets y Loops para Themes

![WordPress](https://img.shields.io/badge/WordPress-21759B?style=flat-square&logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat-square&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white)
![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg?style=flat-square)

📘 **Repositorio de snippets, loops y buenas prácticas** para la construcción de temas de **WordPress** desde cero.  
Incluye fragmentos de código PHP, HTML, y ejemplos integrados con **Bootstrap 5.3** y funciones nativas del **WordPress Codex**.

</div>

---

## 🧩 Propósito

Este proyecto sirve como **referencia personal y base reutilizable** para crear o mejorar plantillas WordPress personalizadas.  
Todos los snippets han sido probados en proyectos reales de desarrollo frontend y backend con enfoque en **rendimiento, SEO y compatibilidad**.

---

## 📚 Contenido principal

### 🔁 Loops personalizados

Incluye distintos niveles de loops para listar contenido en themes:

- **Loop básico**: estructura mínima de posts.
- **Loop medio**: muestra contenido y excerpt.
- **Loop avanzado**: incluye thumbnails, validaciones y mensajes de error personalizados.
- **Loop con paginación (Bootstrap)**: integrado con `WP_Query`.
- **Loop reducido**: ideal para widgets o secciones de categorías.

Cada bloque incluye ejemplos funcionales con código PHP y comentarios de contexto.

---

### 🧱 Tips y snippets frecuentes

El repositorio también contiene ejemplos para:

- Mostrar **títulos** dinámicos y categorías.  
- Formatear **bylines** (autor, fecha, tags, comentarios).  
- Mostrar y manipular **thumbnails**.  
- Generar **clases dinámicas** e identificadores personalizados.  
- Insertar **enlaces personalizados** según ID, categoría o slug.  
- Mostrar **imágenes destacadas** con fallback predeterminado.  

Cada ejemplo está acompañado de comentarios descriptivos y sintaxis actualizada compatible con PHP 8+.

---

## ⚙️ Tecnologías y dependencias

| Recurso | Descripción |
|----------|-------------|
| **WordPress Codex** | Base de funciones y hooks utilizados |
| **Bootstrap 5.3** | Estilos, componentes y layout responsive |
| **PHP 8+** | Estructura de templates y lógica dinámica |
| **HTML5 / CSS3 / SCSS** | Maquetación y estilos base |
| **Animate.css / AOS.js** | Animaciones y efectos visuales |

---

## 🧰 Recomendaciones para uso

1. **Clonar o descargar** este repositorio para referencia local.  
   ```bash
   git clone https://github.com/maxuber79/nuevos_tips_wordpress.git
   ```
2. Copia los snippets que necesites dentro de tu theme (`functions.php`, `category.php`, `single.php`, etc.).  
3. Adapta rutas, IDs o slugs según tu proyecto.  
4. Integra con tus librerías o frameworks preferidos (Bootstrap, Tailwind, UIkit, etc.).

---

## 🪄 Ejemplo destacado — Loop avanzado con imagen por defecto

```php
<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
  <a href="<?php the_permalink(); ?>" title="Ir a <?php the_title_attribute(); ?>">
    <?php if ( has_post_thumbnail() ) { 
      the_post_thumbnail('medium'); 
    } else { ?>
      <img src="<?php echo get_template_directory_uri(); ?>/images/default-thumb.jpg" alt="<?php the_title(); ?>">
    <?php } ?>
  </a>
  <h2><?php the_title(); ?></h2>
  <span>Publicado el <?php the_time('d F Y'); ?> por <?php the_author(); ?></span>
<?php endwhile; else: ?>
  <div class="alert alert-warning">No hay contenido disponible</div>
<?php endif; ?>
```

---

## 📦 Futuras integraciones reutilizables

Este repositorio servirá como **base documental** para otros proyectos desarrollados por **WEBMAIN**, integrando lo mejor de los repos anteriores:

- 🔹 **ClaimsaApp (Angular + Firebase)** — estructura modular y CI/CD automático  
- 🔹 **GSAForce (HTML Theme)** — estructura visual escalable con SCSS y Bootstrap  
- 🔹 **API REST WordPress JS** — integración de WordPress REST API con JavaScript puro  

Estas integraciones futuras permitirán crear una **guía viva de desarrollo web full‑stack**, combinando WordPress, Angular y frontends modulares.

---

## 🧑‍💻 Autor

**Claudio (WEBMAIN)**  
📍 Chile  
💼 Desarrollador Frontend & Publicista Digital  
🌐 [webmain.cl](https://webmain.cl)  
🐙 [github.com/maxuber79](https://github.com/maxuber79)

---

<div align="center">
  <img src="https://s.w.org/style/images/about/WordPress-logotype-simplified.png" width="120"/>
  <img src="https://getbootstrap.com/docs/5.3/assets/brand/bootstrap-logo-shadow.png" width="80"/>
  <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" width="80"/>
  <br><br>
  <b>✨ Nuevos Tips WordPress — Reutilizable, modular y siempre en evolución ✨</b>
</div>
