<script type="text/javascript">
    $(document).ready(function () {
        @if(session()->has('noti'))
        @foreach(session('noti') as $key => $value)
        $.notify('{{$value}}', '{{$key}}');
        @endforeach
        @endif
    })
</script>
