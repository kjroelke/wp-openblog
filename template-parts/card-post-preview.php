<?php
/**
 * Post Preview Card
 * 
 * @package kjr_dev
 */

?>
<article class="card" style="border:1px solid black;border-radius:10px;box-shadow:2px 4px 10px 4px rgba(0,0,0,.15);overflow:hidden;position:relative;height:100%;">
    <?php
    if (has_post_thumbnail()) {
        echo "<figure class='mb-0 ratio ratio-1x1' style='aspect-ratio:1;width:100%;'>";
        the_post_thumbnail( 'large',array( 'class'=> 'object-fit-cover w-100 h-100','loading' => 'lazy','style'=> 'width:100%;height:100%;object-fit:cover' ) );
    }
    ?>
    <div class="card-body p-4" style="padding:20px;margin-block-end:20px;">
        <?php 
        the_title('<h3 class="h2">',"</h3>");
        the_excerpt();
        ?>
    </div>
    <a href="<?php the_permalink();?>" class="stretched-link" style="margin-block-start: auto;margin-inline:20px;">Read More</a>
</article>