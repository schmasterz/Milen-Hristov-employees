<?php
namespace App\Services;

use App\Enums\DateFormats;
use Carbon\Carbon;

class DateFormatService
{
    /**
     * Parse a date from various formats.
     *
     * @param string $date
     * @return Carbon
     * @throws \Exception
     */
    public function parseDate(string $date): Carbon
    {
        $date = trim($date);
        if ($date === 'NULL' || $date === '') {
            return Carbon::now();
        }

        $format = collect(DateFormats::cases())
            ->first(fn($format) => $this->canParseDate($date, $format->value));

        if (!$format) {
            throw new \Exception("Unsupported date format: $date");
        }

        return Carbon::createFromFormat($format->value, $date);
    }

    /**
     * Check if the date can be parsed using a given format.
     *
     * @param string $date
     * @param string $format
     * @return bool
     */
    private function canParseDate(string $date, string $format): bool
    {
        try {
            Carbon::createFromFormat($format, $date);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
