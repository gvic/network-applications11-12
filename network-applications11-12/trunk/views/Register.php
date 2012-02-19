<?php
include 'meta.php';
include 'topnav.php';
?>
<div id="wrap">

    <div id="contents">
        <div class="clear"></div>
        <div id="homecontents" style="width: 679px">
            <h2>
                Register Form
            </h2>

            <?php
            if ($d['displayForm']) {
                $errors = $d['form']->renderNonFieldsError();
                if ($errors)
                    echo '<div class="error">' . $errors . '</div>';
                echo "<form " . $d['form']->renderFormAttributes() . ">";
                echo $d['form']->renderAsP();
                $agree = $d['form']->getField('agreement');
                echo "<p>" . $agree->renderErrors() . "<br>" . $agree->renderField() . " " . $agree->renderLabel() . "</p>";
                ?>
                <input type="submit" value="Register">
                <input type="reset"  value="Reset">
                <?php
                echo "</form>";
            }
            ?>


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