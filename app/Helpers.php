<?php

namespace App;

use App\File;

class Helpers {
    public static function getArrayCbxOptionsForFile(File $file) {
        return [
                ['isTitlePage', 'Title Page', $file->is_title_page],
                ['isToc', 'Table of contents', $file->is_toc],
                ['isTocOwnPage', 'TOC on own page', $file->is_toc_own_page],
                ['isLinksAsNotes', 'Are links as notes', $file->is_links_as_notes],
        ];
    }

    public static function getArrayTextOptionsForFile(File $file) {
        return [
            ['title', 'Title', $file->title, ''],
            ['subtitle', 'Subtitle', $file->subtitle, ''],
            ['school', 'School', $file->school, ''],
        ];
    }
}


