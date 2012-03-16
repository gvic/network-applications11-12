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

            <ul>
                <li><a href="?c=ManageMyPictures">Manage my pictures</a></li>
                <li><a href="?c=MyAccountDetails">Change my account details</a></li>
                <li><a href="?c=ChangePassword">Change my password</a></li>
            </ul>

        </div>
        <?php include ('sideBox.php'); ?>
        <div class="clear"></div>
    </div>
</div>
<?php
include('footer.php');
?>
