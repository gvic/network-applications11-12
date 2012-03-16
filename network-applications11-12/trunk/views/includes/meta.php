<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?php echo $d['title']; ?></title> 
<!--        <link href="media/css/screen/content.css" rel="stylesheet" type="text/css"/>-->
        <link href="media/css/style.css" rel="stylesheet" type="text/css"/>
        <link type="text/css" href="media/css/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
        <link href="media/css/tabs-ui.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="media/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="media/js/jquery-ui-1.8.18.custom.min.js"></script>
        <script type="text/javascript">
            $(function(){
	
                // Tabs
                $('#tabs').tabs();
				
                //hover states on the static widgets
                $('#dialog_link, ul#icons li').hover(
                function() { $(this).addClass('ui-state-hover'); }, 
                function() { $(this).removeClass('ui-state-hover'); }
            );
				
            });
        </script>
        
    </head>
