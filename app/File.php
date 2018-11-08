<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = "files";
    public static $attr_private = 'private';
    public static $attr_readable = 'readable';
    public static $attr_editable = 'editable';
    private static $yaml_delim = '---';
    private static $endl = '\n';


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

    public function exportMDFile()
    {
        $date = date('YmdHis');
        $token = "{$this->id}{$this->folder->id}{$date}"; //Create a token (unique while 2 same file aren't build at same ms)
        $file_name = "md_files/{$token}.md";
        $file_content = <<<"EOD"
---
title: $this->title
subtitle: $this->subtitle
date: $this->date
school: $this->school
papersize: a4
geometry: margin=3cm
titlepage: $this->is_title_page
toc: $this->is_toc
toc-own-page: $this->is_toc_own_page
links-as-notes: $this->is_links_as_notes
toc-depth: 5
---
$this->content
EOD;

        file_put_contents($file_name, $file_content);
        return $token;
    }


}
