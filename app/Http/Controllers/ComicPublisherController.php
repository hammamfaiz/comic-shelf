<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;

class ComicPublisherController extends Controller
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
        if (empty($search)) {
            $comicPublishers = DB::table("comic_publishers")
                ->select(DB::raw("id, name, deleted_at"))
                ->where("comic_publishers.deleted_at", "=", null)
                ->get();
        } else {
            $comicPublishers = DB::table("comic_publishers")
                ->select(DB::raw("id, name, deleted_at"))
                ->where("comic_publishers.deleted_at", "=", null)
                ->where("comic_publishers.name", "like", "%$search%")
                ->get();
        }

        return Inertia::render("ComicPublishers/Index", [
            "comic_publishers" => $comicPublishers,
        ]);
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashedComicPublishers = DB::table("comic_publishers")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("comic_publishers.deleted_at", "!=", null)
            ->get();
        return Inertia::render("ComicPublishers/Trashed", [
            "trashed_comic_publishers" => $trashedComicPublishers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("ComicPublishers/Create");
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
            ],
            [],
            [
                "name" => "comic genre name",
            ]
        );
        DB::table("comic_publishers")->insert([
            "name" => $request->name,
        ]);
        return Redirect::route("comics.publishers.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comicPublisher = DB::table("comic_publishers")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("comic_publishers.deleted_at", "=", null)
            ->where("id", "=", $id)
            ->get();
        return Inertia::render("ComicPublishers/Edit", [
            "comic_publisher" => $comicPublisher[0],
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
            ],
            [],
            [
                "name" => "comic genre name",
            ]
        );
        DB::table("comic_publishers")
            ->where("id", "=", $id)
            ->update([
                "name" => $request->name,
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("comics.publishers.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("comic_publishers")
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
        DB::table("comic_publishers")
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
        DB::table("comic_publishers")
            ->where("id", "=", $id)
            ->where("deleted_at", "!=", null)
            ->update([
                "deleted_at" => null,
            ]);
        return back();
    }
}
