<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Trainee;
use App\Models\TraineeSection;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\ScheduleTemplate;
use App\Models\ScheduleTemplateDay;
use App\Models\ScheduleTemplateSlot;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | USERS
        |--------------------------------------------------------------------------
        */

        $users = collect();

        for ($i = 1; $i <= 10; $i++) {

            $users->push(
                User::create([
                    'first_name' => fake()->firstName(),
                    'last_name' => fake()->lastName(),

                    'username' => fake()->unique()->userName(),

                    'email' => fake()->unique()->safeEmail(),

                    'email_verified_at' => now(),

                    'password' => Hash::make('password'),

                    'phone' => fake()->unique()->numerify('05########'),

                    'job_title' => fake()->randomElement([
                        'Trainer',
                        'Senior Trainer',
                        'Instructor',
                        'Teacher',
                    ]),

                    'language_type' => fake()->randomElement([
                        'arabic',
                        'english',
                    ]),

                    'status' => 'active',

                    'image' => null,

                    // 'created_by' => null,
                    // 'updated_by' => null,

                    'last_login_at' => null,
                    'last_login_ip' => null,
                ])
            );
        }


        /*
        |--------------------------------------------------------------------------
        | COURSES
        |--------------------------------------------------------------------------
        */

        $courses = collect();

        for ($i = 1; $i <= 10; $i++) {

            $courses->push(
                Course::create([
                    // 'program_id' => null,

                    'course_code' =>
                        'CRS-' . str_pad($i, 4, '0', STR_PAD_LEFT),

                    'name' => fake()->randomElement([
                        'Laravel Development',
                        'PHP Programming',
                        'Database Fundamentals',
                        'Web Development',
                        'Software Engineering',
                        'API Development',
                        'Advanced PHP',
                        'MySQL Database',
                        'Backend Development',
                        'Programming Fundamentals',
                    ]),

                    'status' => 'active',

                    // 'created_by' => null,
                    // 'updated_by' => null,

                    // 'notes' => fake()->optional()->sentence(),
                ])
            );
        }


        /*
        |--------------------------------------------------------------------------
        | BATCHES
        |--------------------------------------------------------------------------
        */

        $batches = collect();

        for ($i = 1; $i <= 5; $i++) {

            $startDate = Carbon::now()
                ->subMonths($i)
                ->startOfMonth();

            $batches->push(
                Batch::create([
                    // 'training_plan_id' => null,

                    'batch_code' =>
                        'BATCH-' . str_pad($i, 3, '0', STR_PAD_LEFT),

                    'batch_name' =>
                        'Training Batch ' . $i,

                    'trainee_count' => 50,

                    'start_date' => $startDate,

                    'status' => 'active',

                    'created_by' => null,
                    // 'updated_by' => null,

                    // 'notes' => fake()->optional()->sentence(),
                ])
            );
        }


        /*
        |--------------------------------------------------------------------------
        | TRAINEE SECTIONS
        |--------------------------------------------------------------------------
        */

        $sections = collect();

        foreach ($batches as $batch) {

            for ($i = 1; $i <= 3; $i++) {

                $sections->push(
                    TraineeSection::create([
                        'section_code' =>
                            'SEC-' . $batch->id . '-' . $i,

                        'batch_id' => $batch->id,

                        'section_name' =>
                            'Section ' . $i,

                        'trainee_count' => 20,

                        'status' => 'active',

                        // 'created_by' => null,
                        // 'updated_by' => null,

                        // 'notes' => fake()->optional()->sentence(),
                    ])
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | TRAINEES
        |--------------------------------------------------------------------------
        */

        foreach ($sections as $section) {

            for ($i = 1; $i <= 10; $i++) {

                $firstName = fake()->firstName();
                $lastName = fake()->lastName();

                Trainee::create([

                    'academic_number' =>
                        'STU-' .
                        $section->id .
                        '-' .
                        str_pad($i, 3, '0', STR_PAD_LEFT),

                    'trainee_section_id' =>
                        $section->id,

                    // 'entity_id' => null,

                    'first_name_ar' => fake()->firstName(),
                    'father_name_ar' => fake()->firstName(),
                    'grand_father_name_ar' => fake()->firstName(),
                    'family_name_ar' => fake()->lastName(),

                    'first_name_en' => $firstName,
                    'father_name_en' => fake()->firstName(),
                    'grand_father_name_en' => fake()->firstName(),
                    'family_name_en' => $lastName,

                    'username' =>
                        fake()->unique()->userName(),

                    'email' =>
                        fake()->unique()->safeEmail(),

                    'email_verified_at' => now(),

                    'password' =>
                        Hash::make('password'),

                    'phone' =>
                        fake()->unique()->numerify('05########'),

                    'phone_verified_at' => now(),

                    'ident_num' =>
                        fake()->unique()->numerify('##########'),

                    'image' => null,

                    'gender' =>
                        fake()->randomElement([
                            'male',
                            'female',
                        ]),

                    'receive_emails' => 'active',
                    'receive_SMS' => 'active',
                    'receive_notify' => 'active',

                    'language_type' =>
                        fake()->randomElement([
                            'arabic',
                            'english',
                        ]),

                    'status' => 'active',

                    // 'created_by' => null,
                    // 'updated_by' => null,

                    // 'notes' => null,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | ROOMS
        |--------------------------------------------------------------------------
        */

        $rooms = collect();

        for ($i = 1; $i <= 10; $i++) {

            $rooms->push(
                Room::create([

                    'room_code' =>
                        'ROOM-' . str_pad($i, 3, '0', STR_PAD_LEFT),

                    /*
                     * لازم تكون null لأننا لا نعرف
                     * بيانات type_places و floors هنا.
                     */
                    // 'type_place_id' => null,

                    // 'floor_id' => null,

                    'description_ar' =>
                        'قاعة تدريب رقم ' . $i,

                    'description_en' =>
                        'Training Room ' . $i,

                    'status' =>
                        fake()->randomElement([
                            'active',
                            'active',
                            'inactive',
                        ]),

                    'used_in_schedule' =>
                        fake()->boolean(),

                    // 'created_by' => null,
                    // 'updated_by' => null,

                    // 'notes' =>
                    //     fake()->optional()->sentence(),
                ])
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SCHEDULE TEMPLATES
        |--------------------------------------------------------------------------
        */

        $templates = collect();

        for ($i = 1; $i <= 3; $i++) {

            $templates->push(
                ScheduleTemplate::create([

                    'template_code' =>
                        'TPL-' . str_pad($i, 3, '0', STR_PAD_LEFT),

                    'name' =>
                        'Training Schedule Template ' . $i,

                    'status' => 'active',

                    // 'created_by' => null,
                    // 'updated_by' => null,

                    // 'notes' =>
                    //     fake()->optional()->sentence(),
                ])
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SCHEDULE TEMPLATE DAYS
        |--------------------------------------------------------------------------
        */

        $days = [
            'sunday',
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
        ];

        foreach ($templates as $template) {

            foreach ($days as $day) {

                ScheduleTemplateDay::create([

                    'schedule_template_id' =>
                        $template->id,

                    'day' => $day,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SCHEDULE TEMPLATE SLOTS
        |--------------------------------------------------------------------------
        */

        $slots = [
            ['08:00:00', '10:00:00'],
            ['10:00:00', '12:00:00'],
            ['12:00:00', '14:00:00'],
            ['14:00:00', '16:00:00'],
        ];

        foreach ($templates as $template) {

            foreach ($slots as [$start, $end]) {

                ScheduleTemplateSlot::create([

                    'schedule_template_id' =>
                        $template->id,

                    'start_time' => $start,

                    'end_time' => $end,
                ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | SCHEDULES
        |--------------------------------------------------------------------------
        */

        $usedSchedules = [];

        for ($i = 1; $i <= 50; $i++) {

            do {

                $date = Carbon::today()
                    ->addDays(fake()->numberBetween(0, 30))
                    ->format('Y-m-d');

                $startHour = fake()->numberBetween(8, 16);

                $startTime =
                    str_pad($startHour, 2, '0', STR_PAD_LEFT) . ':00:00';

                $endTime =
                    str_pad($startHour + 2, 2, '0', STR_PAD_LEFT) . ':00:00';

                $key =
                    $date .
                    '_' .
                    $startTime .
                    '_' .
                    $rooms->random()->id;

            } while (isset($usedSchedules[$key]));

            $usedSchedules[$key] = true;

            $deliveryMode = fake()->randomElement([
                'onsite',
                'onsite',
                'online',
                'hybrid',
            ]);

            $roomId = in_array($deliveryMode, ['online'])
                ? null
                : $rooms->random()->id;

            Schedule::create([

                'batch_id' =>
                    $batches->random()->id,

                'trainee_section_id' =>
                    $sections->random()->id,

                'trainer_id' =>
                    $users->random()->id,

                'room_id' =>
                    $roomId,

                'delivery_mode' =>
                    $deliveryMode,

                'online_link' =>
                    in_array($deliveryMode, ['online', 'hybrid'])
                        ? 'https://meet.google.com/' .
                          fake()->bothify('???-????-???')
                        : null,

                'recurrence_key' =>
                    fake()->optional()->uuid(),

                'course_id' =>
                    $courses->random()->id,

                'date' =>
                    $date,

                'start_time' =>
                    $startTime,

                'end_time' =>
                    $endTime,

                'status' =>
                    fake()->randomElement([
                        'not_started',
                        'not_started',
                        'in_progress',
                        'finished',
                        'cancelled',
                    ]),

                // 'created_by' => null,
                // 'updated_by' => null,

                // 'notes' =>
                //     fake()->optional()->sentence(),
            ]);
        }
    }
}