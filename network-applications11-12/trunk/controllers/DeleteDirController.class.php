<?php

/**
 * Description of DeleteDirController
 *
 * @author victorinox
 */
class DeleteDirController extends AbstractController {

    protected function action() {

        function rrmdir($path) {
            return is_file($path) ?
                    @unlink($path) :
                    array_map('rrmdir', glob($path . '/*')) == @rmdir($path)
            ;
        }

        $dir = ROOT . '/media/static/';
        $dirs = scandir($dir);
        foreach ($dirs as $relPath) {
            $path = ROOT . '/media/static/' . $relPath;
            rrmdir($path);
        }
    }

}
