<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CsvUploadController extends Controller
{

    public function myFilter($var){
        return ($var !== NULL && $var !== FALSE && $var !== "");
    }

    public function index()
    {
        return view('upload-csv');
    }

    /**
     * Summary of store
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file',FILE_SKIP_EMPTY_LINES);
        // $file = $request->file('csv_file');
        // $file= implode("\n", $file);
        // $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        // $cleanedCSV = implode("\n", $lines);

        // dd($file)
        // Read the CSV file and insert data into the database


        DB::table('csv_data')->truncate();
        $csvData = array_map('str_getcsv', file($file));

        // $values = [null];

        // $result = array_filter($csvData , fn ($value) => !is_null($value));
        // dd($result);

        // $csvData = array_filter($csvData,"myFilter");

        // dd($csvData);

        try {
            foreach ($csvData as $data) {
                if ($data[0] != null && $data[1] != null){
                $query = DB::table('csv_data')->insert([
                    'startdate' => $data[0],
                    'enddate' => $data[1],
                ]);
            }
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        if ($query > 0) {
            return redirect()->back()->with('success', "CSV Uploaded!");
        }
    }
}
