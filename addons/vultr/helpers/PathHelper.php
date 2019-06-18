<?php

namespace MGModule\vultr\helpers;
/**
 * @author Mateusz Pawłowski <mateusz.pa@modulesgarden.com>
 */
class PathHelper {
    public static function getWhmcsPath($pathNumber = 5) {
        $currentDir = __DIR__;
     
        for ($i = 1; $i < $pathNumber; $i++) {
            $currentDir = dirname($currentDir);
        }
        return $currentDir;
    }

}
