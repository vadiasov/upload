<?php

namespace Vadiasov\Upload\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UploadController extends Controller
{
    public function upload($config, $albumId)
    {
        Log::debug('Upload. 1.');
        $active             = 'upload';
        $user               = Auth::user();
        $config             = config($config);
        $path               = $config['path'];
        $url                = $config['rules']['url'];
        $acceptedFiles      = $config['rules']['acceptedFiles'];
        $maxFilesize        = $config['rules']['maxFilesize'];
        $backUrl            = $config['backUrl'];
        $table              = $config['db_table'];
        $id_item            = $config['id_item'];
        $column             = $config['column'];
        $header             = $config['header'];
        $parent_table       = $config['parent_table'];
        $parent_column_name = $config['parent_column_name'];
        $title = DB::table($parent_table)
            ->whereId($albumId)
            ->first()
            ->title;
        
        return view('upload::upload', compact(
            'active',
            'user',
            'path',
            'url',
            'acceptedFiles',
            'maxFilesize',
            'backUrl',
            'table',
            'column',
            'id_item',
            'albumId',
            'header',
            'title'
        ));
    }
    
    public function store(Request $request)
    {
        $path    = $request->path;
        $table   = $request->table;
        $column  = $request->column;
        $id_item = $request->id_item;
        $albumId = $request->albumId;
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

//            $targetFile = $storeFolder . $_FILES['file']['name'];  //5
            $path         = $_FILES['file']['name'];
            $ext          = pathinfo($path, PATHINFO_EXTENSION);
            $randomString = $this->generateRandomString(3);
            $fileName     = date('Y-m-d_h-i-s--') . $randomString . ('.') . $ext;
            $targetFile   = $storeFolder . $fileName;
//            $targetFile = $storeFolder . $_FILES['file']['name'];  //5
            Log::debug($targetFile);
            
            move_uploaded_file($tempFile, $targetFile); //6
//            $targetFile->store('tracks');
//            $file->store('tracks');
            $result = $this->saveInDb($table, $column, $id_item, $albumId, $fileName);
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
    
    private function generateRandomString($length = 10)
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString     = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        return $randomString;
    }
    
    private function saveInDb($table, $column, $id_item, $id, $fileName)
    {
        DB::table($table)->insert([
            [
                $id_item => $id,
                $column  => $fileName,
            ],
        ]);
        
    }
    
}
