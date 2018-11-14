<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\FolderRequest;
use App\Http\Requests\FolderNameChangeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\FolderRepository;

class FolderController extends Controller
{
    public function __construct(FolderRepository $repository)
    {
        $this->middleware('auth');
        $this->middleware('ajax')->only('destroy','update','store');
        $this->repositroy = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect(route('folders.show', Auth::user()->getUserHomeFolder()->id));
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
    public function store(FolderRequest $request)
    {

        $currentFolder = Folder::find($request->input('folderId'));
        $this->authorize('manage', $currentFolder);

        $name = $request->input('name');
        if ($currentFolder->canCreatedFolder($name)) {
            $this->repositroy->store(Auth::user(),$request);
            return response()->json([
                'state' => true,
                'name' => $name,
            ]);
        } else {
            return response()->json([
                'state' => false,
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function show(Folder $folder)
    {
        $this->authorize('manage', $folder);

        $folders = $folder->folders;
        $files = $folder->files;
        return view('folders.show', compact('folder', 'folders', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function edit(Folder $folder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function update(FolderNameChangeRequest $request, Folder $folder)
    {
        $this->authorize('manage', $folder);

        $currentFolder = Folder::find($folder->folder_id);
        $newName = $request->input('newName');
        if ($currentFolder->canCreatedFolder($newName)) {
            $this->repositroy->updateName($folder, $request);
            return response()->json([
                'state' => true,
                'newName' => $newName,
            ]);
        } else {
            return response()->json([
                'state' => false,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        $this->authorize('manage', $folder);
        $folder->delete();
        return response()->json();
    }
}
