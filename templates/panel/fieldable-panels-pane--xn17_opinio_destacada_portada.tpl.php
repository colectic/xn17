<?php
$node = $content['field_opinio_destacada']['#object']->field_opinio_destacada['und'][0]['nid'];
$node = node_load($node);
$autor = $node->field_autor_a['und'][0]['nid'];
$autor = node_load($autor);
$nom_autor = $autor->title;

?>

<div class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pdng_mdl">
    <div class="modul_2x1">
      <div class="titol-modul">Opinió</div>
      <div class="cont_titular_entradeta">
        <?php
        $urlNode = url($content['field_opinio_destacada'][0]['#href']);
        print "<a href='" . $urlNode . "'><h4>" . $node->title . "</h4></a>";
        ?>
        <div class="rightimage">
          <?php
          $imatge_autor = file_create_url($autor->field_autor_foto_quadrada['und'][0]['uri']);
          print "<img src='" . $imatge_autor . "' class='rightimage'>";
          ?>
        </div>
        <?php
        print "<a href='" . $urlNode . "'>" . $node->field_resum['und'][0]['value'] . "</a>";
        ?>
      </div>
    </div>
    <?php
    $urlAutor = url("node/" . $node->field_autor_a['und'][0]['nid']);
    ?>
    <div class="pie"><a href="<?php print $urlAutor ?>"><?php print $nom_autor; ?></a></div>
  </div>
</div>
