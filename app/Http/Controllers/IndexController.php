<?php

namespace App\Http\Controllers;

use \DateTime as DateTime;

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

            $p->filename = $post;
            $p->publishDate = $this->getPublishDateFromPostFilename($p->filename);
            $p->pathName = $this->getPathNameFromPostFilename($p->filename);

            $p->title = $this->getTitleFromPost($file);
            $p->status = $this->getStatusFromPost($file);
            $p->desc = $this->getMetaDescriptionFromPost($file);
            $p->keywords = $this->getMetaKeywordsFromPost($file);
            $p->tags = $this->getTagsFromPost($file);

            fclose($file);

            array_push($posts, $p);
        }
        $posts = (object) $posts;

        return view('home.index', compact('posts'));
    }

    public function getFiles( $directory ) {
        $files = array_diff( scandir($directory, SCANDIR_SORT_DESCENDING), array('.', '..') );

        return $files;
    }

    public function getPublishDateFromPostFilename( $filename ) {
        // Begin from the start of the file name.
        // Pull the first eight characters.
        // i.e. yyyymmdd
        $__extraction = substr( $filename, 0, 8 );

        $date = new DateTime( $__extraction );
        $date = $date->format( "F jS, 'y" );

        return $date;
    }

    public function getPathNameFromPostFilename( $filename ) {
        // Begin after the eight-character date and the separating hyphen.
        // Pull the entire string, excluding the final three characters.
        // Exlcuding the final three characters with the assumpton they
        // will be the Markdown file extension i.e. ".md"
        $path = substr( $filename, 9, -3 );

        return $path;
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
