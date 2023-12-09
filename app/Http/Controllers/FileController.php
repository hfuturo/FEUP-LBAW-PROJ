<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\User;

class FileController extends Controller
{
    static $default = 'pfp_default.jpeg';
    static $diskName = 'images';

    static $systemTypes = [
        'profile' => ['png', 'jpg', 'jpeg']
    ];

    private static function isValidType(String $type) {
        return array_key_exists($type, self::$systemTypes);
    }

    private static function isValidExtension(String $type, String $extension) {
        $allowedExtesnsions = self::$systemTypes[$type];

        return in_array(strtolower($extension), $allowedExtesnsions);
    }

    private static function defaultAsset(String $type) {
        return asset($type . '/' . self::$default);
    }

    private static function getFileName(String $type, int $id) {

        $fileName = null;

        switch($type) {
            case 'profile':
                $fileName = User::find($id)->image;
                break;
        }

        return $fileName;
    }

    static function get(String $type, int $userId) {
        
        // Validation: upload type
        if (!self::isValidType($type)) {
            return self::defaultAsset($type);
        }

        // Validation: file exists
        $fileName = self::getFileName($type, $userId);
        if ($fileName) {
            return asset($type . '/' . $fileName);
        }

        // Not found: returns default asset
        return self::defaultAsset($type);
    }

    private static function delete(String $type, int $id) {
        $existingFileName = self::getFileName($type, $id);
        if ($existingFileName) {
            Storage::disk(self::$diskName)->delete($type . '/' . $existingFileName);

            switch ($type) {
                case 'profile':
                    User::find($id)->image = 'pfp_default.jpeg';
                    break;
            }
        }
    }

    function upload(Request $request) {

        if (!$request->hasFile('file')) {
            return back()->withErrors('Error: File not found');
        }

        if (!$this->isValidType($request->type)) {
            return back()->withErrors('Error: Unsupported upload type');
        }

        //Parameters
        $file = $request->file('file');
        $type = $request->type;
        $id = Auth::user()->id;
        $extension = $file->getClientOriginalExtension();

        if (!$this->isValidExtension($type, $extension)) {
            return back()->withErrors('Error: Unsupported upload extension');
        }

        // prevent existing old files
        $this->delete($type, $id);

        // Hashing
        $fileName = $file->hashName();

        $error = null;
        switch($request->type) {
            case 'profile':
                $user = User::findOrFail($id);
                if ($user) {
                    $user->image = $fileName;
                    $user->save();
                }
                else {
                    $error = "Unknown user";
                }
                break;

            default:
                back()->withErrors('Error: Unsupported upload object');
        }

        if ($error) {
            back()->withErrors(`Error: {$error}`);
        }

        $file->storeAs($type, $fileName, self::$diskName);
        return back()->withSuccess('Image changed successfully.');
    }
}
