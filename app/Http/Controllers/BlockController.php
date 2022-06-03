<?php

namespace App\Http\Controllers;

use App\Models\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('block-view');

        return view('blocks.index', [
            'blocks' => Block::withTrashed()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('block-add');

        return view('blocks.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('block-add');

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:blocks,name'],
            'short_name' => ['required', 'string', 'max:255', 'unique:blocks,short_name'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        Block::firstOrCreate($validatedData);

        toastr()->success('Block added successfully');
        return redirect()->route('blocks.index');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function edit(Block $block)
    {
        $this->authorize('block-update');

        return view('blocks.edit', [
            'block' => $block
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Block $block)
    {
        $this->authorize('block-update');

        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255', "unique:blocks,name,$block->id,id"],
            'short_name' => ['required', 'string', 'max:255', "unique:blocks,short_name,$block->id,id"],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        $block->update($validatedData);

        toastr()->success('Block updated successfully');
        return redirect()->route('blocks.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Block  $block
     * @return \Illuminate\Http\Response
     */
    public function destroy(Block $block)
    {
        if ($block->trashed()) {
            $this->authorize('block-activate');
            $block->restore();
            $action = 'restored';
        } else {
            $this->authorize('block-deactivate');
            $block->delete();
            $action = 'deleted';
        }

        toastr()->success("Block $action successfully");
        return redirect()->route('blocks.index');
    }
}
