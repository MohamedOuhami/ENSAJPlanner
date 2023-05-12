<?php

namespace App\Rules;

use App\Lesson;
use Illuminate\Contracts\Validation\Rule;

class LessonTimeAvailabilityRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($lesson = null)
    {
        $this->lesson = $lesson;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This time is not available';
    }
}
