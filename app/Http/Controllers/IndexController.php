<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

// use Illuminate\Foundation\Bus\DispatchesJobs;
// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IndexController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index() {
        $posts = [];
        $pathToPosts = resource_path('posts/');

        $files = $this->getFiles( $pathToPosts );

        foreach ($files as $post) {
            $p = new \stdClass();
            $file = $pathToPosts . $post;

            $p->filename = $post;
            $p->title = $this->getTitleFromPost($file);
            $p->status = $this->getStatusFromPost($file);
            $p->desc = $this->getMetaDescriptionFromPost($file);
            $p->keywords = $this->getMetaKeywordsFromPost($file);
            $p->tags = $this->getTagsFromPost($file);

            array_push($posts, $p);
        }
        $posts = (object) $posts;

        return view('home.index', compact('posts'));
    }

    public function getFiles( $directory ) {
        $files = array_diff( scandir($directory, SCANDIR_SORT_DESCENDING), array('.', '..') );

        return $files;
    }

    public function getTitleFromPost( $filename ) {
        return trim( str_replace( '@title:', '', fgets( fopen($filename, "r") ) ) );
    }

    public function getStatusFromPost( $filename ) {
        return trim( str_replace( '@status:', '', fgets( fopen($filename, "r") ) ) );
    }

    public function getMetaDescriptionFromPost( $filename ) {
        return trim( str_replace( '@description:', '', fgets( fopen($filename, "r") ) ) );
    }

    public function getMetaKeywordsFromPost( $filename ) {
        return trim( str_replace( '@keywords:', '', fgets( fopen($filename, "r") ) ) );
    }

    public function getTagsFromPost( $filename ) {
        return trim( str_replace( '@tags:', '', fgets( fopen($filename, "r") ) ) );
    }

    public function parsePost( $filename ) {}

}
