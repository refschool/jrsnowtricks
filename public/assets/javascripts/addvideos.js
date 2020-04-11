var $collectionHolder;

// setup an "add a video" link
var $addVideoButton = $('<button type="button" class="button is-danger is-outlined add_video_link"><i class="fas fa-plus"></i><b>Ajouter une vidéo</b><i class="fab fa-youtube"></i></button>');
var $newLinkLi = $('<li></li>').append($addVideoButton);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of videos
    $collectionHolder = $('ul.videos');

    // add the "add a video" anchor and li to the videos ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addVideoButton.on('click', function() {
        // add a new video form (see next code block)
        addVideoForm($collectionHolder, $newLinkLi);
    });
});

function addVideoForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a video" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
}