<?php

namespace App;

use App\File;

class Helpers {
    public static function getArrayCbxOptionsForFile(File $file) {
        return [
                /*[Id and name, Text label, is checked]*/
                ['isTitlePage', 'Title Page', $file->is_title_page],
                ['isToc', 'Table of contents', $file->is_toc],
                ['isTocOwnPage', 'TOC on own page', $file->is_toc_own_page],
                ['isLinksAsNotes', 'Are links as notes', $file->is_links_as_notes],
        ];
    }

    public static function getArrayTextOptionsForFile(File $file) {
        return [
            /*[Id and name, label text, input content, placeholder]*/
            ['title', 'Title', $file->title, 'Title'],
            ['subtitle', 'Subtitle', $file->subtitle, 'Subtitle'],
            ['school', 'School', $file->school, 'School'],
            ['authors', 'Authors', $file->authors, 'Authors1, Authors2, Authors3, ...'],
        ];
    }
}


