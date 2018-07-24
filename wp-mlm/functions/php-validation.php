<?php
function inputFieldBlankCheck($value)
{
    if($value=="")
	return true;
    else
	return false;
}
function confirmPasswordCheck($pass,$confirm_pass)
{
    if($pass!=$confirm_pass)
	return true;
    else
	return false;
}
