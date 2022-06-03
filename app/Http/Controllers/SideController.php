<?php

namespace App\Http\Controllers;

use App\Models\Side;
use App\Models\Block;
use Illuminate\Http\Request;

class SideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('side-view');

        return view('sides.index', [
            'sides' => Side::withTrashed()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('side-add');

        return view('sides.add', [
            'blocks' => Block::all()
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
        $this->authorize('side-add');

        $validatedData = $request->validate([
            'block_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255', "unique:sides,name"],
            'short_name' => ['required', 'string', 'max:255', "unique:sides,name"],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        Side::firstOrCreate($validatedData);
        toastr()->success('Side added successfully');

        return redirect()->route('sides.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Side  $side
     * @return \Illuminate\Http\Response
     */
    public function edit(Side $side)
    {
        $this->authorize('side-update');

        return view('sides.edit', [
            'blocks' => Block::all(),
            'side' => $side
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Side  $side
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Side $side)
    {
        $this->authorize('side-update');

        $validatedData = $request->validate([
            'block_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255', "unique:sides,name,$side->id,id"],
            'short_name' => ['required', 'string', 'max:255', "unique:sides,name,$side->id,id"],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        $side->update($validatedData);
        toastr()->success('Side updated successfully');

        return redirect()->route('sides.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Side  $side
     * @return \Illuminate\Http\Response
     */
    public function destroy(Side $side)
    {
        if ($side->trashed()) {
            $this->authorize('side-activate');
            $side->restore();
            $action = 'restored';
        } else {
            $this->authorize('side-deactivate');
            $side->delete();
            $action = 'deleted';
        }

        toastr()->success("Side $action successfully");
        return redirect()->route('sides.index');
    }
}
