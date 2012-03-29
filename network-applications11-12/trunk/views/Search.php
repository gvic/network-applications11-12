<?php
include 'meta.php';
include 'topnav.php';
?>
<div id="wrap">

    <div id="contents">
        <div class="clear"></div>
        <div id="homecontents" style="width: 679px">
            <h2>
                <?php echo $d['title']; ?>
            </h2>
            <?php
            if (!empty($d['pics'])) {
                foreach ($d['pics'] as $pic) {
                    $data = $pic->getValues();
                    echo '<div class="thumbnail">';
                    echo '<img width="90" src="' . $data['thumbnail_media_path'] . '" alt="img" />';
                    echo '<p>' . $data['image_name'] . ' | ' . $data['user'] . '</p></div>';
                }
            } else {
                echo "No results found!";
            }
            ?>

        </div>
        <?php include ('sideBox.php'); ?>
        <div class="clear"></div>
    </div>
</div>
<?php
include('footer.php');
?>
