<?php
namespace App\Services;

use Illuminate\Support\Collection;

class EmployeePairService
{
    /**
     * Find the pairs of employees with the maximum total days worked together.
     *
     * @param Collection $data
     * @return Collection
     */
    public function findEmployeePairs(Collection $data): Collection
    {
        $projects = $data->groupBy('project_id');
        $pairs = [];

        foreach ($projects as $records) {
            $records = $records->sortBy('emp_id')->values();

            for ($i = 0; $i < $records->count(); $i++) {
                for ($j = $i + 1; $j < $records->count(); $j++) {
                    $record1 = $records[$i];
                    $record2 = $records[$j];

                    $overlapDays = $this->calculateDateOverlap(
                        $record1['date_from'],
                        $record1['date_to'],
                        $record2['date_from'],
                        $record2['date_to']
                    );
                    if ($overlapDays > 0) {
                        $key = "{$record1['emp_id']}-{$record2['emp_id']}";

                        if (!isset($pairs[$key])) {
                            $pairs[$key] = [
                                'emp1' => $record1['emp_id'],
                                'emp2' => $record2['emp_id'],
                                'totalDaysWorked' => 0,
                            ];
                        }

                        $pairs[$key]['totalDaysWorked'] += $overlapDays;
                    }
                }
            }
        }
        $pairsCollection = collect($pairs);
        $maxDaysWorked = $pairsCollection->max('totalDaysWorked');
        $maxPairs = $pairsCollection->filter(function ($pair) use ($maxDaysWorked) {
            return $pair['totalDaysWorked'] === $maxDaysWorked;
        })->values();
        return $maxPairs->values();
    }

    /**
     * Calculate overlapping days between two date ranges.
     *
     * @param string $start1
     * @param string $end1
     * @param string $start2
     * @param string $end2
     * @return int
     */
    private function calculateDateOverlap(string $start1, string $end1, string $start2, string $end2): int
    {
        $start = max(strtotime($start1), strtotime($start2));
        $end = min(strtotime($end1), strtotime($end2));
        return $end > $start ? ($end - $start) / (60 * 60 * 24) : 0;
    }
}
