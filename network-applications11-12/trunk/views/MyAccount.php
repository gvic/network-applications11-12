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
                <li><a href="?c=MyAccountDetails">Change my account details</a></li>
                <li><a href="?c=ManageMyPicture">Manage my pictures</a></li>
            </ul>
            
        </div>
        <div id="highlights">
            <ul>
                <li>
                    <h3>
                        <a href="account.html">Your Account</a>
                    </h3>
                    Your account details
                </li>
                <li>
                    <h3>
                        <a href="help.html">Help</a>
                    </h3>
                    Lost? Click here!
                </li>
                <li>
                    <h3>
                        <a href="TandC.html">TermsConditions</a>
                    </h3>
                    Please Read Carefully
                </li>
            </ul>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php
include('footer.php');
?>