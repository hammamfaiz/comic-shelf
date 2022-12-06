<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query("search");

        $libraries = DB::table("libraries")
            ->select(DB::raw("id, name, stock, deleted_at"))
            ->where("libraries.deleted_at", "=", null);
        if (!empty($search)) {
            $libraries = $libraries->where(
                "libraries.name",
                "like",
                "%$search%"
            );
        }

        return Inertia::render("Libraries/Index", [
            "libraries" => $libraries->get(),
        ]);
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     **/
    public function trashed()
    {
        $trashedLibraries = DB::table("libraries")
            ->select(DB::raw("id, name, stock, deleted_at"))
            ->where("libraries.deleted_at", "!=", null)
            ->get();
        return Inertia::render("Libraries/Trashed", [
            "trashed_libraries" => $trashedLibraries,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Libraries/Create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::validate(
            $request->all(),
            [
                "name" => ["required", "string", "max:255"],
                "stock" => ["required", "integer", "min:0"],
            ],
            [],
            [
                "name" => "library name",
                "stock" => "library stock",
            ]
        );
        DB::table("libraries")->insert([
            "name" => $request->name,
            "stock" => $request->stock,
        ]);
        return Redirect::route("libraries.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $library = DB::table("libraries")
            ->select(DB::raw("id, name, stock, deleted_at"))
            ->where("libraries.deleted_at", "=", null)
            ->where("id", "=", $id)
            ->get();
        return Inertia::render("Libraries/Edit", [
            "library" => $library[0],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Validator::validate(
            $request->all(),
            [
                "name" => ["required", "string", "max:255"],
                "stock" => ["required", "integer", "min:0"],
            ],
            [],
            [
                "name" => "library name",
                "stock" => "library stock",
            ]
        );
        DB::table("libraries")
            ->where("id", "=", $id)
            ->update([
                "name" => $request->name,
                "stock" => $request->stock,
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("libraries.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("libraries")
            ->where("id", "=", $id)
            ->update([
                "deleted_at" => Carbon::now(),
            ]);
        return back();
    }

    /**
     * Permanently remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_permanent($id)
    {
        DB::table("libraries")
            ->where("id", "=", $id)
            ->delete();
        return back();
    }

    /**
     * Restore the specified trashed resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        DB::table("libraries")
            ->where("id", "=", $id)
            ->where("deleted_at", "!=", null)
            ->update([
                "deleted_at" => null,
            ]);
        return back();
    }
}
