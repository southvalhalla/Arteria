<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeesRequest;
use App\Models\Document_type;
use App\Models\Job;
use App\Models\Employees;

use Illuminate\Http\Request;

use \FPDF;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_REQUEST['num'])){
            $_REQUEST['num'] = $_REQUEST['num']!=''|!empty($_REQUEST['num'])?$_REQUEST['num']:1;
            $page = $_REQUEST['num'];
        }else{
            $page=1;
        }
        $viewRows = 5;
        $begin = is_numeric($page)?(($page-1)*$viewRows):0;
        $employees = Employees::orderBy('id', 'DESC')->skip($begin)->take($viewRows)->get();
        $rows = Employees::orderBy('id','asc')->count();


        $prev = $page - 1;
        $next = $page + 1;
        $end = ceil($rows/$viewRows);

        $document_types = Document_type::orderBy('id', 'ASC')->get();
        $jobs = Job::orderBy('id', 'ASC')->get();


        return view('employees.index', [
            'employees' => $employees,
            'document_types' => $document_types,
            'jobs' => $jobs,
            'prev' => $prev,
            'next' => $next,
            'end' => $end,
            'page' => $page
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeesRequest $request)
    {
        // Employees::create([
        //     'document_type_id' => $request->document_type_id,
        //     'document_number' => $request->document_number,
        //     'names' => $request->names,
        //     'lastnames' => $request->lastnames,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'job_id' => $request->job_id
        // ]);

        Employees::create($request->all());

        return redirect()->route('employees.index')->with('success', 'Empleado creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employees::find($id);
        $document_types = Document_type::orderBy('id', 'ASC')->get();
        $jobs = Job::orderBy('id', 'ASC')->get();

        return view('employees.detail',[
            'employee' => $employee,
            'document_types' => $document_types,
            'jobs' => $jobs,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeesRequest $request, $id)
    {
        Employees::find($id)->update([
            'document_type_id' => $request->document_type,
            'document_number' => $request->document_number,
            'names' => $request->names,
            'lastnames' => $request->lastnames,
            'email' => $request->email,
            'phone' => $request->phone,
            'job_id' => $request->job
        ]);

        return redirect()->route('employees.index')->with('success', 'Empleado modificado correctamente.');
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
        return redirect()->route('employees.index')->with('success', 'Empleado '.$employee->id.' elimininado correctamente.');
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
