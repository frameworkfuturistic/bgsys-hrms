<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDesignation extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * | Get Designation by Designation Name
     */
    public function getDesignationByDesigName($designationName)
    {
        return RefDesignation::where('designation_name', $designationName)
            ->first();
    }

    /**
     * | Get Designation by Designation Code
     */
    public function getDesignCodeByDesigName($code)
    {
        return RefDesignation::where('designation_code', $code)
            ->first();
    }

    /**
     * | Get designation by designation name and id
     */
    public function getDesigByDesigName($req)
    {
        return RefDesignation::where('designation_name', $req->designationName)
            ->where('id', '!=', $req->designationId)
            ->first();
    }

    /**
     * | Get Designation by Designation Code
     */
    public function getDesignCodeByDesigNameId($req)
    {
        return RefDesignation::where('designation_code', $req->designationCode)
            ->where('id', '!=', $req->designationId)
            ->first();
    }

    /**
     * | Post New Designation
     */
    public function postDesignation($req)
    {
        RefDesignation::create([
            'designation_name' => $req->designationName,
            'designation_code' => $req->designationCode,
            'created_by' => $req->createdBy
        ]);
    }

    /**
     * | Edit Designation 
     */
    public function editDesignation($req)
    {
        $designation = RefDesignation::findOrFail($req->designationId);
        $designation->update([
            'designation_name' => $req->designationName,
            'designation_code' => $req->designationCode
        ]);
    }

    /**
     * | Get Designation LIsts
     */
    public function designationLists()
    {
        return RefDesignation::orderByDesc('id')
            ->where('status', 1)
            ->get();
    }
}
