<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title><?php echo $d['title']; ?></title> 

        <link href="media/css/style.css" rel="stylesheet" type="text/css"/>
        <link type="text/css" href="media/css/jquery-ui-1.8.18.custom.css" rel="stylesheet" />
        <link href="media/css/tabs-ui.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="media/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="media/js/jquery-ui-1.8.18.custom.min.js"></script>
        <?php
        if (isset($d['include_preview'])) {
            echo '<link href="media/css/frame_selection_style.css" rel="stylesheet" type="text/css" />';
            echo '<script type = "text/javascript" src = "media/js/preview.js"></script>';
        }
        ?>

    </head>
