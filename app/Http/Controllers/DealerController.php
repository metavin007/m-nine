<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dealer;
use Storage;

class DealerController extends Controller {

    public function index() {
        return view('shipper');
    }

    public function get_datatable() {
        $result = Dealer::select();
        return \DataTables::of($result)
                        ->addIndexColumn()
                        ->editColumn('date_add', function($rec) {
                            return date_format_system($rec->date_add);
                        })
                        ->editColumn('date_update', function($rec) {
                            return date_format_system($rec->date_update);
                        })
                        ->addColumn('action', function($rec) {
                            $str = '
                          <a href="' . url('shipper/pade_edit/' . $rec->id) . '" class="btn btn-warning">Edit</a>
                          <button type="button" class="btn btn-danger btn-delete" data-id="' . $rec->id . '" data-name="' . $rec->name . '">Delete</button>    
                            ';
                            return $str;
                        })->make(true);
    }

    public function page_add() {
        return view('add_shipper');
    }

    public function insert(Request $request) {

        $input_all = $request->all();
        $input_all['date_add'] = date('Y-m-d H:i:s');
        $input_all['date_update'] = date('Y-m-d H:i:s');

        $validator = Validator::make($request->all(), [
                    'group' => 'required',
                    'name' => 'required',
                    'ori' => 'required',
                    'dest' => 'required',
        ]);

        $return['title'] = 'เพิ่มข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();
        try {
            Dealer::insert($input_all);
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

    public function pade_edit($id) {
        $data['shipper'] = Dealer::findOrFail($id);
        return view('edit_shipper', $data);
    }

    public function update(Request $request, $id) {

        $input_all = $request->all();
        $input_all['date_update'] = date('Y-m-d H:i:s');

        $validator = Validator::make($request->all(), [
                    'group' => 'required',
                    'name' => 'required',
                    'ori' => 'required',
                    'dest' => 'required',
        ]);

        $return['title'] = 'แก้ไขข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();

        try {

            Dealer::where('id', $id)->update($input_all);

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

    public function delete($id) {
        $return['title'] = 'ลบข้อมูล';
        \DB::beginTransaction();
        try {
            Dealer::where('id', $id)->delete();
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
