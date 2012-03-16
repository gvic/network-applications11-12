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
                $formName = $d['form']->getAttribute('id');
                echo '
                <script type="text/javascript">
                    function checkAgreement(){
                        if(document.getElementById("'.$formName.'").agreement.checked==false){
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
        <?php include ('sideBox.php'); ?>
        <div class="clear"></div>
    </div>
</div>
<?php
include('footer.php');
?>
