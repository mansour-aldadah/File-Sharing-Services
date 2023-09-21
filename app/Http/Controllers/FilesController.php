<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\File;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class FilesController extends Controller
{
    public function index()
    {
       $user = Auth::user()->id ;
        $files = File::orderBy('created_at')->get();
        return view('files.index', compact('files' , 'user'));
    }
    public function showAll()
    {
        $files = File::orderBy('created_at')->get();
        return view('files.show_all', compact('files'));
    }

    public function showFile(File $file, $filename)
    {
        if (!Storage::disk('local')->exists($filename)) {
            abort(404);
        }

        $path = Storage::disk('local')->path($filename);
        $file = Storage::disk('local')->get($filename);
        $type = Storage::mimeType($path);
       
        return Response::make(content: $file, headers: ['Content-Type' => $type, 'Content-Length' => filesize($path)]);
    }
    public function show_file(File $file)
    {
        $filename = $file->file;
        if (!Storage::disk('local')->exists($filename)) {
            abort(404);
        }
        // Increment the download count.
        $file->download_counters++ ;
        // dd( $file->download_counters++ );
        $file->update();

        // // Generate a shareable download link.
        // $downloadLink = route('files.download', ['file_id' => $file_id]);

        // // Perform the file download.
        // return response()->download(storage_path('app/' . $file->path))->deleteFileAfterSend(true);

        $path = Storage::disk('local')->path($filename);
        $file = Storage::disk('local')->get($filename);
        $type = Storage::mimeType($path);
        return Response::make(content: $file, headers: ['Content-Type' => $type, 'Content-Length' => filesize($path)]);
        // return redirect()->route('files.show-all');

        // return Response::make(content: $file, headers: ['Content-Type' => $type, 'Content-Length' => filesize($path)]);
    }

    public function create()
    {
        return view('files.add', ['file' => new File]);
    }
    public function store(FileRequest $request)
    {
        $data = $request->validated();
        $user_id = Auth::user()->id;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file->storeAs('', $file->getClientOriginalName());
            $data['file'] = $file_name;


            $data['user_agent'] = $request->header('User_Agent');
            $data['code'] = Str::random(10);
            $data['ip_address'] = $request->ip();
            $data['user_id'] = $user_id;
            $ip_address = $data['ip_address'];
            $url = "http://ip-api.com/json/{$ip_address}";
            $response = json_decode(file_get_contents($url)) ?? false;
            // dd($response->status != 'fail');
            if ($response) {
  
                $data['country'] = $response->country;
            }
            $file = File::create($data);
        }
        return redirect()->route('files.index')->with('success', "File {$file->title} added successfully.");
    }



    public function edit(File $file)
    {
        return view('files.edit', compact('file'));
    }

    public function update(FileRequest $request, File $file)
    {
        $data = $request->validated();
        $user_id = Auth::user()->id;
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file1 = $request->file('file');
            $file_name = $file1->getClientOriginalName();
            $file1->storeAs('', $file1->getClientOriginalName());
            $data['file'] = $file_name;


            $data['user_agent'] = $request->header('User_Agent');
            $data['code'] = Str::random(10);
            $data['ip_address'] = $request->ip();
            $data['user_id'] = $user_id;
            $ip_address = $data['ip_address'];
            $url = "http://ip-api.com/json/{$ip_address}";
            $response = json_decode(file_get_contents($url));
            // dd($response->status != 'fail');
            if ($response->status != 'fail') {

                $data['country'] = $response->country;
            }
            $file->update($data);
        }

        return redirect()->route('files.index')->with('success', "File {$file->title} updated successfully.");
    }


    public function downloadForm(Request $request, File $file): Renderable
    {
        $link = URL::signedRoute('files.download', ['file' => $file]);

        //        dd($link);
        return view('files.download', compact('file', 'link'));
    }

    public function download(Request $request, File $file)
    {
        if ($file->file && Storage::disk('local')->exists($file->file)) {
            return response()->download(Storage::disk('local')->path($file->file));
        }

        return redirect()->back()->with('error', 'Something Error.');
    }

    public function destroy($id)
    {
        $file = File::find($id);

        if (!$file) {
            return back()->with('error', 'Something error.');
        }

        $file->delete();
        File::DeleteFile($file->file);
        return Redirect::back()->with('success', "File with title {$file->title} deleted successfully.");
    }
}
