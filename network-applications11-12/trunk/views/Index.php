<?php
include 'meta.php';
include 'topnav.php';
?>

<div id="wrap">
    <div id="header">
        <h2 class="introtext">
            Order Framed Pictures In One Click! with
            <span class="highlight2">PicUp</span>
        </h2>
    </div>
    <div id="contents">
        <table class="reg" >
            <tr>
                <td>
                    <?php if ($d['isAuth']) { ?>
                        <a href="?c=Upload"><img alt="Upload now!" height="45" 
                                                 src="media/images/upNow.png" width="211"></img></a> 
                        <?php } else {
                            ?>
                        <a href="?c=Register"><img alt="Register here!" height="45" 
                                                   src="media/images/regNow.png" width="211"></img></a> 
                        <?php }
                        ?>

                </td>
                <td>
                    <a href="?c=LatestPictures"><img alt="Browse" height="45" src="media/images/brow.png" 
                                             width="211" /></a></td>
            </tr>
            <tr>
                <td><strong>
                        <?php if ($d['isAuth']) {
                            echo "Welcome back, upload now!";
                        } else {
                            echo "Sign Up Now!";
                        }
                        ?>
                    </strong></td>
                <td><strong>Browse Last Uploaded Picture!</strong></td>
            </tr>
        </table>
        <div class="clear"></div>
        <div id="homecontents" style="width: 100%">

            <table class="introTab" >
                <tr>
                    <td>
                        <img alt="Upload and Store" height="61" src="media/images/upload.png" width="61" /></td>
                    <td><span><strong>Upload 
                                your Picture!</strong></span></td>
                    <td>
                        <img alt="Frame your Picture" height="61" src="media/images/frame.png" width="61" /></td>
                    <td><span><strong>Frame 
                                your Picture!</strong></span></td>
                </tr>
                <tr>
                    <td>
                        <img alt="Browse on your PC" height="61" src="media/images/browse.png" width="61" /></td>
                    <td><span><strong>Browse 
                                what others have uploaded!</strong></span></td>
                    <td>
                        <img alt="Download on your PC" height="61" src="media/images/download.png" width="61" /></td>
                    <td><span><strong>Download 
                                your framed picture!</strong></span></td>
                </tr>
            </table>

            &nbsp;<p>"PicUp your frame" is an online picture storage service where you can frame digitally your favourite pictures and either download for your own collection or share them to others!</p>


            <p>This website has been created for a coursework for [F21NA] Network Applications course @ Heriot-Watt University.</p>
        </div>

        <div class="clear"></div>
    </div>
</div>

<?php
include('footer.php');
?>
