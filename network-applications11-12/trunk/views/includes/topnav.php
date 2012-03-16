<body style="-moz-user-select: text;">
    <div id="topbar">
        <div id="TopSection">
            <h1 id="sitename">
                <a href="?c=Index" class="auto-style1">PicUp</a>
                <span>
                    <a href="?c=Index" class="auto-style1"> your Frame</a>
                </span>
            </h1>
            <div id="topbarnav">
                <span class="topnavitems">
                    <?php if ($d['isAuth']) { ?>
                        <a href="?c=MyAccount">My Account</a>
                        |
                        <a href="?c=Logout">Logout</a>
                    <?php } else {
                        ?>
                        <a href="?c=Register">Register</a>
                        |
                        <a href="?c=Login">Login </a>
                    <?php }
                    ?>
                </span>
                <form action="#">
                    <div class="searchform">
                        <label for="searchtxt"> Search Pics From Others: </label>
                        <input id="searchtxt" class="keywordfield">
                        <input type="submit" value="Search">
                    </div>
                </form>
            </div>
            <div class="clear"></div>
            <ul id="topmenu">
                <li class="active">
                    <a href="?c=Index">Home</a>
                </li>
                <li>
                    <a href="?c=Upload">Start Uploading</a>
                </li>
                <li>
                    <a href="?c=Browse">Browse</a>
                </li>
            </ul>
        </div>


    </div>
    <?php
    if (!empty($d['Messages'])) {
        include 'messages.php';
    }
    ?>