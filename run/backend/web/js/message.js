$(function(){
    var classids = $('.classids').val();
    var classArr = classids.split(',');
    $(classArr).each(function(index, el) {
        $('#message-classids input[value="'+el+'"]').attr('checked', 'checked');
    });
})
$('#message-classids input').each(function(index, el) {
    $(this).on('click', function() {
        if ($(this).hasClass('alluser')) {
            $('#message-classids input.item:checked').removeAttr('checked');
        } else if ($(this).hasClass('allclass')) {
            $('#message-classids input.classitem:checked').removeAttr('checked');
        } else {
            $('#message-classids input.all:checked').removeAttr('checked');
        }
    });
});