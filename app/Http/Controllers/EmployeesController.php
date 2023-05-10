<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeesRequest;
use App\Models\Document_type;
use App\Models\Job;
use App\Models\Employees;

use Illuminate\Http\Request;

use \FPDF;
use Hamcrest\Type\IsNumeric;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $limit = $request->limit ?? 5;
        $begin = Is_numeric($request->page) ? ($request->page - 1) * $request->limit : 0;
        $employees = Employees::orderBy('id', 'DESC')->skip($begin)->take($request->limit)->get();
        $employees->load('document_type','job');

        return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(EmployeesRequest $request)
    {
        $employee = new Employees();
        $employee->fill($request->all());

        $employee->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $employee = Employees::findOrFail($id);
        $employee->load('document_type','job');

        return response()->json($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function patch(Request $request, $id)
    {
        $rules = [];

        $employee = Employees::findOrFail($id);
        $employee->fill($request->all());
        $employee->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employees::findorFail($id);
        $employee->users()->each(function($user){
            $user->delete();
        });
        $employee->delete();
    }

    function generatePDF() {
        $pdf = new FPDF('L');
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetFillColor(200, 200, 200);

        $employees = Employees::select('id','document_type_id','document_number','names','lastnames','phone','email','job_id')->orderBy('id','ASC')->get();
        $results = $employees->toArray();
        $document_types = Document_type::all();
        $jobs = Job::all();

        $columnNames = array_keys($results[0]);

        foreach ($columnNames as $columnName) {
            if($columnName == 'id'){
                $pdf->Cell(10, 6, $columnName, 1, 0, 'C', true);
            }else if($columnName == 'email'){
                $pdf->Cell(65, 6, $columnName, 1, 0, 'C', true);
            }else if($columnName == 'phone'){
                $pdf->Cell(25, 6, $columnName, 1, 0, 'C', true);
            }else{
                if($columnName == 'document_type_id'){
                    $columnName = 'document_type';
                }else if($columnName == 'job_id'){
                    $columnName = 'job';
                }
                $pdf->Cell(35, 6, $columnName, 1, 0, 'C', true);
            }
        }
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);

        foreach ($results as $row) {
            foreach ($columnNames as $columnName) {
                if($columnName == 'id'){
                    $pdf->Cell(10, 7, $row[$columnName], 1, 0, 'C');
                }else if($columnName == 'email'){
                    $pdf->Cell(65, 7, $row[$columnName], 1, 0, 'C');
                }else if($columnName == 'phone'){
                    $pdf->Cell(25, 7, $row[$columnName], 1, 0, 'C');
                }else{
                    if($columnName == 'document_type_id'){
                        foreach ($document_types as $document_type){
                            if ($document_type->id == $row[$columnName]){
                                $row[$columnName] = $document_type->document_type;
                                break;
                            }
                        }
                    }else if($columnName == 'job_id'){
                        foreach ($jobs as $job){
                            if ($job->id == $row[$columnName]){
                                $row[$columnName] = $job->job;
                                break;
                            }
                        }
                    }
                    $pdf->Cell(35, 7, $row[$columnName], 1, 0, 'C');
                }
            }
            $pdf->Ln();
        }

        $pdf->Output();
    }

    // public function updateAll()
    // {
    //     $document_types = Document_type::all();
    //     $jobs = Job::all();
    //     $employees = Employees::all();

    //     foreach($employees as $employee){
    //         foreach($document_types as $document_type){
    //             if($employee->document_type == $document_type->document_type){
    //                 $employee->document_type_id = $document_type->id;
    //             }
    //         }
    //         foreach($jobs as $job){
    //             if($employee->job == $job->id){
    //                 $employee->job_id = $job->id;
    //             }
    //         }
    //         $employee->save();
    //     }
    // }


}
