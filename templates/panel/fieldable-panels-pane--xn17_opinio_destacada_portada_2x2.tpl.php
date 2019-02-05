<?php
$node = $content['field_opinio_destacada']['#object']->field_opinio_destacada['und'][0]['nid'];
$node = node_load($node);
$autor = $node->field_autor_a['und'][0]['nid'];
$autor = node_load($autor);
$nom_autor = $autor->title;
?>
<div class='titol-regio'><?php print $content['title']['#value']; ?></div><div class='espaiblanc'></div>

<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 opinio-destacada-2x2 pdng_mdl">
  <div class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <div class="destacat_2x2">
      <?php
      $imatge = image_style_url('xn17_vertical',$autor->field_autor_foto_vertical['und'][0]['uri']);
      ?>
      <div class="imatge-destacada-opinio">
        <img src="<?php print $imatge; ?>">
      </div>
      <div class="titular-entradeta">
        <?php
        $urlNode = url($content['field_opinio_destacada'][0]['#href']);
        print "<a href='" . $urlNode . "'><h4>" . $node->title . "</h4></a>";
        ?>
        <div class="hola hidden-xs">
        <?php
        print "<a href='" . $urlNode . "'>" . $node->field_resum['und'][0]['value'] . "</a>";
        print "<div class='data'>" . format_date($node->field_data_calculada['und'][0]['value'], "custom", "d, M Y") . "</div>";
        ?>
        </div>
      </div>
      <?php
      $urlAutor = url("node/" . $node->field_autor_a['und'][0]['nid']);
      ?>
      <div class="pie">
        <a href="<?php print $urlAutor ?>" ><?php print $nom_autor; ?></a>
      </div>
    </div>
  </div>
</div>
