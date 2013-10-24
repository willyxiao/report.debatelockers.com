<?php
    /** http://www.kavoir.com/2009/05/php-hide-the-real-file-url-and-provide-download-via-a-php-script.html **/
    
    // defines the path to the file
    $path = '../downloads/report_template.xltx';
    
    // defines the type of file
    $mm_type="application/octet-stream"; 

    // enables downloading the file
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header("Content-Type: " . $mm_type);
    header("Content-Length: " .(string)(filesize($path)) );
    header('Content-Disposition: attachment; filename="'.basename($path).'"');
    header("Content-Transfer-Encoding: binary\n");

    // outputs the content
    readfile($path);
    
    // exits
    exit();
?>
