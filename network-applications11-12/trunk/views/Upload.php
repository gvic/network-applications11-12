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
            <!--
            <?php
            if ($d['form']) {
                $errors = $d['form']->renderNonFieldsError();
                if ($errors)
                    echo '<div class="error">' . $errors . '</div>';
                echo "<form " . $d['form']->renderFormAttributes() . ">";
                echo $d['form']->renderAsP();
                ?>
                    <input type="submit" value="Upload" />
                    <input type="reset"  value="Reset" />
                <?php
                echo "</form>";
            }
            ?>
            -->
            <div id="tabs">
                <ul>
                    <li><a href="#photo-1"><span>Select Picture</span></a></li>
                    <li><a href="#frames-2"><span>Select Frame</span></a></li>
                    <li><a href="#review-3"><span>Review</span></a></li>
                </ul>
                <form id='photoform' action='photoTest.php' method='post' 
                      enctype='multipart/form-data'>
                    <div id="photo-1">
                        <p> Selecting photo here to add frame/theme 
                            graphics.</p>
                        <br />
                        <h4>Select photo</h4>
                        <br />
                        <input type='file' name='photo_file' id='photo' />

                    </div>

                    <div id="frames-2">
                        <br />
                        <p> Frame graphics will be displayed here 
                            in a grid. 
                            They will be loaded by reading file 
                            paths (to thumbnail frames) from the database in php to enable dynamically exapsion of selection. </p>
                    </div>
                    <div id="review-3">
                        <p> This part will be a larger form where 
                            the user can preview the framed picture by using AJAX (lower quality image), 
                            set some preferences, and choose to 
                            add the framed picture to the shopping cart or go to the web page for final ordering details.</p>

                        <br />
                        <button type='button' 
                                id='previewButton'>Preview!</button>
                    </div>
                </form>
            </div>

        </div>
        <?php include ('sideBox.php'); ?>
        <div class="clear"></div>
    </div>
</div>
<?php
include('footer.php');
?>
