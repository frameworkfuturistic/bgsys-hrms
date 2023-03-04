<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Models\Masters\RefDesignation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DesignationController extends Controller
{
    /**
     * | Created on-04-03-2023 
     * | Created By-Anshu Kumar
     * | Created For Designation Crud Operations
     */
    public $_model;
    public function __construct()
    {
        $this->_model = new RefDesignation();
    }

    /**
     * | Post New Designation
     */
    public function postDesignation(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "designationName" => "required|string",
            "designationCode" => "required|string"
        ]);

        if ($validator->fails())
            return response($validator->errors(), 422);

        try {
            $isDesignExist = $this->_model->getDesignationByDesigName($req->designationName);
            if ($isDesignExist)
                return responseMsg(false, "Designation Already Existing", "");
            $isCodeExist = $this->_model->getDesignCodeByDesigName($req->designationCode);

            if ($isCodeExist)
                return responseMsg(false, "Designation Code Already Existing", "");

            $req->merge(['createdBy' => auth()->user()->id]);
            $this->_model->postDesignation($req);
            return responseMsg(true, "Successfully Saved The Designation", "");
        } catch (Exception $e) {
            return responseMsg(false, $e->getMessage(), "");
        }
    }

    /**
     * | Edit Designation
     */
    public function editDesignation(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "designationId" => "required|numeric",
            "designationName" => "required|string",
            "designationCode" => "required|string"
        ]);

        if ($validator->fails())
            return response($validator->errors(), 422);

        try {
            $isDesignExist = $this->_model->getDesigByDesigName($req);
            if ($isDesignExist)
                return responseMsg(false, "Designation Already Existing", "");

            $isCodeExist = $this->_model->getDesignCodeByDesigNameId($req);
            if ($isCodeExist)
                return responseMsg(false, "Designation Code Already Existing", "");

            $this->_model->editDesignation($req);
            return responseMsg(true, "Successfully Updated the Designation", "");
        } catch (Exception $e) {
            return responseMsg(false, $e->getMessage(), "");
        }
    }

    /**
     * | Get Designation By Id
     */
    public function getDesigById(Request $req)
    {
        $validator = Validator::make($req->all(), [
            "designationId" => "required|numeric",
        ]);

        if ($validator->fails())
            return response($validator->errors(), 422);

        try {
            $designation = RefDesignation::findOrFail($req->designationId);
            return responseMsg(true, "Designation Details", remove_null($designation));
        } catch (Exception $e) {
            return responseMsg(false, $e->getMessage(), "");
        }
    }

    /**
     * | Get All Designation LIst
     */
    public function designationLists()
    {
        try {
            $designations = $this->_model->designationLists();
            return responseMsg(true, "Designation Lists", remove_null($designations));
        } catch (Exception $e) {
            return responseMsg(false, $e->getMessage(), "");
        }
    }
}
