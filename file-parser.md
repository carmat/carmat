File name format:   [date]-[url_path].md

Example:            20170108-2017-roadmap.md

Parses to:
    20170108        => Article publish date [yyyy mm dd]
    2017-roadmap    => "http://carm.at/2017-roadmap"
                    => "http://colmmorgan.com/2017-roadmap"

File contents, with examples:
    Title: 2017 Roadmap
    Publish Status: Published
    Description: A short description of the article, a kind-of TL;DR but without the spoiler.
    Keywords: roadmap, new years resolution, self-learning, procrastination
    Tags: roadmap, procrastination

Parser method - pseudocode:
    ```php
        function parseFile( filename ) {

            $date
            // first 8 chars of filename

            $urlPath
            // everything after the date and first '-', ending before the first '.'

            $filetype
            // everything after the last '.'

            $title
            // everything after 'title:' (strtolower), trim the value of leading and trailing spaces

            $status
            // everything after 'status:' (strtolower), trim the value of leading and trailing spaces, must be one of "unpublished, published, archived, deleted", defaults to "unpublished" if no match

            $desc
            // if exists, everything after 'desc:' or 'description:' (strtolower), trim the value of leading and trailing spaces

            $keywords
            // if exists, everything after 'keywords:' (strtolower), trim the value of leading and trailing spaces, split list by ','

            $tags
            // if exists, everything after 'tags:' (strtolower), trim the value of leading and trailing spaces, split list by ','

        }
    ```

    From here, I'm thinking a JSON object will be created per article. A collection of these articles will form part of an API request containing some other meta data.
