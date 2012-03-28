<div id="highlights">
    <ul>
        <li>
            <h3>
                <a href="index.php?c=MyAccount">Your Account</a>
            </h3>
            Your account details
        </li>
        <?php
        if (isset($d['CART']) && !empty($d['CART'])) {
            ?>
            <li>
                <h3>
                    <a href="index.php?c=MyShoppingCart">My Shopping Cart</a>
                </h3>
                Learn more
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
