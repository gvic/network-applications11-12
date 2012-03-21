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
            <?php if ($d['pics']) { ?>
                <form method="post" id="manageForm" action=".">
                    <table>
                        <thead>
                            <tr>
                                <th>Thumbnail</th>
                                <th>Image Name</th>
                                <th>Private access</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($d['pics'] as $key => $pic) {
                                $vals = $pic->getValues();
                                ?>
                                <tr>
                                    <td><?php if ($vals['thumbnail_media_path']) echo $vals['thumbnail_media_path']; ?></td>
                                    <td><?php if ($vals['image_name']) echo $vals['image_name']; ?></td>
                                    <td><?php
                        $cked = "";
                        if ($vals['private'] == "1")
                            $cked = 'checked="checked"';
                        echo '<input type="checkbox" name="private_' . $vals['id'] . '" value="' . $vals['id'] . '" ' . $cked . '>';
                                ?>
                                    </td>
                                    <td><a href="?c=ManageMyPictures&action=delete&id=<?php echo $vals['id']; ?>">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>

                    <p><input type="submit" name="update" value="Update" /></p>
                    <p><input type="reset" name="reset" value="Reset" /></p>
                </form>
                <?php
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
