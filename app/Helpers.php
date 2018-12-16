<?php

namespace App;

class Helpers {
    public static function getArrayCbxOptionsForFile(File $file) {
        return [
                /*[Id and name, Text label, is checked]*/
                ['isTitlePage', 'Title Page', old('isTitlePage')??$file->is_title_page],
                ['isToc', 'Table of contents', old('isToc')??$file->is_toc],
                ['isTocOwnPage', 'TOC on own page', old('isTocOwnPage')??$file->is_toc_own_page],
                ['isLinksAsNotes', 'Are links as notes', old('isLinksAsNotes')??$file->is_links_as_notes],
        ];
    }

    public static function getArrayTextOptionsForFile(File $file) {
        return [
            /*[Id and name, label text, input content, placeholder, required / or not]*/
            ['title', 'Title', old('title')??$file->title, 'Title', 'required'],
            ['subtitle', 'Subtitle', old('subtitle')??$file->subtitle, 'Subtitle', ''],
            ['school', 'School', old('school')??$file->school, 'School', ''],
            ['authors', 'Authors', old('authors')??$file->authors, 'Authors1, Authors2, Authors3, ...', ''],
        ];
    }
}


