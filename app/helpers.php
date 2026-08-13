<?php

if (! function_exists('tenant_storage_url')) {
    function tenant_storage_url(?string $path): ?string
    {
        return $path ? tenant_asset($path) : null;
    }
}
