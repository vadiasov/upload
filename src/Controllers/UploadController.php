<?php

namespace Vadiasov\Upload\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function upload($config, $albumId)
    {
        Log::debug('Upload. 1.');
        $active        = 'upload';
        $user          = Auth::user();
        $config        = config($config);
        $path          = $config['path'];
        $url           = $config['rules']['url'];
        $acceptedFiles = $config['rules']['acceptedFiles'];
        $maxFilesize   = $config['rules']['maxFilesize'];
        $backUrl       = $config['backUrl'];
        
        return view('upload::upload', compact(
            'active',
            'user',
            'path',
            'url',
            'acceptedFiles',
            'maxFilesize',
            'backUrl'
        ));
    }
    
    public function store(Request $request)
    {
        $path = $request->path;
        Log::debug('store. 1.');
        Log::debug($_FILES);
        $ds = DIRECTORY_SEPARATOR;  //1
        
        $storeFolder = storage_path() . $path;   //2
        Log::debug($storeFolder);
        
        if (!empty($_FILES)) {

//            $file = $_FILES['file'];          //3
            $tempFile = $_FILES['file']['tmp_name'];          //3
            Log::debug($tempFile);

//            $targetPath = dirname(__FILE__) . $ds . $storeFolder . $ds;  //4

//            $targetFile = $targetPath . $_FILES['file']['name'];  //5
            $targetFile = $storeFolder . $_FILES['file']['name'];  //5
            Log::debug($targetFile);
            
            move_uploaded_file($tempFile, $targetFile); //6
//            $targetFile->store('tracks');
//            $file->store('tracks');
        }

//            $tmp_name = $_FILES["file"]["tmp_name"][0];
        // basename() может предотвратить атаку на файловую систему;
        // может быть целесообразным дополнительно проверить имя файла
//            $name = basename($_FILES["file"]["name"][$key]);
//                move_uploaded_file($tmp_name, "$uploads_dir/$name");
//            move_uploaded_file($tmp_name, $storeFolder . "/1.png");
//        $file = $_FILES['file'][0];
//        $file->store('tracks');
        
    }
    
}
