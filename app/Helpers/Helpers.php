<?php

if (!function_exists('responseMsg')) {
    function responseMsg($status, $message, $data)
    {
        $message = ["status" => $status, "message" => $message, "data" => $data];
        return $message;
    }
}

if (!function_exists('remove_null')) {
    function remove_null($center)
    {
        if (is_object($center)) {
            $filtered = collect($center)->map(function ($val) {
                if (is_null($val)) {
                    $val = '';
                }
                return $val;
            });
            return $filtered;
        }

        $filtered = collect($center)->map(function ($value) {
            return collect($value)->map(function ($val) {
                if (is_null($val)) {
                    $val = '';
                }
                return $val;
            });
        });
        return $filtered;
    }
}
