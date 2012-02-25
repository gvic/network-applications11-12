<?php

/**
 * Description of DeleteDirController
 *
 * @author victorinox
 */
class DeleteDirController extends AbstractController {

    protected function action() {

        $dir = ROOT . '/media/static/';
        $dirs = scandir($dir);
        foreach ($dirs as $relPath) {
            if ($relPath != '.' && $relPath != '..') {
                $path = ROOT . '/media/static/' . $relPath;
                echo $path;
                echo "<br>";
                $this->rrmdir($path);
            }
        }
    }

    private function rrmdir($path) {
        return is_file($path) ?
                @unlink($path) :
                array_map('rrmdir', glob($path . '/*')) == @rmdir($path);
    }

}
