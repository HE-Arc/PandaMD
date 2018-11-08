<?php

namespace App\Http\Controllers;

use App\File;
use App\Http\Requests\StoreFile;
use App\Jobs\ProcessPDFDocument;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Helpers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        $this->authorize('read', $file);
        return view('files.show', ['file' => $file]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        $this->authorize('edit', $file);
        $fileDate = date_create($file->date)->format("M d, Y");
        $cbxOptions = Helpers::getArrayCbxOptionsForFile($file);
        $textOptions = Helpers::getArrayTextOptionsForFile($file);
        return view('files.edit', compact('file', 'cbxOptions', 'textOptions', 'fileDate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFile $request, File $file)
    {
        $validator = $request->validated();
        $file->content = $request->fileContent;
        $file->is_title_page = $request->isTitlePage ?? false;
        $file->is_toc = $request->isToc ?? false;
        $file->is_toc_own_page = $request->isTocOwnPage ?? false;
        $file->is_links_as_notes = $request->isLinksAsNotes ?? false;
        $file->title = $request->title ?? "Title";
        $file->subtitle = $request->subtitle ?? "Subtitle";
        $file->school = $request->school;
        $file->date = $request->date;
        $file->save();
        return redirect(route('files.show', $file));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }

    public function generate(Request $request, File $file)
    {
        $token = $file->exportMDFile();
        ProcessPDFDocument::dispatch($token)->onQueue("");
        $headers = array( //Source : https://stackoverflow.com/questions/20415444/download-files-in-laravel-using-responsedownload
            'Content-Type: application/pdf',
        );
        return \Illuminate\Support\Facades\Response::download("pdf_files/$token.pdf", "$file->title.pdf", $headers);
    }

}
