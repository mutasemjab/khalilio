<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return User::select(
            'id',
            'name',
            'phone',
            'school_name',
            'arabic_grade',
            'english_grade',
            'jordan_history_grade',
            'islamic_education_grade',
            'average'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Phone',
            'School Name',
            'Arabic Grade',
            'English Grade',
            'Jordan History Grade',
            'Islamic Education Grade',
            'Average',
        ];
    }
}
