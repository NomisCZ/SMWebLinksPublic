@isset($url)

    <script type="text/javascript">

        var $dimensions = {

            height: screen.availHeight,
            width: screen.availWidth
        };

        window.open("{{ $url }}", "_blank", "toolbar=yes, scrollbars=yes, width=" + $dimensions.width + ", height="  + $dimensions.height);
    </script>
@endisset