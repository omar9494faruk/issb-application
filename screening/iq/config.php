<?php

$conn =  mysqli_connect('localhost','searchli_mainDevAlpha','AkashBhoraTara@','searchli_IQ');
$conn2 =  mysqli_connect('localhost','searchli_mainDevAlpha','AkashBhoraTara@','searchli_users');

if(!$conn){
    die("Connection failed : " . mysqli_connect_error());
}