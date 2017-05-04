$(document).ready(function() {
    $('.loader').hide()

    $(document).on('pjax:send', function() {
        $('.loader').show()
    })
    $(document).on('pjax:success', function() {
        $('.loader').hide()
    })
});
