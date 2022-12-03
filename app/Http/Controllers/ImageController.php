<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
  private string $folderName = 'image';

  private function clearName($name) {
    return preg_replace('/[_]{2,}/', '_', strtr($name, [
      '/'   => '_',
      '%'   => '_',
      '\''  => '_',
      '\\'  => '_',
      '"'   => '_',
      '='   => '_',
      '?'   => '_',
      '#'   => '_',
      ' '   => '_',
      '&'   => '_',
    ]));
  }

  private function checkOriginalName($originalName) {
    $k = true;
    $i = 0;
    $name = $originalName;
    while($k) {
      if (Storage::disk('ftp')->exists($this->folderName . '/' . $name)){
        $i++;
        $name = str_replace('.', '_' . $i . '.', $originalName);
      } else {
        $k = false;
      }
    }
    return $name;
}

  public function uploadFiles(Request $request) {
    foreach ($request->file('files') as $file) {
      $name = strtolower($file->getClientOriginalName());
      $name = $this->checkOriginalName($name);

      Storage::disk('ftp')->putFileAs(
        $this->folderName, $file,
        $this::clearName($name)
      );
      $image = new Image([
        'name' => $name,
        'date' => date("d.m.Y", $file->getCTime()),
        'time' => date("H:i", $file->getCTime()),
      ]);
      $image->save();
    }
  }

  public function getAllFiles()
  {
    $images = Storage::disk('ftp')->files($this->folderName);
    $result = [];
    if (count($images)) {
      foreach ($images as $image) {
        if (!Storage::disk('public')->exists($image) && Storage::disk('ftp')->exists($image)) {
          $file_download = Storage::disk('ftp')->get($image);
          Storage::disk('public')->put($image, $file_download);
        }
        $date = Storage::disk('public')->lastModified($image);
        $result[] = [
          'name' => str_replace('image/', '', $image),
          'size' => Storage::disk('public')->size($image),
          'date' => date("H:i/d.m.Y", $date),
          'time_u' => $date
        ];

      }
    }
    return $result;
  }
  public function deleteImage(Request $request)
  {
    Storage::disk('ftp')->delete($this->folderName . '/' . $request->name);
    Storage::disk('public')->delete($this->folderName . '/' . $request->name);
    $image = Image::where('name', $request->name);
    $image->delete();
  }
}
