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
            <form <?php echo $d['form']->renderFormAttributes() ?>>
                <div id="tabs">
                    <ul>
                        <li><a href="#photo-1"><span>Select Picture</span></a></li>
                        <li><a href="#frames-2"><span>Select Frame</span></a></li>
                        <li><a href="#preview-3"><span>Preview</span></a></li>
                        <li><a href="#review-4"><span>Review</span></a></li>
                    </ul>
                    <div id="photo-1">
                        <?php
                        if (isset($d['photoset_input'])) {
                            echo '<input type="hidden" name="photoset" value="true" id="hide_uploaded"/>';
                            echo '<br /><h4>Photo have been selected! Click below if you want to use another photo.</h4><br />';
                            echo '<input type="hidden" name="photopath" value="' . $d['photopath'] . '" id="filepath_image">';
                        }else{
                            echo '<input type="hidden" name="photoset" value="false" id="hide_uploaded"/>';
                            echo '<br /><h4>Select photo</h4><br />';
                        }

                        $fileField = $d['form']->getField('media_path');
                        $imageField = $d['form']->getField('image_name');
                        $nonFieldErros = $d['form']->renderNonFieldsError();
                        echo "<p>";
                        if ($nonFieldErros)
                            echo $nonFieldErros . "<br/>";

                        echo $imageField->renderErrors();
                        echo "</p>";
                        echo $imageField->renderLabel();
                        echo "<br/>";
                        echo $imageField->renderField();

                        echo $fileField->renderErrors();
                        echo "</p>";
                        echo $fileField->renderField();
                        ?>
                    </div>

                    <div id="frames-2">
                        <ul id='frame_grid'>
                            <input type='hidden' name='radiovalue' value='' id='radio_selected'></input>
                            <li>
                                <h4>Test Text!</h4>
                                <input type='radio' name='radioframe' value='radioframe1' />
                                <img class="tip" src="media/images/frameselection/frame1.png" width="120" height="79" alt="plau"/>
                            </li>

                            <li>
                                <h4>Test Text!</h4>
                                <input type='radio' name='radioframe' value='radioframe2' />
                                <img class="tip" src="media/images/frameselection/frame2.png" width="120" height="79" alt="plau"/>
                            </li>

                            <li>
                                <h4>Test Text!</h4>
                                <input type='radio' name='radioframe' value='radioframe3' />
                                <img class="tip" src="media/images/frameselection/frame3.png" width="120" height="79" alt="plau"/>
                            </li>

                            <li>
                                <h4>Test Text!</h4>
                                <input type='radio' name='radioframe' value='radioframe4' />
                                <img class="tip" src="media/images/frameselection/frame4.png" width="120" height="79" alt="plau"/>
                            </li>

                            <li>
                                <h4>Test Text!</h4>
                                <input type='radio' name='radioframe' value='radioframe5' />
                                <img class="tip" src="media/images/frameselection/frame5.png" width="120" height="79" alt="plau"/>
                            </li>

                            <li>
                                <h4>Test Text!</h4>
                                <input type='radio' name='radioframe' value='radioframe6' />
                                <img class="tip" src="media/images/frameselection/frame6.png" width="120" height="79" alt="plau"/>
                            </li>

                            <li>
                                <h4>Test Text!</h4>
                                <input type='radio' name='radioframe' value='radioframe7' />
                                <img class="tip" src="media/images/frameselection/frame7.png" width="120" height="79" alt="plau"/>
                            </li>

                            <li>
                                <h4>Test Text!</h4>
                                <input type='radio' name='radioframe' value='radioframe8' />
                                <img class="tip" src="media/images/frameselection/frame8.png" width="120" height="79" alt="plau"/>
                            </li>

                            <li>
                                <h4>Test Text!</h4>
                                <input type='radio' name='radioframe' value='radioframe9' />
                                <img class="tip" src="media/images/frameselection/frame9.png" width="120" height="79" alt="plau"/>
                            </li>

                        </ul>
                        <p style="clear:both;"></p>
                    </div>
                    <div id="preview-3">
                        <p> This part will be a larger form where the user can preview the framed picture by using AJAX (lower quality image).

                            <br />

                            <button type='button' id='previewButton'>Preview!</button>
                            <br />

                        <div id="previewDiv">



                        </div>


                    </div>
                    <div id="review-4">
                        <a id ="link-add" href="">Add to my Shopping Cart</a><br/>
                        <a id ="link-delete" href="">Delete this preview</a><br/>
                        <a id ="link-upload" href="index.php?c=Upload">Upload another photo</a><br/>
                        <a id ="link-see-all" href="index.php?c=ManageMyPictures">See all my pictures</a><br/>

                        <div id="status"></div>

                    </div>
                </div>



        </div>

    </div>
    <?php include ('sideBox.php'); ?>
    <div class="clear"></div>
</div>
</div>
<?php
include('footer.php');
?>
