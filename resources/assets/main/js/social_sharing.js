(function() {
    function popupCenter(url, title, w, h) {
        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }

        return false;
    }

    $(document).on('click', '[data-share-to-linkedin]', function(event) {
        event.preventDefault();
        var attrs = $(event.currentTarget).data('share-to-linkedin');
        if (attrs && attrs.url) {
            var shareUrl = "https://www.linkedin.com/shareArticle?mini=true&url="+encodeURIComponent(attrs.url);
            return popupCenter(shareUrl,null,570,520);
        }
    });

    $(document).on('click', '[data-share-to-weibo]', function(event) {
        event.preventDefault();
        var attrs = $(event.currentTarget).data('share-to-weibo');
        if (attrs && attrs.url) {
            var title = attrs.title ? attrs.title: "";
            var shareUrl = "http://v.t.sina.com.cn/share/share.php?url="+encodeURIComponent(attrs.url)+"&title="+encodeURIComponent(title);
            return popupCenter(shareUrl,null,570,520);
        }
    });
})();