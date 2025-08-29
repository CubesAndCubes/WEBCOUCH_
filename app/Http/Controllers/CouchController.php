<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\UserFile;
use Illuminate\Http\Request;
use App\Events\RoomMediaChange;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;

class CouchController extends Controller
{
    public function overview(Request $request) {
        $user = auth()->user();

        $rooms = $user->rooms()->get();

        return view('app.couches', [
            'rooms' => $rooms,
        ]);
    }

    public function new(Request $request) {
        return view('app.couches.new');
    }

    public function create(Request $request) {
        $user = auth()->user();

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('rooms')->where(
                    fn(Builder $query) => $query->where('user_id', $user->id),
                ),
            ],
        ]);

        $room = Room::create([
            'uuid' => Uuid::uuid4(),
            'name' => $data['name'],
            'user_id' => $user->id,
        ]);

        return redirect("/couches/{$room->uuid}");
    }

    private function get_room_from_route(Request $request): Room {
        $uuid = $request->route()->parameter('room_uuid');

        $room = Room::where('uuid', '=', $uuid)->first();

        if (!$room) {
            abort(404, 'This Couch does not exist.');
        }

        return $room;
    }

    public function view(Request $request) {
        $room = $this->get_room_from_route($request);

        $user = auth()->user();

        $user_file = $room->userFile()->first();

        $seek = $room->media_seek;

        if (!empty($room->play_timestamp)) {
            $offset = now()->getTimestampMs() - $room->play_timestamp;

            $seek += ($offset / 1000);
        }

        return view('app.couches.view', [
            'room' => $room,
            'user' => $user,
            'user_file' => $user_file,
            'seek' => $seek,
        ]);
    }

    private function is_couch_owner(User $user, Room $room) {
        if ($room->user_id !== $user->id) {
            abort(403, 'Is not couch owner.');
        }

        return true;
    }

    public function regenerate(Request $request) {
        $room = $this->get_room_from_route($request);

        $user = auth()->user();

        $this->is_couch_owner($user, $room);

        $room->uuid = Uuid::uuid4();

        $room->save();

        return redirect("/couches/{$room->uuid}");
    }

    public function selection(Request $request)
    {
        $room = $this->get_room_from_route($request);

        $user = auth()->user();

        $user_files = $user->userFiles()->get();

        return view('app.couches.select', [
            'room' => $room,
            'user_files' => $user_files,
        ]);
    }

    public function select(Request $request)
    {
        $room = $this->get_room_from_route($request);

        $user = auth()->user();

        $this->is_couch_owner($user, $room);

        $data = $request->validate([
            'media_uuid' => 'required|uuid',
        ]);

        $user_file = UserFile::where('uuid', '=', $data['media_uuid'])
            ->first();
        
        if (!$user_file) {
            abort(404, 'Requested media does not exist');
        }

        $room->user_file_id = $user_file->id;

        $room->media_seek = 0.0;

        $room->play_timestamp = null;

        $room->save();

        broadcast(new RoomMediaChange(
            $room->uuid,
            route('media', ['file_uuid' => $user_file->uuid]),
        ));

        return redirect("/couches/{$room->uuid}");
    }

    public function play(Request $request)
    {
        $room = $this->get_room_from_route($request);

        $data = $request->validate([
            'seek' => 'required|numeric',
        ]);

        $seek = floatval($data['seek']);

        $room->media_seek = $seek;

        $room->play_timestamp = now()->getTimestampMs();

        $room->save();

        return response('Couch media played.');
    }

    public function pause(Request $request)
    {
        $room = $this->get_room_from_route($request);

        $data = $request->validate([
            'seek' => 'required|numeric',
        ]);

        $seek = floatval($data['seek']);

        $room->media_seek = $seek;

        $room->play_timestamp = null;

        $room->save();

        return response('Couch media paused.');
    }
}
