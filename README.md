# flickr

This is a very simple PHP class to use the Flickr API service to get your own photostream or photoset.

#How to use?

$f = new Flickr($api);
$f->getPhotos($opt)->render(new Pagination($f->getPages()));

