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
        $active        = 'upload';
        $user          = Auth::user();
        $config        = config($config);
        $path          = $config['path'];
        $url           = $config['rules']['url'];
        $acceptedFiles = $config['rules']['acceptedFiles'];
        $maxFilesize   = $config['rules']['maxFilesize'];
        $backUrl       = $config['backUrl'];
//        $backUrl            = $this->processUrl($backUrl, $albumId);
        $table              = $config['db_table'];
        $id_item            = $config['id_item'];
        $column             = $config['column'];
        $header             = $config['header'];
        $parent_table       = $config['parent_table'];
        $parent_column_name = $config['parent_column_name'];
        $title              = DB::table($parent_table)
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
    
    public function upload2($config, $albumId, $trackId)
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
//        $backUrl            = $this->processUrl($backUrl, $albumId);
        $table              = $config['db_table'];
        $id_item            = $config['id_item'];
        $id_item_2          = $config['id_item_2'];
        $column             = $config['column'];
        $pageHeader         = $config['pageHeader'];
        $header             = $config['header'];
        $parent_table       = $config['parent_table'];
        $parent_column_name = $config['parent_column_name'];
        $title              = DB::table($parent_table)
            ->whereId($albumId)
            ->first()
            ->title;
        
        return view('upload::upload_2', compact(
            'albumId',
            'trackId',
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
            'id_item_2',
            'pageHeader',
            'header',
            'title'
        ));
    }
    
    public function upload3($config, $albumId, $trackId = null)
    {
        $active       = 'upload';
        $user         = Auth::user();
        $config       = config($config);
        $parent_table = $config['parent_table'];
        $title        = DB::table($parent_table)
            ->whereId($albumId)
            ->first()
            ->title;
        
        return view('upload::' . $config['view'], compact(
            'albumId',
            'trackId',
            'active',
            'user',
            'config',
            'title'
        ));
    }
    
    public function upload4($config, $parentId, $subParentId)
    {
        $active           = 'upload';
        $user             = Auth::user();
        $config           = config($config);
        $parent_table     = $config['parent_db_table'];
        $sub_parent_table = $config['sub_parent_db_table'];
        $title            = DB::table($parent_table)
            ->whereId($parentId)
            ->first()
            ->title;
        $subTitle         = DB::table($sub_parent_table)
            ->whereId($subParentId)
            ->first()
            ->title;
        
        return view('upload::' . $config['view'], compact(
            'parentId',
            'subParentId',
            'active',
            'user',
            'config',
            'title',
            'subTitle'
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
    
    public function storeArts(Request $request)
    {
        $path    = $request->path;
        $table   = $request->db_table;
        $column  = $request->column;
        $id_item = $request->id_item;
        $albumId = $request->albumId;
        Log::debug('store. 1.');
        Log::debug($_FILES);
        $ds = DIRECTORY_SEPARATOR;
        
        $storeFolder = storage_path() . $path;
        Log::debug($storeFolder);
        
        if (!empty($_FILES)) {
            $tempFile = $_FILES['file']['tmp_name'];
            Log::debug($tempFile);
            $path         = $_FILES['file']['name'];
            $ext          = pathinfo($path, PATHINFO_EXTENSION);
            $randomString = $this->generateRandomString(3);
            $fileName     = $albumId . '--' . date('Y-m-d_H-i-s--') . $randomString . ('.') . $ext;
            $targetFile   = $storeFolder . $fileName;
            Log::debug($targetFile);
            
            move_uploaded_file($tempFile, $targetFile);
            
            $result = $this->saveInDb_2($table, $column, $id_item, $albumId, $fileName);
        }
    }
    
    public function storeArts2(Request $request)
    {
        $path        = $request->path;
        $table       = $request->db_table;
        $column      = $request->column;
        $id_item     = $request->id_item;
        $id_item_2   = $request->id_item_2;
        $parentId    = $request->parentId;
        $subParentId = $request->subParentId;
        Log::debug('store. 1.');
        Log::debug($_FILES);
        $ds = DIRECTORY_SEPARATOR;
        
        $storeFolder = storage_path() . $path;
        Log::debug($storeFolder);
        
        if (!empty($_FILES)) {
            $tempFile = $_FILES['file']['tmp_name'];
            Log::debug($tempFile);
            $path         = $_FILES['file']['name'];
            $ext          = pathinfo($path, PATHINFO_EXTENSION);
            $randomString = $this->generateRandomString(3);
            $fileName     = $parentId . '-' . $subParentId . '-' . date('Y-m-d_H-i-s--') . $randomString . ('.') . $ext;
            $targetFile   = $storeFolder . $fileName;
            Log::debug($targetFile);
            
            move_uploaded_file($tempFile, $targetFile);
            
            $result = $this->saveInDb_3($table, $column, $id_item, $parentId, $id_item_2, $subParentId, $fileName);
        }
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
    
    private function saveInDb_2($table, $column, $id_item, $id, $fileName)
    {
        DB::table($table)->insert([
            [
                'album_or_track' => 'album',
                $id_item         => $id,
                $column          => $fileName,
                'cover'          => '0',
            ],
        ]);
        
    }
    
    private function saveInDb_3($table, $column, $id_item, $id, $id_item_2, $id_2, $fileName)
    {
        DB::table($table)->insert([
            [
                'album_or_track' => 'track',
                $id_item         => $id,
                $id_item_2       => $id_2,
                $column          => $fileName,
                'cover'          => '0',
            ],
        ]);
        
    }
    
    private function processUrl($url, $albumId)
    {
        $array = explode('{', $url);
        
        if (count($array > 1)) {
            $array2 = explode('}', $array[1]);
        } else {
            return $url;
        }
        
        $result = implode('', [$array[0], $albumId, $array2[1]]);
        
        return $result;
    }
    
}
