@isset($requestData)

    <script type="text/javascript">

        var $dimensions = {

            height: screen.availHeight,
            width: screen.availWidth
        };

        function getDimensions($params) {

            $params = $params.split(',');

            return {
                height: $params[0].split('=')[1],
                width: $params[1].split('=')[1]
            };
        }

        @if ($requestData->customParams != 'normal')
            $dimensions = getDimensions('{{ $requestData->customParams }}');
        @endif

        window.open("{{ $requestData->url }}", "_blank", "toolbar=yes, scrollbars=yes, width=" + $dimensions.width + ", height="  + $dimensions.height);

    </script>
@endisset