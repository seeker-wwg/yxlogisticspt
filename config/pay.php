<?php

return [
    'alipay' => [
        // 支付宝分配的 APPID
        'app_id' => '2016091100486806',
        // 支付宝异步通知地址
        'notify_url' => 'http://www.yxlogisticspt.com/admin/pay/notify_url',
        // 支付成功后同步通知地址
        'return_url' => 'http://www.yxlogisticspt.com/admin/pay/return_url',
//        //支付宝网关
//        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
        // 阿里公共密钥，验证签名时使用
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAynD/xJol6OpoMwXcGOvYXUA5efuKzC1hy3IBMwoLUJMvaZeoV/oE6p4r+KVN+rzXAE7GYCeXRYiU2CHpfgqpQfc1XuOz09UeZ0vL0tJXlKT+s0cqAV+Vp1l0u4+nC4EiqwGXCO5cigB3+x/Aq54MA/Rpo9ByZpLDRe2Qx6ouaIxb0S/iezgyoqbzr3n1BAUxcXnw/XC999HbyfQmcZXOT8LZcn/Ulpf2HU9Yl1Z7Gm7UFkIclhWx38nwJXm6J0CWZQNLsZQgYE7T3lYZByDE5xfE4DYqU6SdMwHG+yHi/MeU8q6I9GlDCHoJvsTU9+wwPmDZJzawa/mTaKvgL5lcBwIDAQAB',

        // 自己的私钥，签名时使用
        'private_key' => 'MIIEowIBAAKCAQEAyK3/DtI6kuWWrkazGM0ANcVKquqoL5jSxrjpZIJ4yr3qS33sipAWOBydez0vJD6GaZpxMnpKS30loK2h7XpGuhHe6l9amhFxHBFpxCNsYZo8VwZgWv65cT4tF6utegA5Ww6GpQnkYGkhzxmlcr1RUeQmX8SnrYz8PejDxswFm4lpEZklKrqP2wKNeUcPyXaZQM1Q2bIXUXYVWoQKkWRcq8BF3TCig8+RZLuf5j8bl+UXBb00+Vo+y9Y140aM2X0jR9HWyw0m297oUE8hVNdzNoitCbz2GXWoyENeEdSt7AWJPAZDaU/fLarBDG11lXuaBH4h3R614CKI09ISh/8HDwIDAQABAoIBAHfmHWHJkV169tAhRZgnw1xdCAOeN+ZYNHauvCNlIK5hUb7Q+aa/98aGskCTibrp8Hzf3Yn/LqxzlSuvEfRE/kTlsH3vgr5SdXYDoWGimHqoIC0OjjtPvZQ/RcnCtN8TizEwOJoakuxXY+/MruEi45c97P+DC3vRpFOI4o/ADgmiuzMrzM3Xv1wFftDpo3rhfJoaQfnDZL3cD4szxTzp72fJAEFt0MU4cUr/GwzP93dHjrVx+inSHl0e5D7Z/ucPtVSkXG1h0FbDeolbiCtw2X5/yUacZMgq2F72dOQdNirTttSh8p0sEILwMyiAredOwAB1kIeJSaOoPEib/XY4/gECgYEA/UvxNxqshjC70HLsPGj7VDlZBWbhR5yOSgmXZBcSTPTBe3O9NudpjvFW3nKVnetCr07ZpZOQPZi4+uEXtUiuRn7CTHn199aE0wH6JOhrTqbjYlmsSraabWYUXKX5mld/hvn4aenkbujl89SC5tcRoFHbuO66FpeRzjrqtCUWqk8CgYEAytJLONHqH5um4UgY8l0F7g0INXRm6AUHgdWY1LWwx/gcUNeqy6WLLlZPZwT3yZ/GKvUMGRaSzAm728CUYMb6PueYTqcxnKU+xbHGFSTJNgI1Vlyn9i04ser3GA1NofNJCcLmIUOXzqF/lxsSZa+Az3fBp6LUIDSmzSjXbb/IZ0ECgYBmuuo2Ayd9tT43KKUPSzTD0A5+1l8AAErlVEaGXaUaeRoPy70uC2UQiGlHBwoPZl9BYqV7NgIGOW6ssaY/7B5ikP6UrdJIlkSAoAin92uuFpmaRexO0QiI3iHcAaTeKCacw70wl6ACK4s3/TSqEwgfEZQfyRLIHukPz21parFqmQKBgQDKRHq8CawhJYuBs/MdEWQuiVScap+N2CYqdyfZSfEpG+ixPsOYIFnzNiQtqyiqLOrmQEd2Zaq0TSjJ+P6AnS9HuJOOLPMvMySs56ORxoPblsw2emUO/v5BgQA3Pl0jm4pFb9ctaUllym2B9n+cZTBitx2r3pkKHTgT9h0R2Gc1gQKBgE4HaVVIA+PYktlAQ2Z6qevocCG0ujGHWa0xT794tkG94HnsD8L540Uodz+UlkDPuUkuu9N/4ymFPmwttbaDPQalySXYy17KiNShDt2svK+K1QdOWAVqOAH4pNw3/78NM0ZplktfgHknFftFR04NFZF5xZSPJ8NPLqUmqRepIJP6',
    ],

    'wechat' => [
        // 公众号APPID
        'app_id' => 'wx8430c9847053b3ec',

        // 小程序APPID
        'miniapp_id' => '',

        // APP 引用的 appid
        'appid' => 'wx7e754accbe087648',

        // 微信支付分配的微信商户号
        'mch_id' => '1338283501',

        // 微信支付异步通知地址
        'notify_url' => 'http://56.xizangyaxiangwuliu.com/admin/wechat/notify',



        // 微信支付签名秘钥
        'key' => 'Yaxiangwuliu15076447777Yaxiangwu',

        // 客户端证书路径，退款时需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_client' => 'G:\MyProject\yxlogisticspt\public\cert\apiclient_cert.pem',

        // 客户端秘钥路径，退款时需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_key' => 'G:\MyProject\yxlogisticspt\public\cert\apiclient_key.pem',
    ],
];
