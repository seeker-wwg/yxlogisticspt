<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>判断手机</title>
</head>
<body>
<a href="javascript:testApp('weixin://')" class="dl-btn" id="download">打开微信</a>
<script>
    function testApp(url) {
        var timeout, t = 1000, hasApp = true;
        setTimeout(function () {
            if (!hasApp) {
                //没有安装微信
                var r=confirm("您没有安装微信，请先安装微信!");
                if (r==true){
                    location.href="http://weixin.qq.com/"
                }
            }else{
                //安装微信
            }
            document.body.removeChild(ifr);
        }, 2000)

        var t1 = Date.now();
        var ifr = document.createElement("iframe");
        ifr.setAttribute('src', url);
        ifr.setAttribute('style', 'display:none');
        document.body.appendChild(ifr);
        timeout = setTimeout(function () {
            var t2 = Date.now();
            if (!t1 || t2 - t1 < t + 100) {
                hasApp = false;
            }
        }, t);
    }
    // if(!/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent) && / baiduboxapp/i.test(navigator.userAgent)){
    //
    //     window.location.replace('bdbox://utils?action=sendIntent&minver=7.4¶ms=%7B%22intent%22%3A%22weixin%3A%2F%2Fdl%2Fbusiness%2F%3Fticket%3D44545452742d%23wechat_redirect%23Intent%3Bend%22%7D');
    // }else{
    //     window.location.replace('weixin://dl/business/?ticket=tbc3944557c48f8763962742d#wechat_redirect');
    //     window.location.replace('weixin://wxpay/bizpayurl?pr=X1P6x2c');
    // }
    // setTimeout(function(){document.getElementById("loading").style.display="none";},3000);


</script>
</body>
</html>