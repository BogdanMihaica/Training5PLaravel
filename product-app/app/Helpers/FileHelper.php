<?php

use Illuminate\Support\Facades\Storage;


/**
 * Searches for an image in the storage and returns it's asset path or the unk image if it doesn't exist
 * 
 * @param int $id
 * 
 * @return string
 */
function findImage(int $id)
{
    $directory = storage_path() . '\\app\\public\\products\\';
    $files = scandir($directory);

    foreach ($files as $file) {
        $name = explode('.', $file)[0];

        if ($name == $id) {
            return asset('storage/products/' . $file);
        }
    }
    return asset('storage/products/unk.jpg');
}

/**
 * Searches for an image in the storage and returns it's name or null
 * 
 * @param int $id
 * 
 * @return string|null
 */
function findImageName(int $id)
{
    $directory = storage_path() . '\\app\\public\\products\\';
    $files = scandir($directory);

    foreach ($files as $file) {
        $name = explode('.', $file)[0];

        if ($name == $id) {
            return $file;
        }
    }
    return null;
}
