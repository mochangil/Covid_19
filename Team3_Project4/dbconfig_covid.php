<?php
    $dPconfig['dbhost'] = '127.0.0.1';
    $dPconfig['dbname'] = 'COVID_19';
    $dPconfig['dbuser'] = '';
    $dPconfig['dbpass'] = '';

    $db_host = $dPconfig['dbhost'];
    $db_name = $dPconfig['dbname'];
    $db_pass = $dPconfig['dbpass'];
    $db_user = $dPconfig['dbuser'];

    $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name);

    if(mysqli_connect_error()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    mysqli_query($link, "set names utf8");
?>