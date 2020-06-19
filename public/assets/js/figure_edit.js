var $container = $('.video-block');
$container.find('a').on('click', function(e) {
    e.preventDefault();
    var $link = $(e.currentTarget);
    $.ajax({
        url: '/videos/'+$link.data('title')+'/remove',
        method: 'POST'
    }).then(function(data) {
        $container.remove();
    });
});