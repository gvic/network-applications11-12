<?php
include 'meta.php';
include 'topnav.php';
include 'navigation.php';
?>

<div id="main">
    <div class="page_margins">
        <div class="page">
            <div class="subcolumns">
                <div class="c75l">
                    <div class="subcl">
                        <fieldset class="yform">
                            <legend>Identification</legend>
                            <form action="?c=LoginPost" method="post">
                                <div class="type-text">
                                    <label for="password">Customer ID</label> 
                                    <input type="password" name="C_ID" id="password" size="20" />
                                </div>
                                <div class="type-button">
                                    <input type="reset" value="Reset" id="reset" /> 
                                    <input type="submit" value="Submit" id="submit" />
                                </div>
                            </form>
                        </fieldset>
                    </div>
                </div>
                <div class="c25r">
                    <div class="subcr">
                        <!-- Insert your subtemplate content here -->
                        <div class="note">
                            <ul>
                                <li><h3>
                                        <a href="?c=CreateAccountForm">Register</a>
                                    </h3></li>
                            </ul> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page">
            <h2>Authors recorded</h2>
            <?php
            foreach ($d['authors'] as $key => $model) {
                echo "<p>$model</p>";
            }
            ?>

            <h2>Last book</h2>
            <?php echo "<p>" . $d['book'] . "</p>"; ?>

            <h2>Big user</h2>
            <?php echo "<p>" . $d['user'] . "</p>"; ?>
            Email: <?php echo $d['user']->getValue('email') ?>
        </div>
    </div>
</div>

<?php
include('footer.php');
?>
