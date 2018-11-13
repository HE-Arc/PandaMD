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
        $this->repositroy=$repository;
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
        $this->repositroy->store($request);
        $name = $request->input('name');
        return response()->json([
            'state' => true,
            'name' => $name,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function show(Folder $folder)
    {
        $this->authorize('manage',$folder);

        $folders = $folder->folders;
        $files = $folder->files;
        return view('folders.show', compact('folder','folders', 'files'));
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
        $this->authorize('manage',$folder);

        $this->repositroy->updateName($folder,$request);
        $newName = $request->input('newName');
        return response()->json([
            'state' => true,
            'newName' => $newName,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Folder $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        //
    }
}
