<?php

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentDataSeeder extends Seeder
{
    public function run()
    {
    	if(DB::table('students')->get()->count() == 0){
        	factory(Student::class, 100)->create();
    	}
    }
}
