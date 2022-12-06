<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComicController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ComicGenreController;
use App\Http\Controllers\ComicPublisherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", function () {
    return Inertia::render("Welcome", [
        "canLogin" => Route::has("login"),
        "canRegister" => Route::has("register"),
        "laravelVersion" => Application::VERSION,
        "phpVersion" => PHP_VERSION,
    ]);
});

Route::middleware([
    "auth:sanctum",
    config("jetstream.auth_session"),
    "verified",
])->group(function () {
    // Libraries Endpoint
    Route::group(
        [
            "prefix" => "libraries",
            "as" => "libraries.",
        ],
        function () {
            Route::get("/", [LibraryController::class, "index"])->name("index");
            Route::get("trashed", [LibraryController::class, "trashed"])->name(
                "trashed"
            );
            Route::get("create", [LibraryController::class, "create"])->name(
                "create"
            );
            Route::post("store", [LibraryController::class, "store"])->name(
                "store"
            );
            Route::get("{id}/edit", [LibraryController::class, "edit"])->name(
                "edit"
            );
            Route::put("{id}/update", [
                LibraryController::class,
                "update",
            ])->name("update");
            Route::get("{id}/destroy", [
                LibraryController::class,
                "destroy",
            ])->name("destroy");
            Route::get("{id}/destroy-permanent", [
                LibraryController::class,
                "destroy_permanent",
            ])->name("destroy_permanent");
            Route::get("{id}/restore", [
                LibraryController::class,
                "restore",
            ])->name("restore");
        }
    );

    // Comics Endpoints
    Route::group(
        [
            "prefix" => "comics",
            "as" => "comics.",
        ],
        function () {
            Route::get("/", [ComicController::class, "index"])->name("index");
            Route::get("trashed", [ComicController::class, "trashed"])->name(
                "trashed"
            );
            Route::get("create", [ComicController::class, "create"])->name(
                "create"
            );
            Route::post("store", [ComicController::class, "store"])->name(
                "store"
            );
            Route::get("{id}/edit", [ComicController::class, "edit"])->name(
                "edit"
            );
            Route::put("{id}/update", [ComicController::class, "update"])->name(
                "update"
            );
            Route::get("{id}/destroy", [
                ComicController::class,
                "destroy",
            ])->name("destroy");
            Route::get("{id}/destroy-permanent", [
                ComicController::class,
                "destroy_permanent",
            ])->name("destroy_permanent");
            Route::get("{id}/restore", [
                ComicController::class,
                "restore",
            ])->name("restore");

            // Comic Genres Endpoints
            Route::group(
                [
                    "prefix" => "genres",
                    "as" => "genres.",
                ],
                function () {
                    Route::get("/", [
                        ComicGenreController::class,
                        "index",
                    ])->name("index");
                    Route::get("trashed", [
                        ComicGenreController::class,
                        "trashed",
                    ])->name("trashed");
                    Route::get("create", [
                        ComicGenreController::class,
                        "create",
                    ])->name("create");
                    Route::post("store", [
                        ComicGenreController::class,
                        "store",
                    ])->name("store");
                    Route::get("{id}/edit", [
                        ComicGenreController::class,
                        "edit",
                    ])->name("edit");
                    Route::put("{id}/update", [
                        ComicGenreController::class,
                        "update",
                    ])->name("update");
                    Route::get("{id}/destroy", [
                        ComicGenreController::class,
                        "destroy",
                    ])->name("destroy");
                    Route::get("{id}/destroy-permanent", [
                        ComicGenreController::class,
                        "destroy_permanent",
                    ])->name("destroy_permanent");
                    Route::get("{id}/restore", [
                        ComicGenreController::class,
                        "restore",
                    ])->name("restore");
                }
            );

            // Comic Publishers Endpoint
            Route::group(
                [
                    "prefix" => "publishers",
                    "as" => "publishers.",
                ],
                function () {
                    Route::get("/", [
                        ComicPublisherController::class,
                        "index",
                    ])->name("index");
                    Route::get("trashed", [
                        ComicPublisherController::class,
                        "trashed",
                    ])->name("trashed");
                    Route::get("create", [
                        ComicPublisherController::class,
                        "create",
                    ])->name("create");
                    Route::post("store", [
                        ComicPublisherController::class,
                        "store",
                    ])->name("store");
                    Route::get("{id}/edit", [
                        ComicPublisherController::class,
                        "edit",
                    ])->name("edit");
                    Route::put("{id}/update", [
                        ComicPublisherController::class,
                        "update",
                    ])->name("update");
                    Route::get("{id}/destroy", [
                        ComicPublisherController::class,
                        "destroy",
                    ])->name("destroy");
                    Route::get("{id}/destroy-permanent", [
                        ComicPublisherController::class,
                        "destroy_permanent",
                    ])->name("destroy_permanent");
                    Route::get("{id}/restore", [
                        ComicPublisherController::class,
                        "restore",
                    ])->name("restore");
                }
            );
        }
    );
});
