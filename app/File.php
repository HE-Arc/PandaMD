<?php

namespace App;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;


class File extends Model
{
    protected $table = "files";
    public static $attr_private = 'private';
    public static $attr_readable = 'readable';
    public static $attr_editable = 'editable';
    private static $yaml_delim = "---" . PHP_EOL;

    protected $fillable = [
        'folder_id','title','date','secrity','content',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class, 'folder_id');
    }

    public function isEditable(?User $user)
    {
        $security = $this->security;

        if ($security == File::$attr_editable) {
            return true;
        }
        return $user != null && $this->folder->user_id == $user->id;

    }

    public function isReadable(?User $user)
    {
        $security = $this->security;

        if ($security == File::$attr_editable || $security == File::$attr_readable) {
            return true;
        }
        return $user != null && $user->id == $this->folder->user_id;
    }

    public function canChangeFile(User $user){
        return $user->id == $this->folder->user->id;
    }


    public function exportMDFile()
    {
        $date = date('YmdHis');
        $token = "{$this->id}{$this->folder->id}{$date}"; //Create a token (unique while 2 same file aren't build at same ms)
        Log::debug("ICCCCCI : $token");
        $file_name = "{$token}.md";
        $yaml_options = [
            "title" => $this->title ?? "",
            "subtitle" => $this->subtitle ?? "",
            "date" => $this->date ?? "",
            "school" => $this->school ?? "",
            "author" => $this->authors ?? "",
            "papersize" => "a4",
            "geometry" => "margin=3cm",
            "titlepage" => $this->is_title_page ?? false,
            "toc" => $this->is_toc ?? false,
            "toc-own-page" => $this->is_toc_own_page ?? false,
            "links-as-notes" => $this->is_links_as_notes ?? false,
            "toc-depth" => 5,
        ];
        $file_content = File::$yaml_delim . Yaml::dump($yaml_options) . File::$yaml_delim . $this->content;
        Storage::put("md_files/$file_name", $file_content);
        return $token;
    }


}
