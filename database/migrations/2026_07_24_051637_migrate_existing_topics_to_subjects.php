
<?php

use App\Models\Course;
use App\Models\Subject;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $courses = Course::all();

        foreach ($courses as $course) {

            // প্রতিটি Course-এর জন্য একটি Default Subject তৈরি
            $subject = Subject::create([
                'course_id'   => $course->id,
                'title'       => 'General',
                'description' => 'Default Subject',
                'serial'      => 1,
            ]);

            // ঐ Course-এর সব Chapter (Topic) কে General Subject-এর সাথে যুক্ত করা
            $course->topics()->update([
                'subject_id' => $subject->id,
            ]);
        }
    }

    public function down(): void
    {
        Subject::query()->delete();
    }
};