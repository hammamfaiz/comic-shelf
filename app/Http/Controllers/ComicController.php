<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Carbon\Carbon;

class ComicController extends Controller
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
            $comics = DB::table("comics")
                ->select(
                    DB::raw(
                        "comics.id as id, comics.title as title, comics.author as author, comics.stock as stock, comics.price as price, comic_genres.id as comic_genre_id, comic_genres.name as comic_genre_name, comic_publishers.id as comic_publisher_id, comic_publishers.name as comic_publisher_name, libraries.id as library_id, libraries.name as library_name, libraries.stock as library_stock, comics.deleted_at as deleted_at"
                    )
                )
                ->join(
                    "comic_genres",
                    "comic_genres.id",
                    "=",
                    "comics.genre_id"
                )
                ->join(
                    "comic_publishers",
                    "comic_publishers.id",
                    "=",
                    "comics.publisher_id"
                )
                ->join("libraries", "libraries.id", "=", "comics.library_id")
                ->where("comics.deleted_at", "=", null);
        } else {
            $comics = DB::table("comics")
                ->select(
                    DB::raw(
                        "comics.id as id, comics.title as title, comics.author as author, comics.stock as stock, comics.price as price, comic_genres.id as comic_genre_id, comic_genres.name as comic_genre_name, comic_publishers.id as comic_publisher_id, comic_publishers.name as comic_publisher_name, libraries.id as library_id, libraries.name as library_name, libraries.stock as library_stock, comics.deleted_at as deleted_at"
                    )
                )
                ->where("comics.deleted_at", "=", null)
                ->where("comics.title", "like", "%$search%")
                ->orWhere("comics.author", "like", "%$search%")
                ->orWhere("comics.stock", "like", "%$search%")
                ->orWhere("comics.price", "like", "%$search%")
                ->orWhere("comic_genres.name", "like", "%$search%")
                ->orWhere("comic_publishers.name", "like", "%$search%")
                ->join(
                    "comic_genres",
                    "comic_genres.id",
                    "=",
                    "comics.genre_id"
                )
                ->join(
                    "comic_publishers",
                    "comic_publishers.id",
                    "=",
                    "comics.publisher_id"
                )
                ->join("libraries", "libraries.id", "=", "comics.library_id");
        }
        return Inertia::render("Comics/Index", [
            "comics" => $comics->get(),
        ]);
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashedComics = DB::table("comics")
            ->select(
                DB::raw(
                    "comics.id as id, comics.title as title, comics.author as author, comics.stock as stock, comics.price as price, comic_genres.id as comic_genre_id, comic_genres.name as comic_genre_name, comic_publishers.id as comic_publisher_id, comic_publishers.name as comic_publisher_name, libraries.id as library_id, libraries.name as library_name, libraries.stock as library_stock, comics.deleted_at as deleted_at"
                )
            )
            ->where("comics.deleted_at", "!=", null)
            ->join("comic_genres", "comic_genres.id", "=", "comics.genre_id")
            ->join(
                "comic_publishers",
                "comic_publishers.id",
                "=",
                "comics.publisher_id"
            )
            ->join("libraries", "libraries.id", "=", "comics.library_id")
            ->get();
        return Inertia::render("Comics/Trashed", [
            "trashed_comics" => $trashedComics,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $comicGenres = DB::table("comic_genres")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $comicPublishers = DB::table("comic_publishers")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $libraries = DB::table("libraries")
            ->select(DB::raw("id, name, stock, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        return Inertia::render("Comics/Create", [
            "comic_genres" => $comicGenres,
            "comic_publishers" => $comicPublishers,
            "libraries" => $libraries,
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
        Validator::validate(
            $request->all(),
            [
                "genre" => ["required", "integer", "exists:comic_genres,id"],
                "publisher" => [
                    "required",
                    "integer",
                    "exists:comic_publishers,id",
                ],
                "library" => ["required", "integer", "exists:libraries,id"],
                "title" => ["required", "string", "max:255"],
                "author" => ["required", "string", "max:255"],
                "stock" => ["required", "integer", "min:0"],
                "price" => ["required", "integer", "min:0"],
            ],
            [],
            [
                "genre" => "comic genre",
                "publisher" => "comic publisher",
                "library" => "comic library",
                "title" => "comic title",
                "author" => "comic author",
                "stock" => "comic stock",
                "price" => "comic price",
            ]
        );
        DB::table("comics")->insert([
            "genre_id" => $request->genre,
            "publisher_id" => $request->publisher,
            "library_id" => $request->library,
            "title" => $request->title,
            "author" => $request->author,
            "stock" => $request->stock,
            "price" => $request->price,
        ]);
        return Redirect::route("comics.index");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comicGenres = DB::table("comic_genres")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $comicPublishers = DB::table("comic_publishers")
            ->select(DB::raw("id, name, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $libraries = DB::table("libraries")
            ->select(DB::raw("id, name, stock, deleted_at"))
            ->where("deleted_at", "=", null)
            ->get();
        $comic = DB::table("comics")
            ->select(
                DB::raw(
                    "comics.id as id, comics.title as title, comics.author as author, comics.stock as stock, comics.price as price, comic_genres.id as comic_genre_id, comic_genres.name as comic_genre_name, comic_publishers.id as comic_publisher_id, comic_publishers.name as comic_publisher_name, libraries.id as library_id, libraries.name as library_name, libraries.stock as library_stock, comics.deleted_at as deleted_at"
                )
            )
            ->where("comics.deleted_at", "=", null)
            ->where("comics.id", "=", $id)
            ->join("comic_genres", "comic_genres.id", "=", "comics.genre_id")
            ->join(
                "comic_publishers",
                "comic_publishers.id",
                "=",
                "comics.publisher_id"
            )
            ->join("libraries", "libraries.id", "=", "comics.library_id")
            ->get();
        return Inertia::render("Comics/Edit", [
            "comic_genres" => $comicGenres,
            "comic_publishers" => $comicPublishers,
            "libraries" => $libraries,
            "comic" => $comic[0],
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
                "genre" => ["required", "integer", "exists:comic_genres,id"],
                "publisher" => [
                    "required",
                    "integer",
                    "exists:comic_publishers,id",
                ],
                "library" => ["required", "integer", "exists:libraries,id"],
                "title" => ["required", "string", "max:255"],
                "author" => ["required", "string", "max:255"],
                "stock" => ["required", "integer", "min:0"],
                "price" => ["required", "integer", "min:0"],
            ],
            [],
            [
                "genre" => "comic genre",
                "publisher" => "comic publisher",
                "library" => "comic library",
                "title" => "comic title",
                "author" => "comic author",
                "stock" => "comic stock",
                "price" => "comic price",
            ]
        );
        DB::table("comics")
            ->where("id", "=", $id)
            ->update([
                "genre_id" => $request->genre,
                "publisher_id" => $request->publisher,
                "library_id" => $request->library,
                "title" => $request->title,
                "author" => $request->author,
                "stock" => $request->stock,
                "price" => $request->price,
                "updated_at" => Carbon::now(),
            ]);
        return Redirect::route("comics.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table("comics")
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
        DB::table("comics")
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
        DB::table("comics")
            ->where("id", "=", $id)
            ->where("deleted_at", "!=", null)
            ->update([
                "deleted_at" => null,
            ]);
        return back();
    }
}
