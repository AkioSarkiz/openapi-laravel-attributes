<?php

return [

    /*
     |------------------------------------------------------------------------
     | Scan paths.
     |------------------------------------------------------------------------
     |
     | These paths will be used to scan files. By default, this is your application directory.
     | But you can add custom directories.
     |
     */

    'scan_paths' => [
        app_path(),
    ],

    /*
     |------------------------------------------------------------------------
     | Save path.
     |------------------------------------------------------------------------
     |
     | The path where the open api documentation file will be saved.
     | Saving works through a local drive.
     |
     */

    'save_path' => 'openapi/docs.json',

];
