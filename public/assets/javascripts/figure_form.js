var $videosCollectionHolder;
var $picturesCollectionHolder;

var $addPictureButton = $('<button type="button" class="button is-success is-light is-outlined add_picture_link"><i class="fas fa-plus"></i>Ajouter une image<i class="fas fa-image"></i></button>');
var $newPictureLinkLi = $('<li></li>').append($addPictureButton);

var $addVideoButton = $('<button type="button" class="button is-success is-light is-outlined add_video_link"><i class="fas fa-plus"></i>Ajouter une vidéo<i class="fab fa-youtube"></i></button>');
var $newVideoLinkLi = $('<li></li>').append($addVideoButton);

jQuery(document).ready(function() {

    $picturesCollectionHolder = $('ul.pictures');
    $videosCollectionHolder = $('ul.videos');

    $picturesCollectionHolder.append($newPictureLinkLi);
    $videosCollectionHolder.append($newVideoLinkLi);

    $picturesCollectionHolder.data('index', $picturesCollectionHolder.find('input').length);
    $videosCollectionHolder.data('index', $videosCollectionHolder.find(':input').length);

    $addPictureButton.on('click', function(e) {
        addPictureForm($picturesCollectionHolder, $newPictureLinkLi);
    });

    $addVideoButton.on('click', function() {
        addVideoForm($videosCollectionHolder, $newVideoLinkLi);
    });
    /*
    $picturesCollectionHolder.find('li').each(function() {
        addPictureFormDeleteLink($(this));
    });

    $videosCollectionHolder.find('li').each(function() {
        addVideoFormDeleteLink($(this));
    });*/
});

function addPictureForm($picturesCollectionHolder, $newPictureLinkLi) {

    var prototype = $picturesCollectionHolder.data('prototype');

    var index = $picturesCollectionHolder.data('index');

    var newPictureForm = prototype;

    newPictureForm = newPictureForm.replace(/__name__/g, index);

    $picturesCollectionHolder.data('index', index + 1);

    var $newPictureFormLi = $('<li></li>').append(newPictureForm);
    $newPictureLinkLi.before($newPictureFormLi);
    addPictureFormDeleteLink($newPictureFormLi);
}

function addVideoForm($videosCollectionHolder, $newVideoLinkLi) {

    var prototype = $videosCollectionHolder.data('prototype');

    var index = $videosCollectionHolder.data('index');

    var newVideoForm = prototype;

    $videosCollectionHolder.data('index', index + 1);

    var $newVideoFormLi = $('<li></li>').append(newVideoForm);
    $newVideoLinkLi.before($newVideoFormLi);
    addVideoFormDeleteLink($newVideoFormLi);
}

function addPictureFormDeleteLink($pictureFormLi) {
    var $removePictureFormButton = $('<button type="button" class="button is-danger is-light is-outlined">Delete this picture</button>');
    $pictureFormLi.append($removePictureFormButton);

    $removePictureFormButton.on('click', function(e) {
        $pictureFormLi.remove();
    });
}

function addVideoFormDeleteLink($videoFormLi) {
    var $removeVideoFormButton = $('<button type="button" class="button is-danger is-light is-outlined">Delete this video</button>');
    $videoFormLi.append($removeVideoFormButton);

    $removeVideoFormButton.on('click', function(e) {
        $videoFormLi.remove();
    });
}
