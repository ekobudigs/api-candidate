<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\SkillSet;
use App\Models\SkillSetSet;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class SkillSetController extends Controller
{
    public function fetch(Request $request)
    {
    
        $id = $request->input('id');

        $SkillSetQuery = SkillSet::query();



       if($id){
        $SkillSet = $SkillSetQuery->find($id);

        if($SkillSet){
            return ResponseFormatter::success($SkillSet, 'SkillSet Found');
        }

        return ResponseFormatter::error('SkillSet Not Found', '404');
       }

        
        
    }

    public function create(Request  $request)
    {
       try {

       $request->validate([
            'candidate_id' => 'required|integer',
            'skill_id' => 'required|integer'
        ]);

        $SkillSet = SkillSet::create([
            'candidate_id' => $request->candidate_id,
            'skill_id' => $request->skill_id
        ]);

        if (!$SkillSet) {
           throw new Exception('SkillSet Nout Found');
        }


        return ResponseFormatter::success($SkillSet, 'SkillSet Created');
       } catch (\Throwable $th) {
        return ResponseFormatter::error($th->getMessage(), 500);
       }
    }


    public function update(Request $request, $id)
    {
       
        try {
            $request->validate([
                'candidate_id' => 'required|integer',
                'skill_id' => 'required|integer'
            ]);

            $SkillSet = SkillSet::find($id);
            if(!$SkillSet ){
                throw new Exception('SkillSet not Found');
            }


            $SkillSet->update([
                'candidate_id' => $request->candidate_id,
                'skill_id' => $request->skill_id
            ]);
            
            return ResponseFormatter::success($SkillSet, 'SkillSet Updated');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 500);
        }

    }

    public function destroy(Request $request, $id)
    {
        try {
            $SkillSet = SkillSet::find($id);

            if(!$SkillSet){
                throw new Exception('SkillSet Not Found');
            }
            $request->validate([
                'deleted_by' => 'required|integer'
            ]);
            $SkillSet->update([
                'deleted_by' => $request->deleted_by
            ]);
            $SkillSet->delete();
            return ResponseFormatter::success($SkillSet, 'SkillSet Deleted');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 500);
        }
    }
}
