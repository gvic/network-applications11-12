<?php
include 'meta.php';
include 'topnav.php';
?>
<div id="wrap">

    <div id="contents">
        <div class="clear"></div>
        <div id="homecontents" style="width: 679px">
            <h2>
  <?php echo $d['title'];?>
            </h2>

        </div>
        <div id="highlights">
            <ul>
                <li>
                    <h3>
                        <a href="index.php?c=MyAccount">Your Account</a>
                    </h3>
                    Your account details
                </li>
                <li>
                    <h3>
                        <a href="index.php?c=About">About Us</a>
                    </h3>
                    Learn more
                </li>
                <li>
                    <h3>
                        <a href="index.php?c=TandC">Terms and Conditions</a>
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