<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\SkillCreateRequest;

class SkillController extends Controller
{
    public function fetch(Request $request)
    {
    
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 10);

        $SkillQuery = Skill::query();



       if($id){
        $Skill = $SkillQuery->find($id);

        if($Skill){
            return ResponseFormatter::success($Skill, 'Skill Found');
        }

        return ResponseFormatter::error('Skill Not Found', '404');
       }

        
        $Skills = $SkillQuery;

        if ($name) {
            $Skills->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success(
            $Skills->paginate($limit),
            'Skills found'
        );
    }

    public function create(Request  $request)
    {
       try {

       $request->validate([
            'name' => 'required|string|max:255',
            'created_by' => 'required|integer'
        ]);

        $Skill = Skill::create([
            'name' => $request->name,
            'created_by' => $request->created_by
        ]);

        if (!$Skill) {
           throw new Exception('Skill Nout Found');
        }


        return ResponseFormatter::success($Skill, 'Skill Created');
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

            $Skill = Skill::find($id);
            if(!$Skill ){
                throw new Exception('Skill not Found');
            }


            $Skill->update([
                'name' => $request->name,
                'updated_by' => $request->updated_by
            ]);
            
            return ResponseFormatter::success($Skill, 'Skill Updated');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 500);
        }

    }

    public function destroy(Request $request, $id)
    {
        try {
            $Skill = Skill::find($id);

            if(!$Skill){
                throw new Exception('Skill Not Found');
            }
            $request->validate([
                'deleted_by' => 'required|integer'
            ]);
            $Skill->update([
                'deleted_by' => $request->deleted_by
            ]);
            $Skill->delete();
            return ResponseFormatter::success($Skill, 'Skill Deleted');
        } catch (\Throwable $th) {
            return ResponseFormatter::error($th->getMessage(), 500);
        }
    }
}
