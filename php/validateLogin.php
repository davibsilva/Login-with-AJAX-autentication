<?php
function validateLogin ($login, $password,  $valid, $row, $twoFactor){
    if($login && $password) {
        if($row['login'] == $login && $row['password'] == $password) {
            $valid = true;
            $twoFactor = $row['twoFactor'];
            return $valid;
            return $twoFactor;
        }
    }
}
?>