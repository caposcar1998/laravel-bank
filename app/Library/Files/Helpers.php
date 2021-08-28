<?php

if (!function_exists('nowLocal')) {
    function nowLocal() {
        return \Illuminate\Support\Carbon::now(config('app.local_timezone'));
    }
}
