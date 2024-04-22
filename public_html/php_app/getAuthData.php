<?php
require_once __DIR__ . '/AuthData.php';


function getAuthData($pan, $expDate, $cvv, $pin, $publicModulus = null, $publicExponent = null)
{
    $authData = AuthData::getAuthData($pan, $expDate, $cvv, $pin, $publicModulus, $publicExponent);
  
    return $authData;
}
