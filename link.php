<?php

/**
 * router file
 *
 * @package    Y-Link
 * @copyright  Copyright (c) 2018-2020 Yehuda Eisenberg (https://YehudaE.net)
 * @author     Yehuda Eisenberg
 * @license    AGPL-3.0
 * @version    2.0
 * @link       https://github.com/YehudaEi/Y-Link
 */

include("include/init.php");

header("Cache-Control: no-cache");
header("Content-Type: text/html; charset=utf-8");
header("Cache-Control: no-store");

$uri = str_replace(parse_url(SITE_URL)['path'] ?? "", "", $_SERVER['REDIRECT_URL']);

$uri = urldecode(substr($uri, 1));

if(substr($_SERVER['REDIRECT_URL'], -1) == "+"){
    $getData = true;
    $uri = substr($uri, 0, -1);
}

if(isset($uri) && preg_match(PATH_REGEX, $uri)){
    $longLink = getLongLink($uri);
}
if(isset($longLink) && !empty($longLink)){
    addVisitor($uri);
    if(isset($getData) && $getData){
        echo "in building";
    }
    else{
        header("Location: " . $longLink);
        echo "error in moving you to <a href=\"".rawurlencode($longLink)."\" rel=\"noreferrer nofollow\">this link</a>. You can click <a href=\"".rawurlencode($longLink)."\" rel=\"noreferrer nofollow\">here</a>";
    }
}else{
    http_response_code(404);
    include 'apache-errors/404.html';
}

$DBConn->close();

?>
