<?php

if (!function_exists('reportLog')) {

    /**
     * @param $exception
     */
    function reportLog($exception): void
    {
        if (is_string($exception) || is_array($exception)) {
            Log::channel('abuse')->error($exception);
        }

        Log::channel('abuse')->error($exception->getMessage());
    }
}
