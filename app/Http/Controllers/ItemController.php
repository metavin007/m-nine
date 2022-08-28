<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Storage;

class ItemController extends Controller {

    public function index() {
        return view('item');
    }

    public function get_datatable() {
        $result = Item::select();
        return \DataTables::of($result)
                        ->addIndexColumn()
                        ->editColumn('date_add', function($rec) {
                            return date_format_system($rec->date_add);
                        })
                        ->editColumn('date_update', function($rec) {
                            return date_format_system($rec->date_add);
                        })
                        ->editColumn('amount', function($rec) {
                            return number_format($rec->amount, 2);
                        })
                        ->editColumn('select_taxable', function($rec) {
                            if ($rec->select_taxable == 1) {
                                return 'Vat';
                            } else {
                                return 'Non vat';
                            }
                        })
                        ->addColumn('action', function($rec) {
                            $str = '
                          <a href="' . url('item/pade_edit/' . $rec->id) . '" class="btn btn-warning">Edit</a>
                          <button type="button" class="btn btn-danger btn-delete" data-id="' . $rec->id . '" data-name="' . $rec->code . '">Delete</button>    
                            ';
                            return $str;
                        })->make(true);
    }

    public function page_add() {
        return view('add_item');
    }

    public function insert(Request $request) {

        $input_all = $request->all();
        $input_all['date_add'] = date('Y-m-d H:i:s');
        $input_all['date_update'] = date('Y-m-d H:i:s');

        if (isset($input_all['select_taxable'])) {
            $input_all['select_taxable'] = 1;
        } else {
            $input_all['select_taxable'] = 0;
        }

        $validator = Validator::make($request->all(), [
                    'code' => 'required',
                    'particulars' => 'required',
                    'amount' => 'required',
        ]);


        $return['title'] = 'เพิ่มข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();
        try {
            Item::insert($input_all);
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
        $data['item'] = Item::findOrFail($id);
        return view('edit_item', $data);
    }

    public function update(Request $request, $id) {

        $input_all = $request->all();
        $input_all['date_update'] = date('Y-m-d H:i:s');

        if (isset($input_all['select_taxable'])) {
            $input_all['select_taxable'] = 1;
        } else {
            $input_all['select_taxable'] = 0;
        }

        $validator = Validator::make($request->all(), [
                    'code' => 'required',
                    'particulars' => 'required',
                    'amount' => 'required',
        ]);

        $return['title'] = 'แก้ไขข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();

        try {

            Item::where('id', $id)->update($input_all);

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
            Item::where('id', $id)->delete();
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
