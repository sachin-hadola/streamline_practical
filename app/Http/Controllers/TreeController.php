<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tree;
use App\Models\Tree_two;

class TreeController extends Controller {

    function index(Request $request) {

        $all_data = Tree::where('trees.parent_id', 0)->get();
        return view('welcome', compact('all_data'));
    }

    function getmoredata(Request $request) {
        $childrendata = Tree::where('trees.parent_id', $request->id)->get();
        $html = view('welcome_ajax', compact('childrendata'))->render();

        return $html;
    }

    function savedata(Request $request) {
        if ($request->selection_type == 1) {
            $name = $request->name ?? '';
            $request->validate([
                'name' => 'required'
            ]);
        } else if ($request->selection_type == 2) {
            $request->validate([
                'file_name' => 'required'
            ]);
        }
        if ($request->has('file_name')) {
            $file = $request->file('file_name');

            if ($request->selection_type == 2) {
                $name = $file->getClientOriginalName();
            }
            //Move Uploaded File
            $destinationPath = 'uploads';
            $file->move($destinationPath, $file->getClientOriginalName());
        }

        $tree = new Tree;

        $tree->name = $name ?? '';
        $tree->parent_id = $request->parent_id ?? 0;
        $tree->type = $request->selection_type ?? 1;

        $tree->save();
        return 1;
    }

    function deleteddata(Request $request) {
        $id = $request->id;
        $res = Tree::where('id', $id)->delete();
        $res = Tree::where('parent_id', $id)->delete();
        return 1;
    }

}
