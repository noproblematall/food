<?php
namespace App\Helpers;
use Cache;

class Helper
{

    public function __construct()
    {
        
    }

    public static function isOnline($id)
    {
        return Cache::has('user-is-online-' . $id);
    }

    public static function datalog($content){
        $filename = storage_path() . '\\datalogs\\datalogs.log';
        
        if ($handle = fopen($filename, 'a')) {
            if (fwrite($handle, $content . " \n") === FALSE) {
                return FALSE;
            }
            fclose($handle);
            return TRUE;
        }
        return FALSE;
    }

    
}
