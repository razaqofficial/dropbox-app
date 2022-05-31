<?php

if (!function_exists('redirectTo')) {
    function redirectTo($location) {
        return header($location);
    }
}