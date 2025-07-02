<?php 

function isCurrentFile($fileName) {
    return basename(__FILE__) === $fileName;
}