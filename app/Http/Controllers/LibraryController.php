<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class LibraryController extends Controller
{
    public function overview(Request $request) {
        $user = auth()->user();

        $user_files = $user->userFiles()->get();

        return view('app.library', [
            'user_files' => $user_files,
        ]);
    }

    public function media_upload(Request $request) {
        $request->validate([
            'media' => 'required|array',
            'media.*' => 'file|mimetypes:video/mp4,video/webm',
        ]);

        $user = auth()->user();

        foreach ($request->file('media') as $file) {
            $hash_name = $file->hashName();

            $file->storeAs('media', $hash_name);

            $name = $file->getClientOriginalName();

            $name = substr($name, 0, strrpos($name, '.'));

            UserFile::create([
                'uuid' => Uuid::uuid4(),
                'user_id' => $user->id,
                'name' => $name,
                'hash_name' => $hash_name,
            ]);
        }

        return redirect('/library');
    }

    public function media_serve(Request $request)
    {
        $uuid = $request->route()->parameter('file_uuid');

        $user_file = UserFile::where('uuid', '=', $uuid)->first();

        if (!$user_file) {
            abort(404, 'Requested media does not exist.');
        }

        $filePath = "media/{$user_file->hash_name}";

        if (!Storage::exists($filePath)) {
            abort(404, 'Media file not found.');
        }

        $fileSize = Storage::size($filePath);
        $mimeType = Storage::mimeType($filePath);

        $range = $request->header('Range');

        if (!$range) {
            return Storage::response($filePath, null, [
                'Content-Type' => $mimeType,
                'Content-Length' => $fileSize,
                'Accept-Ranges' => 'bytes',
                'Cache-Control' => 'public, max-age=3600',
            ]);
        }

        if (!preg_match('/bytes=(\d+)-(\d*)/', $range, $matches)) {
            return response('Invalid range', 416, [
                'Content-Range' => "bytes */{$fileSize}"
            ]);
        }

        $start = intval($matches[1]);
        $end = $matches[2] !== '' ? intval($matches[2]) : $fileSize - 1;

        if ($start > $end || $start >= $fileSize || $end >= $fileSize) {
            return response('Range not satisfiable', 416, [
                'Content-Range' => "bytes */{$fileSize}"
            ]);
        }

        $contentLength = $end - $start + 1;

        $stream = Storage::readStream($filePath);
        if (!$stream) {
            abort(500, 'Unable to read file.');
        }

        fseek($stream, $start);

        $chunk = fread($stream, $contentLength);
        fclose($stream);

        return response($chunk, 206, [
            'Content-Type' => $mimeType,
            'Content-Length' => $contentLength,
            'Content-Range' => "bytes {$start}-{$end}/{$fileSize}",
            'Accept-Ranges' => 'bytes',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
