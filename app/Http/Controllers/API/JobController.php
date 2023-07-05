<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    public function fetch(Request $request)
    {
    
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        $JobQuery = Job::query();



       if($id){
        $Job = $JobQuery->find($id);

        if($Job){
            return ResponseFormatter::success($Job, 'Job Found');
        }

        return ResponseFormatter::error('Job Not Found', '404');
       }

        
        $Jobs = $JobQuery;

        if ($name) {
            $Jobs->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success(
            $Jobs->paginate($limit),
            'Jobs found'
        );
    }

    public function create(Request  $request)
    {
       try {

       $request->validate([
            'name' => 'required|string|max:255',
            'created_by' => 'required|integer'
        ]);

        $Job = Job::create([
            'name' => $request->name,
            'created_by' => $request->created_by
        ]);

        if (!$Job) {
           throw new Exception('Job Nout Found');
        }


        return ResponseFormatter::success($Job, 'Job Created');
       } catch (\Throwable $th) {
        return ResponseFormatter::error($th->getMessage(), 500);
       }
    }


    public function update(Request $request, $id)
    {
       
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'updated_by' => 'required|integer'
            ]);

            $Job = Job::find($id);
            if(!$Job ){
                throw new Exception('Job not Found');
            }


            $Job->update([
                'name' => $request->name,
                'updated_by' => $request->updated_by
            ]);
            
            return ResponseFormatter::success($Job, 'Job Updated');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 500);
        }

    }

    public function destroy(Request $request, $id)
    {
        try {
            $Job = Job::find($id);

            if(!$Job){
                throw new Exception('Job Not Found');
            }
            $request->validate([
                'deleted_by' => 'required|integer'
            ]);
            $Job->update([
                'deleted_by' => $request->deleted_by
            ]);
            $Job->delete();
            return ResponseFormatter::success($Job, 'Job Deleted');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 500);
        }
    }
}
