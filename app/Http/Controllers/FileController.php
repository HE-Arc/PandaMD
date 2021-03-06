<?php

namespace App\Http\Controllers;

use App\File;
use App\Helpers;
use App\Http\Requests\ChangeFolderRequest;
use App\Http\Requests\ChangeRightRequest;
use App\Http\Requests\NameChangeRequest;
use App\Http\Requests\StoreFile;
use App\Jobs\ProcessPDFDocument;
use App\Repositories\FilesRepository;
use App\wait_process;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class FileController extends Controller
{
    public function __construct(FilesRepository $repository)
    {
        $this->middleware('ajax')->only('changeTitle','destroy','changeRight','changeFolder');
        $this->middleware('auth')->only('newFile','changeRight','changeFolder');
        $this->repository = $repository;
    }

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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


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
        $folderPath = array_reverse($file->folder->getPath());
        return view('files.show', compact('file','folderPath'));
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
        $fileContent = old('fileContent') ?? $file->content;
        $fileDate = old('date')??$file->date;
        $cbxOptions = Helpers::getArrayCbxOptionsForFile($file);
        $textOptions = Helpers::getArrayTextOptionsForFile($file);
        $treeFolders=$file->folder->user->getCascadedFolder();
        return view('files.edit', compact('file','treeFolders', 'cbxOptions', 'textOptions','fileContent', 'fileDate'));
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
        $this->authorize('edit', $file);
        $file->content = $request->fileContent;
        $file->is_title_page = $request->isTitlePage ?? false;
        $file->is_toc = $request->isToc ?? false;
        $file->is_toc_own_page = $request->isTocOwnPage ?? false;
        $file->is_links_as_notes = $request->isLinksAsNotes ?? false;
        $file->title = $request->title ?? "Title";
        $file->subtitle = $request->subtitle ?? "Subtitle";
        $file->school = $request->school;
        $file->authors = $request->authors;
        $file->date = Carbon::createFromFormat('d/m/Y', $request->date);
        $file->security = $request->right ?? "private";
        $file->folder_id = $request->newFolder;
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
        $this->authorize('edit', $file);
        $file->delete();
        return response()->json();
    }

    public function generate(Request $request, File $file)
    {
        $token = $file->exportMDFile();

        ProcessPDFDocument::dispatch($token, $file->id);
        return $token;
    }

    public function download(Request $request, String $token)
    {
        $path = storage_path() . "/app/public/pdf_files/$token.pdf";
        if (file_exists($path)) {
            return response()->download($path, "$token.pdf")->deleteFileAfterSend();
        }
        return redirect()->route('home')->with('error', 2)->setStatusCode(404);
    }

    public function isReady(Request $request, String $token) {
        $waitProcess = wait_process::where("token", $token)->firstOrFail();
        return $waitProcess->status;
    }

    public function changeName(NameChangeRequest $request, File $file)
    {
        $this->authorize('edit', $file);
        $newName = $request->input('newName');

            $this->repository->updateName($file, $request);
            return response()->json([
                'state' => true,
                'newName' => $newName,
            ]);

    }

    public function changeRight(ChangeRightRequest $request, File $file)
    {
       $this->authorize('changeFile', $file);

        $this->repository->updateRight($file, $request);
        return response()->json([
            'state' => true,
        ]);

    }

    public function changeFileFolder(ChangeFolderRequest $request, File $file)
    {
        $this->authorize('changeFile', $file);
        $folderId= $request->input('newFolderId');

        if($this->repository->updateFolder($file,$folderId,Auth::user()))
        {
            return response()->json([
                'state' => true,
            ]);

        }
        else{
            return response()->json([
                'state' => false,
            ]);
        }

    }
    public function newFile()
    {
        $idNewFile=$this->repository->newFile(Auth::user());

        return redirect(route('files.edit', $idNewFile));
    }

    /**
     * Upload the image to imgur and return a link to it
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadImage(Request $request)
    {
        $image = $request->getContent();
        $client = new Client();
        $headers = ['Authorization' => 'Client-ID '.config('services.imgur.clientID')];
        $body = [
            'name' => 'image',
            'contents' => $image
        ];
        $response = $client->request('POST', 'https://api.imgur.com/3/image',
            ['headers' => $headers, 'multipart' => [$body]]);

        $data = json_decode($response->getBody(), true);


        return response()->json([
            'link' => $data['data']['link'],
            'state' => true
        ]);




    }
}
