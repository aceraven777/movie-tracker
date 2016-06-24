<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'name_slug', 'release_date', 'image_path'];

    /**
     * Fields to treat as carbon instance dates
     *
     * @var array
     */
    protected $dates = ['release_date'];

    /**
     * @param $date
     * @return string
     */
    public function getReleaseDateAttribute($date)
    {
        return Carbon::parse($date)->format('F j, Y');
    }

    /**
     * @return mixed
     */
    public static function getAllMovies()
    {
        $movies = self::orderBy('name', 'asc')->paginate(30);

        return $movies;
    }

    /**
     * @param array $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $movie = parent::create($attributes);

        self::assignNameSlug($movie);

        return $movie;
    }

    /**
     * @param $movie
     * @return bool
     */
    private static function assignNameSlug($movie)
    {
        $movie->name_slug = str_slug($movie->name);
        $movie->name_slug = self::generateUniqueNameSlug($movie->name_slug, $movie->id);

        $movie->save();

        return true;
    }

    /**
     * @param $name_slug
     * @param $movie_id
     * @return string
     */
    private static function generateUniqueNameSlug($name_slug, $movie_id)
    {
        $i = 1;

        do {
            if ($i == 1) {
                $new_name_slug = substr($name_slug, 0, 255);
            } else {
                $number_str_length = strlen($i);
                $new_name_slug = substr($name_slug, 0, 255 - $number_str_length) . $i;
            }

            $query = self::where(['name_slug' => $new_name_slug]);
            $query->where('id', '<>', $movie_id);

            $name_slug_exists = $query->exists();

            $i++;
        } while ($name_slug_exists);

        return $new_name_slug;
    }
}
