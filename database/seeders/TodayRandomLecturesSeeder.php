<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TodayRandomLecturesSeeder extends Seeder
{
    private const LECTURE_COUNT = 20;

    private const DURATION_MINUTES = 60;

    public function run(): void
    {
        $today = today()->toDateString();
        $trainers = DB::table('users')
            ->where('status', 'active')
            ->pluck('id')
            ->all();
        $courses = DB::table('courses')
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->pluck('id')
            ->all();
        $sections = DB::table('trainee_sections as ts')
            ->join('batches as b', 'b.id', '=', 'ts.batch_id')
            ->where('ts.status', 'active')
            ->where('b.status', 'active')
            ->whereNull('ts.deleted_at')
            ->whereNull('b.deleted_at')
            ->select('ts.id', 'ts.batch_id')
            ->get();
        $rooms = DB::table('rooms')
            ->where('status', 'active')
            ->whereNull('deleted_at')
            ->pluck('id')
            ->all();

        if ($trainers === [] || $courses === [] || $sections->isEmpty()) {
            throw new RuntimeException(
                'Active trainers, courses, and sections are required to create lectures.'
            );
        }

        $startTimes = $this->getFutureStartTimes();
        $roomBookings = DB::table('schedules')
            ->whereDate('date', $today)
            ->whereNotNull('room_id')
            ->whereNull('deleted_at')
            ->whereNotIn('status', ['cancelled', 'finished'])
            ->get(['room_id', 'start_time', 'end_time'])
            ->all();

        DB::transaction(function () use (
            $today,
            $trainers,
            $courses,
            $sections,
            $rooms,
            $startTimes,
            &$roomBookings
        ): void {
            for ($index = 0; $index < self::LECTURE_COUNT; $index++) {
                $startAt = $startTimes[array_rand($startTimes)]->copy();
                $endAt = $startAt->copy()->addMinutes(self::DURATION_MINUTES);
                $deliveryMode = fake()->randomElement([
                    'onsite',
                    'online',
                    'hybrid',
                ]);

                $roomId = $deliveryMode === 'online'
                    ? null
                    : $this->findAvailableRoom($rooms, $roomBookings, $startAt, $endAt);

                if ($roomId === null) {
                    $deliveryMode = 'online';
                } else {
                    $roomBookings[] = (object) [
                        'room_id' => $roomId,
                        'start_time' => $startAt->format('H:i:s'),
                        'end_time' => $endAt->format('H:i:s'),
                    ];
                }

                $section = $sections->random();

                DB::table('schedules')->insert([
                    'batch_id' => $section->batch_id,
                    'trainee_section_id' => $section->id,
                    'trainer_id' => fake()->randomElement($trainers),
                    'room_id' => $roomId,
                    'delivery_mode' => $deliveryMode,
                    'online_link' => in_array($deliveryMode, ['online', 'hybrid'], true)
                        ? 'https://example.com/meeting/'.fake()->uuid()
                        : null,
                    'recurrence_key' => null,
                    'course_id' => fake()->randomElement($courses),
                    'date' => $today,
                    'start_time' => $startAt->format('H:i:s'),
                    'end_time' => $endAt->format('H:i:s'),
                    'status' => 'not_started',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        $this->command?->info('Created 20 random lectures for '.$today.'.');
    }

    private function getFutureStartTimes(): array
    {
        $startAt = now()->startOfMinute();
        $startAt->addMinutes(15 - ($startAt->minute % 15));

        $latestStartAt = today()->endOfDay()
            ->subMinutes(self::DURATION_MINUTES);
        $startTimes = [];

        while ($startAt->lte($latestStartAt)) {
            $startTimes[] = $startAt->copy();
            $startAt->addMinutes(15);
        }

        if ($startTimes === []) {
            throw new RuntimeException('There is not enough time left today for a one-hour lecture.');
        }

        return $startTimes;
    }

    private function findAvailableRoom(array $rooms, array $roomBookings, Carbon $startAt, Carbon $endAt): ?int
    {
        $availableRooms = array_values(array_filter(
            $rooms,
            static function (int $roomId) use ($roomBookings, $startAt, $endAt): bool {
                foreach ($roomBookings as $booking) {
                    if (
                        (int) $booking->room_id === $roomId
                        && $startAt->format('H:i:s') < $booking->end_time
                        && $endAt->format('H:i:s') > $booking->start_time
                    ) {
                        return false;
                    }
                }

                return true;
            }
        ));

        return $availableRooms === []
            ? null
            : (int) fake()->randomElement($availableRooms);
    }
}
