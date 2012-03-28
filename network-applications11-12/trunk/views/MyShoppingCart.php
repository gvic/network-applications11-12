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
            <?php if ($d['items']) { ?>
                <?php
                foreach ($d['items'] as $imagepath => $pic) {
                    $data = $pic->getValues();
                    ?>
                    <div class="thumbnail">
                        <img src="<?php echo $data['thumbnail_media_path']; ?>" alt="thumb">
                        <p>
                            <?php if ($data['image_name']) echo $data['image_name']; ?>
                            | <a href="?c=MyShoppingCart&action=delete&id=<?php echo $data['id']; ?>">
                                Delete
                            </a>
                        </p>

                    </div>


                    <?php
                }
            }
            else {
                echo "You have no pictures so far!";
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
