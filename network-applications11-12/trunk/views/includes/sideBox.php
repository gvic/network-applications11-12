<div id="highlights">
    <ul>
        <?php if ($d['isAuth']) { ?>
            <li>
                <h3>
                    <a href="index.php?c=MyAccount">Your Account</a>
                </h3>
                Your account details
            </li>
        <?php } ?>

        <?php
        if (isset($d['CART']) && !empty($d['CART'])) {
            ?>
            <li>
                <h3>
                    <a href="index.php?c=MyShoppingCart">My Shopping Cart</a>
                </h3>
                Check out
            </li>
        <?php } ?>
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
