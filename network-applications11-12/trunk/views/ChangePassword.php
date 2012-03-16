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
            if ($d['form']) {
                $errors = $d['form']->renderNonFieldsError();
                if ($errors)
                    echo '<div class="error">' . $errors . '</div>';
                echo "<form " . $d['form']->renderFormAttributes() . ">";
                echo $d['form']->renderAsP();
                ?>
                <input type="submit" value="Save">
                <input type="reset"  value="Reset">
                <?php
                echo "</form>";
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
