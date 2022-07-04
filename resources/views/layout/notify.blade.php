<script>
    $(document).ready(function () {
        if ({{session()->has('error')}}) {
            $.notify('{{session('error')}}', 'error');
        }
        if ({{session()->has('success')}}) {
            console.log('123');
            $.notify('{{session('success')}}', 'success');
        }
        if ({{!session('info')}}) {
            $.notify('{{session('info')}}', 'info');
        }
        if ({{!session('warning')}}) {
            $.notify('{{session('warning')}}', 'warning');
        }
    })
</script>
