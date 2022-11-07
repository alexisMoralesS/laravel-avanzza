<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use App\Models\RequestCounter;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    private $messageNotFound = "El registro no existe";
    private $entity = 'File';
    public function list()
    {
        $files = File::withTrashed()->simplePaginate();
        $this->recuestCounter(__FUNCTION__);
        return response()->json(["data" => $files]);
    }

    public function store(StoreFileRequest $request)
    {
        $names = $request->name;
        $files = $request->file;
        foreach ($files as $key => $file) {
            $objFile = new File();
            $objFile->name = $names[$key];
            $objFile->original_name = $file->getClientOriginalName();

            $url = $file->store('public');

            $objFile->url = $url;
            $objFile->save();
        }
        $this->recuestCounter(__FUNCTION__);
        return response()->json(["message" => "Se guardaron los datos"], 200);
    }

    public function destroy($id)
    {
        $file = File::find($id);
        if (!$file) {
            return response()->json(["message" => $this->messageNotFound], 404);
        }
        $file->delete();
        $this->recuestCounter(__FUNCTION__);
        return response()->json(["message" => "Se eliminó el registro"], 200);
    }
    public function forceDestroy($id)
    {
        $file = File::withTrashed()->find($id);
        if (!$file) {
            return response()->json(["message" => $this->messageNotFound], 404);
        }
        $file->forceDelete();
        $this->recuestCounter(__FUNCTION__);

        return response()->json(["message" => "Se eliminó el registro de forma definitiva"], 200);
    }

    private function recuestCounter($action)
    {
        $count = RequestCounter::where('entity', $this->entity)
            ->where('action', $action)->where('user_id', Auth::user()->id)->count();
        if ($count == 0) {
            $requestCounter = new RequestCounter();
            $requestCounter->user_id = Auth::user()->id;
            $requestCounter->entity = $this->entity;
            $requestCounter->action = $action;
        } else {
            $requestCounter = RequestCounter::where('entity', $this->entity)
                ->where('action', $action)->where('user_id', Auth::user()->id)
                ->get()->last();
        }
        $requestCounter->total = $count + 1;
        $requestCounter->save();
    }
}
