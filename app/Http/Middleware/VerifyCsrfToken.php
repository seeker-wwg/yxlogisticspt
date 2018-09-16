<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'alipay/*',
        'admin/manager/*',
        'admin/user/*',
        'admin/driver/*',
        'admin/trucks/*',
        'admin/car/*',
        'admin/region/*',
        'admin/freight/*',
        'admin/price/*',
        'admin/msg/*',
        'admin/banner/*',
        'admin/field/*',
        'admin/article/*',
        'admin/order/*',
        'admin/shop/*',
        'admin/role/*',
        'admin/permission/*',
        'admin/upload/*',
        'admin/jia/mi',
        'http://example.com/foo/*',

    ];
}
