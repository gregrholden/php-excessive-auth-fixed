<?php

    session_start();
    
    // Generate Random Number and Set Session Variable
    $code = rand(1000, 9999);
    $_SESSION["code"] = $code;
    
    // Captcha Image Details
    $im = imageCreateTrueColor(50, 24);
    $bg = imageColorAllocate($im, 22, 86, 165); // background dark blue
    $fg = imageColorAllocate($im, 255, 255, 255); // text white
    imagefill($im, 0, 0, $bg);
    imageString($im, 5, 5, 5,  $code, $fg);
    
    // Enforce the need to revalidate Captcha on page load
    header("Cache-Control: no-cache, must-revalidate");
    header('Content-type: image/png');
    
    imagepng($im);
    imageDestroy($im);


