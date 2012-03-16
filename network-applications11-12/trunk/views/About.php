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
            <span class="mainContent">H-W University</span>
            <ul>
  		<li><h3>Sakura Komiya:  Responsible for the overall web-design, consistent design.</h3></li>
  		<li><h3>Geir F. Nygaard:  Responsible for a GlassFish application server 
performing imaging operations <br />
in a REST (Jersey) web-service, servicing the Apache/php server directly. 
He does PHP/html/css/javascript coding related to interacting 
with the GlassFish server.
		</h3></li>
  		<li><h3>Victor Godayer:  Chiefly responsible for the PHP code base 
and code design. In addition to php/html he does database tasks, SQL, 
javascript etc.</h3></li>
 		<li><h3>Wenshuo Tang.</h3></li>
	</ul>	

            <h3>Furland Nygaard Geir : gf58 [at] hw.ac.uk</h3>
			<h3>Godayer Victor : vg55 [at] hw.ac.uk</h3>
			<h3>Komiya Sakura : sk316 [at] hw.ac.uk</h3>
		<h3>Tang Wenshuo : wt92 [at] hw.ac.uk</h3>

			
			<p>This website has been created for a coursework for [F21NA] Network Applications course @ Heriot-Watt University.</p>
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
