<?php

if (!function_exists('reportLog')) {

    /**
     * @param $exception
     */
    function reportLog($exception): void
    {
        if (is_string($exception)) {
            Log::channel('abuse')->info($exception);
        }

        Log::channel('abuse')->info($exception->getMessage());
    }
}
