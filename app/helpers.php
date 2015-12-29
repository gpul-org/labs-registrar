<?php namespace Registration;

function add_heading_msg($className, $text, $now = false, $key = 'heading_msgs')
{
    $content = array_merge(\Session::get($key, []), [new AlertMsg($className, $text)]);

    if ($now) {
        return \Session::now($key, $content);
    } else {
        return \Session::flash($key, $content);
    }
}
