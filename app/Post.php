<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{

    use SoftDeletes; 

    protected $fillable = ['title', 'content','user_id'];

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public static function boot(){

        parent::boot();
    
            static::deleting(function(Post $post){
                
                $post->comments()->delete();

            });

            static::restoring(function(Post $post){
                
                $post->comments()->restore();
    
            });
    

            


    }






    /** 
     * 
     * La suppresion physique : Deleting related model using model events if don't use softDeletes
     * ya3ni la suppression mn abna2 tal apa2 
     * 
     * 
    // public static function boot(){

    //     parent::boot();

        static::deleting(function(Post $post){
            
            $post->comments()->delete();

        });


    // }

    **/


   





}
