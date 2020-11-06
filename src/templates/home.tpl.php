<?php
include 'src/templates/header.tpl.php';
?>
<main>
    <article>
        <h2 class="text-center" style="margin-top: 20px;"><?= $title; ?></h2>
    </article>
    <?php
    if (isset($lastTime)) {
        echo '<p>Entraste por ultima vez: ' . $lastTime . ' </p>';
    }
    ?>
</main>
<?php
include 'src/templates/footer.tpl.php';
