<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'active',
    ];


    /**
     * Get the user for one selection
     */
     public function user()
     {
         return $this->belongsTo("App\User");
     }

    /**
     * Get the notes for one selection
     */
     public function notes()
     {
         return $this->hasMany("App\Note");
     }

    /**
     * Get the favourites for one selection
     */
     public function favourites()
     {
         return $this->hasMany("App\Favourite");
     }

    /**
     * Get the posters for one selection
     */
     public function posters()
     {
         return $this->belongsToMany("App\Poster")->withPivot('order')->orderBy('order');
     }

    /**
     * Get the tags for one selection
     */
     public function tags()
     {
         return $this->belongsToMany("App\Tag");
     }

    /**
     * Get the home selections for one selection
     */
     public function selectionsHome()
     {
         return $this->hasMany("App\SelectionHome");
     }

     /**
      * Calculates the average rating of a given selection
      * @return float $average
      */
     public function averageRating()
     {
         $total = 0;
         $average = null;

         foreach ($this->notes as $n) {
             $total += $n->note;
         }

         $nbNotes = $this->notes->count();
         if ($total > 0 && $nbNotes > 0) {
             $average = $total / $nbNotes;
         }

         return $average;
     }

     /**
     * Has the given user added this selection to its favs?
     */
     public function isFavOfUser($user)
     {
         if(!$user)
             return false;
         $favs = $this->favourites;
         $usersHavingFaved = array();

         foreach ($favs as $fav) {
             $usersHavingFaved[] = $fav->user_id;
         }
         return (in_array($user->id, $usersHavingFaved));
     }

    /**
     * Retrieve all the selections of the current user. If the user is an admin, retrieve all the selection
     * @param $query
     */
    public function scopeMyselections($query)
    {
        $user = auth()->user();
        if($user->is_admin){
            return $query->orderBy('created_at', 'desc');
        } else {
            return $query->where('user_id', $user->id)->orderBy('created_at', 'desc');
        }
    }
}
