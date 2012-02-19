<?php
include 'meta.php';
include 'topnav.php';
?>
<div id="wrap">
    <div id="contents">
        <div class="clear"></div>
        <div id="homecontents" style="width: 679px">
            <h2>
                Log In Page
            </h2>
            <div id="loginSpace" class="float_left">
                <?php
                echo $d['form']->renderNonFieldsError();
                echo "<form " . $d['form']->renderFormAttributes() . ">";
                echo $d['form']->renderAsP();
                ?>
                <p><input type="submit" value="Login" /></p>
                </form>
            </div>
            <div id="forgot">
                <ul>
                    <li><a href="passrecover.html">Forgot your Password? Click HERE!</a></li>
                    <li><a href="register.html">New to PicUp ? Register HERE!</a></li>
                </ul>
            </div>
        </div>
        <div id="highlights">
            <ul>
                <li>
                    <h3>
                        <a href="?c=MyAccount">My Account</a>
                    </h3>
                    Your account details
                </li>
                <li>
                    <h3>
                        <a href="?c=Help">Help</a>
                    </h3>
                    Lost? Click here!
                </li>
                <li>
                    <h3>
                        <a href="?c=TandC">TermsConditions</a>
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