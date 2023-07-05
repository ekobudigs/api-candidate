<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class CandidateController extends Controller
{
    public function fetch(Request $request)
    {
    
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        $CandidateQuery = Candidate::query();



       if($id){
        $Candidate = $CandidateQuery->find($id);

        if($Candidate){
            return ResponseFormatter::success($Candidate, 'Candidate Found');
        }

        return ResponseFormatter::error('Candidate Not Found', '404');
       }

        
        $Candidates = $CandidateQuery;

        if ($name) {
            $Candidates->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success(
            $Candidates->paginate($limit),
            'Candidates found'
        );
    }

    public function create(Request  $request)
    {
       try {
        $customMessages = [
            'email.required' => 'Entry email wajib diisi.',
        ];
       $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email|unique:candidates',
            'phone' => 'required|integer|unique:candidates,phone',
            'year' => 'required|integer',
            'job_id' => 'required|integer',
            'created_by' => 'required|integer'
        ], $customMessages);

        $Candidate = Candidate::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'year' => $request->year,
            'job_id' => $request->job_id,
            'created_by' => $request->created_by
        ]);

        if (!$Candidate) {
           throw new Exception('Candidate Nout Found');
        }


        return ResponseFormatter::success($Candidate, 'Candidate Created');
       } catch (\Throwable $th) {
        return ResponseFormatter::error($th->getMessage(), 500);
       }
    }


    public function update(Request $request, $id)
    {
       
        try {
            $customMessages = [
                'email.required' => 'Entry email wajib diisi.',
            ];
           $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|max:255|email|unique:candidates',
                'phone' => 'required|integer',
                'year' => 'required|integer',
                'job_id' => 'required|integer',
                'updated_by' => 'required|integer'
            ], $customMessages);

            $Candidate = Candidate::find($id);
            if(!$Candidate ){
                throw new Exception('Candidate not Found');
            }


            $Candidate->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'year' => $request->year,
                'job_id' => $request->job_id,
                'updated_by' => $request->updated_by
            ]);
            
            return ResponseFormatter::success($Candidate, 'Candidate Updated');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 500);
        }

    }

    public function destroy(Request $request, $id)
    {
        try {
            $Candidate = Candidate::find($id);

            if(!$Candidate){
                throw new Exception('Candidate Not Found');
            }
            $request->validate([
                'deleted_by' => 'required|integer'
            ]);
            $Candidate->update([
                'deleted_by' => $request->deleted_by
            ]);
            $Candidate->delete();
            return ResponseFormatter::success($Candidate, 'Candidate Deleted');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 500);
        }
    }
}
