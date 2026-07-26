<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::create([
            'title' => 'Conversations - দৈনন্দিন কথোপকথন',
            'slug' => 'conversations',
            'description' => 'রোজকার জীবনের সাধারণ ইংরেজি কথোপকথন শিখুন সহজ ধাপে ধাপে।',
            'order' => 1,
        ]);

        $lesson1 = Lesson::create([
            'course_id' => $course->id,
            'title' => 'পাঠ ১: পরিচয় করিয়ে দেওয়া (Introducing yourself)',
            'slug' => 'lesson-1',
            'order' => 1,
            'text_content' => "A: Hello! My name is Rahim. What's your name?\nB: Hi Rahim, I'm Karim. Nice to meet you.\nA: Nice to meet you too. Where are you from?\nB: I'm from Dhaka. And you?\nA: I'm from Chittagong.",
            'audio_url' => null,
        ]);

        Question::create([
            'lesson_id' => $lesson1->id,
            'question_text' => "কারিমের বাসা কোথায়?",
            'option_a' => 'Dhaka',
            'option_b' => 'Chittagong',
            'option_c' => 'Sylhet',
            'option_d' => 'Khulna',
            'correct_option' => 'a',
            'order' => 1,
        ]);

        Question::create([
            'lesson_id' => $lesson1->id,
            'question_text' => "\"Nice to meet you\" এর বাংলা অর্থ কী?",
            'option_a' => 'ধন্যবাদ',
            'option_b' => 'আপনার সাথে দেখা হয়ে ভালো লাগলো',
            'option_c' => 'শুভ সকাল',
            'option_d' => 'বিদায়',
            'correct_option' => 'b',
            'order' => 2,
        ]);

        $lesson2 = Lesson::create([
            'course_id' => $course->id,
            'title' => 'পাঠ ২: কেমন আছেন জিজ্ঞেস করা (Asking how someone is)',
            'slug' => 'lesson-2',
            'order' => 2,
            'text_content' => "A: How are you today?\nB: I'm fine, thank you. And you?\nA: I'm doing well, thanks for asking.",
            'audio_url' => null,
        ]);

        Question::create([
            'lesson_id' => $lesson2->id,
            'question_text' => "\"How are you today?\" প্রশ্নের সাধারণ উত্তর কী?",
            'option_a' => 'Good morning',
            'option_b' => "I'm fine, thank you",
            'option_c' => 'See you later',
            'option_d' => 'What is your name',
            'correct_option' => 'b',
            'order' => 1,
        ]);
    }
}
