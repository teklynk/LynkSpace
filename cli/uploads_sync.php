#!/usr/bin/php
<?php
define( 'ALLOW_INC', true );

require_once (__DIR__ . '/../config/config.php');
require_once (__DIR__ . '/../htdocs/admin/core/admin-functions.php');

$uploadsPath = __DIR__ . '/../htdocs/uploads';

$uploadsArray = dirToArray($uploadsPath, array('.gitkeep'));

$sqlUploads = mysqli_query( $db_conn, "SELECT * FROM uploads;" );
$rowUploads = mysqli_fetch_array( $sqlUploads, MYSQLI_ASSOC );

//var_dump($rowUploads['orig_file_name']);
//die();


//TODO: scan sub directories. get folder name/number and use that as a variable for loc_id. foreach sub directory...


foreach ($uploadsArray as $upload) {
    if (!in_array($upload, (array)$rowUploads['orig_file_name'])) {

        //Get file info
        $fileExt       = strtolower( pathinfo( $uploadsPath . '/' . $upload, PATHINFO_EXTENSION ) ) ?: null;
        $fileName      = strtolower( pathinfo( $uploadsPath . '/' . $upload, PATHINFO_BASENAME ) ) ?: null;
        $fileMime      = strtolower( mime_content_type( $uploadsPath . '/' . $upload ) ) ?: null;
        $fileSize      = filesize( $uploadsPath . '/' . $upload) ?: null;

        $sqlInsertUploads = "INSERT INTO uploads (type, type_id, file_name, orig_file_name, file_data, file_ext, file_mime, file_size, author_name, guid, datetime, loc_id) VALUES ('" . $type . "', " . $type_id . ", '" . $fileName . "', '" . $upload . "', '" . $fileData . "', '" . $fileExt . "', '" . $fileMime . "', " . $fileSize . ", '" . $user . "', '" . getGuid() . "', '" . date( "Y-m-d H:i:s" ) . "', " . loc_id . ");";
        //mysqli_query( $db_conn, $sqlInsertUploads );

        echo $sqlInsertUploads;
    }
}
?>