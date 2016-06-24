<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Image;
use Storage;
use App\Movie;
use App\Http\Requests;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    /**
     * Initialize instance
     */
    public function __construct()
    {
        // Define middleware
        $this->middleware('auth', ['only' => [
            'create',
            'store',
        ]]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::getAllMovies();

        return view('home', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'name' => 'required|max:255|unique:movies',
            'release_date' => 'required|date',
            'image' => 'required|image',
        ]);

        // Prepare movie data
        $movie_data = $request->all();
        $movie_data['user_id'] = Auth::user()->id;

        // Save to database
        DB::beginTransaction();
        $movie = Movie::create($movie_data);
        $this->saveImage($movie, $request->file('image'));
        DB::commit();

        return redirect("movies/{$movie->name_slug}/edit");
    }

    /**
     * Save and resize movie image
     *
     * @param Movie  $movie
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile  $image
     * @return bool
     */
    private function saveImage($movie, $image)
    {
        // Preferred image size
        $image_size = [
            'width' => 200,
            'height' => 300
        ];

        $directory_path = "images/movies/{$movie->name_slug}/";

        $public_storage = Storage::disk('public_html');

        $public_storage->makeDirectory($directory_path, 0775, true, true);

        $post_filename = '-' . str_random(3) . '.' . $image->getClientOriginalExtension();

        $concat_filename = substr($movie->name_slug, 0, 255 - strlen($post_filename));

        $new_file_name = $concat_filename . $post_filename;
        $full_file_path = public_path($directory_path . $new_file_name);

        // Save and resize image to preferred path
        Image::make($image->getRealPath())
            ->fit($image_size['width'], $image_size['height'])
            ->save($full_file_path)->destroy();

        // Save the new filename to database
        $movie->image_path = $new_file_name;
        $movie->save();

        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $name_slug
     * @return \Illuminate\Http\Response
     */
    public function edit($name_slug)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
