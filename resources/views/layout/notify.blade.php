<script>
    $(document).ready(function () {
        if ({{!session('error')}}) {
            $.notify('{{session('error')}}', 'error');
            {{session()-> forget('error')}};
        }
        if ({{!session('success')}}) {
            $.notify('{{session('success')}}', 'success');
            {{session()-> forget('success')}};
        }
        if ({{!session('info')}}) {
            $.notify('{{session('info')}}', 'info');
            {{session()-> forget('info')}};
        }
        if ({{!session('warning')}}) {
            $.notify('{{session('warning')}}', 'warning');
            {{session()-> forget('warning')}};
        }
    })
</script>