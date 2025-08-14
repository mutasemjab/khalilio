<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

   
    public function calculateAverage()
    {
        if ($this->arabic_grade && $this->english_grade && 
            $this->jordan_history_grade && $this->islamic_education_grade) {
            
            $average = ($this->arabic_grade / 10) + 
                      ($this->english_grade / 10) + 
                      ($this->jordan_history_grade / 10) + 
                      ($this->islamic_education_grade / 10);
            
            return round($average, 2);
        }
        
        return null;
    }


}
