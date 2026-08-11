let $tabs = $('a.list-group-item')
    $tabs.click(function(){
    var $t = $(this);
    $tabs.removeClass('active');
    $t.addClass('active');
    $('#div-right > div').hide();
    $('#div-right > div').filter("." + $t.attr('data-tabs-id')).show();
});