
<div id="footer">
    <?php
    if (in_array('LastPictures', $GLOBALS['modules'])) {
        $pics = $d['last_pictures'];
        ?>
        <div id="footercontent">
            <div id="previews"> Recently Uploaded <br /><br />
                <?php
                foreach ($pics as $key => $obj) {
                    echo
                    '<div class="item">
                    <a href="#">
                        <img alt="Photo 1" src="' . $obj->getValue('thumbnail_media_path') . '">
                    </a>
                    <span class="caption">' . $obj->getValue('image_name') . '</span>
                </div>';
                }
                ?>
            </div>
        </div>
    <?php } ?>
</div>
<div id="credit">
    Network Applications - Coursework 2011 / 2012 @ Heriot-Watt University
    <a target="_blank" href="http://validator.w3.org/check?uri=<?php echo $GLOBALS['fullUrl']; ?>" >
        <img src="media/images/valid-xhtml10.png" alt="W3CValidation"/>
    </a>
</div>

</body>
</html>