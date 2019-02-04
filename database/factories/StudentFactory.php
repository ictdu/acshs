<?php

use Faker\Generator as Faker;
use App\Models\Student;

$autoIncrement = autoIncrement();

$factory->define(Student::class, function (Faker $faker) use ($autoIncrement) {
    $autoIncrement->next();
    /*return [
        'email' => $faker->unique()->safeEmail
    ];*/
    $counter = 1;
    $password = bcrypt('123456');
    $fname = '';
    $gender = '';
    //$plname = $faker->randomElement(['', 'del', 'de', 'der', 'den']);
    $mname = 'D';
    $lname = $faker->lastName;

    $x = rand(1, 4);

    switch( $x ) {
        case 1:
                $fname = $faker->firstNameFemale;
                $gender = 'Female';
                break;
        case 2:
                $fname = $faker->firstNameMale;
                $gender = 'Male';
                break;
        case 3:
                $fname = $faker->firstNameFemale;
                $gender = 'Other';
                break;
        case 4:
                $fname = $faker->firstNameMale;
                $gender  = 'Other';
                break;
    }

    return [
        's_id' => '0118000'. $autoIncrement->current(),
        'email' => $x. $fname.$lname. '@gmail.com',
        'password' => bcrypt('0118000'. $autoIncrement->current()),
        //'phone_number' => $faker->e164PhoneNumber,
        'firstname' => $fname,
        //'prefix_last_name' => $plname,
        'middlename' => $mname,
        'lastname' => $lname,
        'birthday' => $faker->dateTimeBetween($startDate = '-90 years', $endDate = '-16 years', $timezone = date_default_timezone_get()),
        'gender' => $gender,
        'address1' => $faker->address,
        'address2' => $faker->address,
        'contact' => $faker->phoneNumber,
        'barangay' => 'dummy',
        'religion' => 'dummy',
        'municipality' => 'dummy',
        'province' => 'dummy',
        'father' => 'dummy',
        'mother' => 'dummy'
        //'street' => $faker->streetName,
        //'house_number' => $faker->numberBetween($min = 0, $max = 200),
       // 'zip_code' => $faker->postcode,
        //'city' => $faker->city,
        //'img_path' => "images/" . $faker->md5 . ".jpg",
    ];
});

function autoIncrement()
{
    for ($i = 0; $i <= 100; $i++) {
        yield $i;
    }
}
