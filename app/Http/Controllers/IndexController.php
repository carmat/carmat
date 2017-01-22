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
            $file = fopen($pathToPosts . $post, "r");

            // dd( file_get_contents($file) );

            $p->filename = $post;
            $p->title = $this->getTitleFromPost($file);
            $p->status = $this->getStatusFromPost($file);
            $p->desc = $this->getMetaDescriptionFromPost($file);
            $p->keywords = $this->getMetaKeywordsFromPost($file);
            $p->tags = $this->getTagsFromPost($file);

            fclose( $file );

            array_push($posts, $p);
        }
        $posts = (object) $posts;

        return view('home.index', compact('posts'));
    }

    public function getFiles( $directory ) {
        $files = array_diff( scandir($directory, SCANDIR_SORT_DESCENDING), array('.', '..') );

        return $files;
    }

    public function getTitleFromPost( $post ) {
        $data = trim( str_replace( '@title:', '', fgets( $post ) ) );

        return $data;
    }

    public function getStatusFromPost( $post ) {
        $data = trim( str_replace( '@status:', '', fgets( $post ) ) );

        return $data;
    }

    public function getMetaDescriptionFromPost( $post ) {
        $data = trim( str_replace( '@description:', '', fgets( $post ) ) );

        return $data;
    }

    public function getMetaKeywordsFromPost( $post ) {
        $data = trim( str_replace( '@keywords:', '', fgets( $post ) ) );

        return $data;
    }

    public function getTagsFromPost( $post ) {
        $data = trim( str_replace( '@tags:', '', fgets( $post ) ) );

        return $data;
    }

    public function parsePost( $filename ) {}

}
