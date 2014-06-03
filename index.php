<?php
$lookup = file_get_contents('./urls.txt',true);
var_export($lookup);
$lookup = explode("\n",$lookup);
$curl = curl_init();
$content = '';

foreach($lookup AS $line) {
    $page = explode(' ',$line);
    $options = array(
        CURLOPT_URL => $page[0],
        CURLOPT_HEADER => 0,
        CURLOPT_FOLLOWLOCATION => 1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 1
        );
    curl_setopt_array($curl, $options);
    curl_exec($curl);
    if(!curl_errno($curl)) {
        $info = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
        $host = parse_url($info, PHP_URL_HOST);
        $ip = gethostbyname($host);
        if($page[0]!='') $content .= $page[0]." ".$ip."\n";
    }
    else {
        if($page[0]!='') $content .= $page[0]." ".$page[1]."\n";
    }
    file_put_contents('./urls.txt',$content,FILE_USE_INCLUDE_PATH);
}

curl_close($curl);
?>
