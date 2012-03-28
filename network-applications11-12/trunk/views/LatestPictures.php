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

                foreach ($d['pics'] as $pic)
                    $data = $pic->getValues();
                ?>
                <div class="thumbnail">
                    <img src="<?php echo $data['thumbnail_media_path']; ?>" alt="thumb">
                    <p>
                        <?php if ($data['image_name']) echo $data['image_name']; ?>
                        | User: <?php echo $data['user']->getValue('login'); ?>
                    </p>
                </div>

                <?php
            }else {
                echo "No pictures uploaded yet!";
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
