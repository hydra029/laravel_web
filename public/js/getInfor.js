
function SetUserName()
{


    var currentUrl = document.location.href;
    console.log(currentUrl);
    var url;
    switch (level) {
        case '4':
            url = "{{ route('ceo.get_infor') }}";
            break;
    }

    $('#get-infor').attr('href', `{{ route('ceo.get_infor') }}`);
}

