<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mycompany;

class MycompanyController extends Controller {

    public function index() {
        $data['my_company'] = Mycompany::findOrFail(1);
        return view('header_pdf', $data);
    }

    public function update_my_company(Request $request, $id) {

        $input_all = $request->all();

        $validator = Validator::make($request->all(), [
                    'tax_id_no' => 'required',
                    'name_th' => 'required',
                    'name_en' => 'required',
                    'address_th' => 'required',
                    'address_en' => 'required',
                    'tel' => 'required',
                    'with_holding_tax' => 'required'
        ]);

        $return['title'] = 'แก้ไขข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();
        try {
            Mycompany::where('id', $id)->update($input_all);

            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ไม่สำเร็จ' . $e->getMessage();
        }

        return $return;
    }

}
