<?php
/**
 * @author Maksim Khodyrev<maximkou@gmail.com>
 * 12.05.17
 */

if (!function_exists('is_granted')) {
    function is_granted($actions, $object = null, $user = null)
    {
        return \Maximkou\SimpleVoters\Facades\Access::isGranted($actions, $object, $user);
    }
}