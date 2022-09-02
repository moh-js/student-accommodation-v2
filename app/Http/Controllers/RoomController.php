<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Side;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('room-view');

        $rooms = Room::withTrashed()->get();

        return view('rooms.index', [
            'rooms' => $rooms
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('room-add');

        $sides = Side::all();

        return view('rooms.add', [
            'sides' => $sides
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('room-add');

        $validatedData = $request->validate([
            'side_id' => ['required', 'integer'],
            'capacity' => ['required', 'integer'],
            'name' => ['required', 'string'],
        ]);

        Room::firstOrCreate($validatedData);
        toastr()->success('Room added successfully');

        return redirect()->route('rooms.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        $this->authorize('room-update');

        $sides = Side::all();

        return view('rooms.edit', [
            'sides' => $sides,
            'room' => $room
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $this->authorize('room-update');

        $validatedData = $request->validate([
            'side_id' => ['required', 'integer'],
            'capacity' => ['required', 'integer'],
            'name' => ['required', 'string'],
        ]);

        $room->update($validatedData);
        toastr()->success('Room updated successfully');

        return redirect()->route('rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        if ($room->trashed()) {
            $this->authorize('room-activate');
            $room->restore();
            $action = 'restored';
        } else {
            $this->authorize('room-deactivate');
            $room->delete();
            $action = 'deleted';
        }

        toastr()->success("Room $action successfully");
        return redirect()->route('rooms.index');
    }
}
