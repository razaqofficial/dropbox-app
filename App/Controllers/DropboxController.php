<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

class DropboxController extends Controller {

    public function index(): void
    {
        //echo redirectTo();
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://api.dropboxapi.com/2/files/list_folder");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CAINFO, "cacert.pem");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"path\":\"/entermotion\"}");
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = [
            "Content-Type: application/json",
            "Authorization: Bearer ". getenv('ACCESS_TOKEN')
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

        $json = json_decode($result, true);
        $items =$json['entries'];

        View::render("home", ["items" => $items]);
    }

    /**
     * @return mixed|null
     */
    public function download()
    {
        $fileName = $_GET['file_name'];
        $out_filepath = \Config\Application::DOWNLOAD_FOLDER . "/{$fileName}";
        $out_fp = fopen($out_filepath, 'w+');
        if ($out_fp === FALSE)
        {
            echo "fopen error; can't open $out_filepath\n";
            return (NULL);
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://content.dropboxapi.com/2/files/download");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CAINFO, "cacert.pem");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"path\":\"/entermotion\"}");
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = [
            "Content-Type:",
            "Authorization: Bearer ". getenv('ACCESS_TOKEN'),
            'Dropbox-API-Arg: {"path":"' . "/entermotion/{$fileName}" . '"}'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FILE, $out_fp);

        $metadata = null;
        curl_setopt($ch, CURLOPT_HEADERFUNCTION, function ($ch, $header) use (&$metadata)
        {
            $prefix = 'dropbox-api-result:';
            if (strtolower(substr($header, 0, strlen($prefix))) === $prefix)
            {
                $metadata = json_decode(substr($header, strlen($prefix)), true);
            }
            return strlen($header);
        }
        );

        $output = curl_exec($ch);

        if ($output === FALSE)
        {
            echo "curl error: " . curl_error($ch);
        }

        curl_close($ch);
        fclose($out_fp);
        return($metadata);
    }
    

}