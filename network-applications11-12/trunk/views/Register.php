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
            if ($d['form']) {
                $errors = $d['form']->renderNonFieldsError();
                if ($errors)
                    echo '<div class="error">' . $errors . '</div>';
                echo "<form " . $d['form']->renderFormAttributes() . " onsubmit=\"return checkAgreement()\">";
                echo $d['form']->renderAsP();
                $agree = $d['form']->getField('agreement');
                echo "<p>" . $agree->renderErrors() . "<br/>" . $agree->renderField() . " " . $agree->renderLabel() . "</p>";
                ?>
                <p><input type="submit" value="Register" /></p>
		<p><input type="reset"  value="Reset" /></p>
                <?php
                echo "</form>";
                $formName = $d['form']->getAttribute('name');
                echo '
                <script type="text/javascript">
                    function checkAgreement(){
                        if(document.'.$formName.'.agreement.checked==false){
                            alert("You must agree the terms of service!");
                            return false;
                        }
                        else
                            return true;
                    }
                </script> ';               
                
            }
            ?>
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
