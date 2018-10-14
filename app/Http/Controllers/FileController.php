<?php

namespace App\Http\Controllers;

use App\File;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers;
use Symfony\Component\Console\Helper\Helper;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        return view('files.show', ['file' => $file]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        $fileDate = date_create($file->date)->format("M d, Y");

        return view('files.edit', [
            'file' => $file,
            'cbxOptions' => Helpers::getArrayCbxOptionsForFile($file),
            'textOptions' => Helpers::getArrayTextOptionsForFile($file),
            'fileDate' => $fileDate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        $file->content = $request->get('fileContent');
        $file->is_title_page = $request->get('isTitlePage') ?? false;
        $file->is_toc = $request->get('isToc') ?? false;
        $file->is_toc_own_page = $request->get('isTocOwnPage') ?? false;
        $file->is_links_as_notes = $request->get('isLinksAsNotes') ?? false;
        $file->title = $request->get('title')??"Title";
        $file->subtitle = $request->get('subtitle')??"Subtitle";
        $file->school = $request->get('school');
        $file->date = $request->get('date');
        $file->save();
        return redirect(route('files.show', $file));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }
}
