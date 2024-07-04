<?php

// App/Http/Controllers/ReportController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function download(Request $request)
    {
        $branch = $request->input('branch');
        $data = json_decode($request->input('data'), true);

        $filename = "{$branch}_report.csv";

        $response = new StreamedResponse(function() use ($data) {
            $handle = fopen('php://output', 'w');

            foreach ($data as $tab => $rows) {
                // Add tab name as a header
                fputcsv($handle, [$tab]);
                
                if (count($rows) > 0) {
                    // Add column headers
                    fputcsv($handle, array_keys($rows[0]));
                    
                    // Add data rows
                    foreach ($rows as $row) {
                        fputcsv($handle, $row);
                    }
                }
                
                // Add a blank line for separation between tabs
                fputcsv($handle, []);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename={$filename}");

        return $response;
    }
}
