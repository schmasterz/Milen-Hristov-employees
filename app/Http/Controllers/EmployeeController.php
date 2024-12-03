<?php
namespace App\Http\Controllers;

use App\Services\DateFormatService;
use App\Services\EmployeePairService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    protected DateFormatService $dateFormat;
    protected EmployeePairService $employeePairService;

    public function __construct(DateFormatService $dateFormat, EmployeePairService $employeePairService)
    {
        $this->dateFormat = $dateFormat;
        $this->employeePairService = $employeePairService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Invalid file. Please upload a CSV file.',
                'messages' => $validator->errors(),
            ], 400);
        }

        $file = $request->file('file');

        try {
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $parsedData = collect($data)->map(function ($row) {
                return [
                    'emp_id' => trim($row[0]),
                    'project_id' => trim($row[1]),
                    'date_from' => $this->dateFormat->parseDate($row[2]),
                    'date_to' => $this->dateFormat->parseDate($row[3]),
                ];
            });
            $pairs = $this->employeePairService->findEmployeePairs($parsedData);

            return response()->json($pairs, 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error processing the file: ' . $e->getMessage(),
            ], 400);
        }
    }
}
