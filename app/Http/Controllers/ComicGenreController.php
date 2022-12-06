<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;

class ComicGenreController extends Controller
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
            $comicGenres = DB::table("comic_genres")
                ->select(DB::raw("id, name, deleted_at"))
                ->where("comic_genres.deleted_at", "=", null)
                ->get();
        } else {
            $comicGenres = DB::table("comic_genres")
                ->select(DB::raw("id, name, deleted_at"))
                ->where("comic_genres.deleted_at", "=", null)
                ->where("comic_genres.name", "like", "%$search%")
                ->get();
        }

        return Inertia::render("ComicGenres/Index", [
            "comic_genres" => $comicGenres,
        ]);
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashedComicGenres = DB::table("comic_genres")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("comic_genres.deleted_at", "!=", null)
            ->get();
        return Inertia::render("ComicGenres/Trashed", [
            "trashed_comic_genres" => $trashedComicGenres,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("ComicGenres/Create");
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
        DB::table("comic_genres")->insert([
            "name" => $request->name,
        ]);
        return Redirect::route("comics.genres.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comicGenre = DB::table("comic_genres")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("comic_genres.deleted_at", "=", null)
            ->where("id", "=", $id)
            ->get();
        return Inertia::render("ComicGenres/Edit", [
            "comic_genre" => $comicGenre[0],
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
        DB::table("comic_genres")
            ->where("id", "=", $id)
            ->update([
                "name" => $request->name,
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("comics.genres.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("comic_genres")
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
        DB::table("comic_genres")
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
        DB::table("comic_genres")
            ->where("id", "=", $id)
            ->where("deleted_at", "!=", null)
            ->update([
                "deleted_at" => null,
            ]);
        return back();
    }
}
