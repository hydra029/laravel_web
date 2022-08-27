function notifyError (message = '') {
    $.toast({
        heading        : 'Something went wrong',
        text           : message,
        icon           : 'error',
        position       : 'top-right',
        hideAfter      : 2000,
        allowToastClose: false,
    });
}
function notifySuccess (message = '') {
    $.toast({
        heading        : 'Successful Execution',
        text           : message,
        icon           : 'success',
        position       : 'top-right',
        hideAfter      : 2000,
        allowToastClose: false,
    });
}