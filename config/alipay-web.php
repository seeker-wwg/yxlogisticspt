<?php
/**
 * Created by PhpStorm.
 * User: luojinyi
 * Date: 2017/6/26
 * Time: 下午5:21
 */

return [
    //应用ID,您的APPID。
    'app_id' => "2016091100486806",

    //商户私钥 不能用pkcs8.pem中的密钥！！！！！
    'merchant_private_key' => "MIIEowIBAAKCAQEAyK3/DtI6kuWWrkazGM0ANcVKquqoL5jSxrjpZIJ4yr3qS33sipAWOBydez0vJD6GaZpxMnpKS30loK2h7XpGuhHe6l9amhFxHBFpxCNsYZo8VwZgWv65cT4tF6utegA5Ww6GpQnkYGkhzxmlcr1RUeQmX8SnrYz8PejDxswFm4lpEZklKrqP2wKNeUcPyXaZQM1Q2bIXUXYVWoQKkWRcq8BF3TCig8+RZLuf5j8bl+UXBb00+Vo+y9Y140aM2X0jR9HWyw0m297oUE8hVNdzNoitCbz2GXWoyENeEdSt7AWJPAZDaU/fLarBDG11lXuaBH4h3R614CKI09ISh/8HDwIDAQABAoIBAHfmHWHJkV169tAhRZgnw1xdCAOeN+ZYNHauvCNlIK5hUb7Q+aa/98aGskCTibrp8Hzf3Yn/LqxzlSuvEfRE/kTlsH3vgr5SdXYDoWGimHqoIC0OjjtPvZQ/RcnCtN8TizEwOJoakuxXY+/MruEi45c97P+DC3vRpFOI4o/ADgmiuzMrzM3Xv1wFftDpo3rhfJoaQfnDZL3cD4szxTzp72fJAEFt0MU4cUr/GwzP93dHjrVx+inSHl0e5D7Z/ucPtVSkXG1h0FbDeolbiCtw2X5/yUacZMgq2F72dOQdNirTttSh8p0sEILwMyiAredOwAB1kIeJSaOoPEib/XY4/gECgYEA/UvxNxqshjC70HLsPGj7VDlZBWbhR5yOSgmXZBcSTPTBe3O9NudpjvFW3nKVnetCr07ZpZOQPZi4+uEXtUiuRn7CTHn199aE0wH6JOhrTqbjYlmsSraabWYUXKX5mld/hvn4aenkbujl89SC5tcRoFHbuO66FpeRzjrqtCUWqk8CgYEAytJLONHqH5um4UgY8l0F7g0INXRm6AUHgdWY1LWwx/gcUNeqy6WLLlZPZwT3yZ/GKvUMGRaSzAm728CUYMb6PueYTqcxnKU+xbHGFSTJNgI1Vlyn9i04ser3GA1NofNJCcLmIUOXzqF/lxsSZa+Az3fBp6LUIDSmzSjXbb/IZ0ECgYBmuuo2Ayd9tT43KKUPSzTD0A5+1l8AAErlVEaGXaUaeRoPy70uC2UQiGlHBwoPZl9BYqV7NgIGOW6ssaY/7B5ikP6UrdJIlkSAoAin92uuFpmaRexO0QiI3iHcAaTeKCacw70wl6ACK4s3/TSqEwgfEZQfyRLIHukPz21parFqmQKBgQDKRHq8CawhJYuBs/MdEWQuiVScap+N2CYqdyfZSfEpG+ixPsOYIFnzNiQtqyiqLOrmQEd2Zaq0TSjJ+P6AnS9HuJOOLPMvMySs56ORxoPblsw2emUO/v5BgQA3Pl0jm4pFb9ctaUllym2B9n+cZTBitx2r3pkKHTgT9h0R2Gc1gQKBgE4HaVVIA+PYktlAQ2Z6qevocCG0ujGHWa0xT794tkG94HnsD8L540Uodz+UlkDPuUkuu9N/4ymFPmwttbaDPQalySXYy17KiNShDt2svK+K1QdOWAVqOAH4pNw3/78NM0ZplktfgHknFftFR04NFZF5xZSPJ8NPLqUmqRepIJP6",

    //异步通知地址post
    'notify_url' => "http://www.yxlogisticspt.com/admin/shop/notify_url",

    //同步跳转get
    'return_url' => "http://www.yxlogisticspt.com/admin/shop/return_url",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type' => "RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAynD/xJol6OpoMwXcGOvYXUA5efuKzC1hy3IBMwoLUJMvaZeoV/oE6p4r+KVN+rzXAE7GYCeXRYiU2CHpfgqpQfc1XuOz09UeZ0vL0tJXlKT+s0cqAV+Vp1l0u4+nC4EiqwGXCO5cigB3+x/Aq54MA/Rpo9ByZpLDRe2Qx6ouaIxb0S/iezgyoqbzr3n1BAUxcXnw/XC999HbyfQmcZXOT8LZcn/Ulpf2HU9Yl1Z7Gm7UFkIclhWx38nwJXm6J0CWZQNLsZQgYE7T3lYZByDE5xfE4DYqU6SdMwHG+yHi/MeU8q6I9GlDCHoJvsTU9+wwPmDZJzawa/mTaKvgL5lcBwIDAQAB",

    //支付时提交方式 true 为表单提交方式成功后跳转到return_url,
    //false 时为Curl方式 返回支付宝支付页面址址 自己跳转上去 支付成功不会跳转到return_url上， 我也不知道为什么，有人发现可以跳转请告诉 我一下 谢谢
    // email: 40281612@qq.com
    'trade_pay_type' => true,
];