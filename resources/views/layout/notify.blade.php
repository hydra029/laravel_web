<script type="text/javascript">
    $(document).ready(function () {
        @if(session('noti'))
        $.toast({
            heading: '{{session('noti')['heading']}}',
            text: '{{session('noti')['text']}}',
            icon: '{{session('noti')['icon']}}',
            showHideTransition: 'slide',
            allowToastClose: false,
            hideAfter: 3000,
            stack: 5,
            position: 'top-right',
            textAlign: 'left',
            loader: true,
        });
        @endif
    })
</script>
