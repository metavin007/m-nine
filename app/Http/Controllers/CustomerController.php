<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Item;
use App\Models\CustomerMainDealer;
use App\Models\CustomerMainPrice;
use Storage;

class CustomerController extends Controller {

    public function index() {
        return view('customer');
    }

    public function get_datatable() {
        $result = Customer::select();
        return \DataTables::of($result)
                        ->addIndexColumn()
                        ->editColumn('date_add', function($rec) {
                            return date_format_system($rec->date_add);
                        })
                        ->editColumn('date_update', function($rec) {
                            return date_format_system($rec->date_add);
                        })
                        ->addColumn('action', function($rec) {
                            $str = '
                           <a href="' . url('customer/pade_edit/' . $rec->id) . '" class="btn btn-warning">Edit</a>
                          <button type="button" class="btn btn-delete btn-danger" data-id="' . $rec->id . '" data-name="' . $rec->company_name_eng . '">Delete</button>    
                            ';
                            return $str;
                        })->make(true);
    }

    public function page_add() {
        $data['shippers'] = Dealer::orderBy('name', 'asc')->get();
        $data['items'] = Item::orderBy('particulars', 'asc')->get();
        return view('add_customer', $data);
    }

    public function insert(Request $request) {

        $input_all = $request->all();

        $select_shippers = $request->input('select_shipper');
        $select_items = $request->input('select_item');
        unset($input_all['select_shipper']);
        unset($input_all['select_item']);

        $input_all['date_add'] = date('Y-m-d H:i:s');
        $input_all['date_update'] = date('Y-m-d H:i:s');

        $validator = Validator::make($request->all(), [
                    'tax_id_no' => 'required',
                    'branch' => 'required',
                    'company_name_eng' => 'required',
                    'company_name_thai' => 'required',
                    'address_eng' => 'required',
                    'address_thai' => 'required',
        ]);


        $return['title'] = 'เพิ่มข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();
        try {

            $customer_id = Customer::insertGetId($input_all);

            if (count($select_shippers) > 0) {
                foreach ($select_shippers as $select_shipper) {
                    $select_shipper['customer_id'] = $customer_id;
                    CustomerMainDealer::insert($select_shipper);
                }
            }

            if (count($select_items) > 0) {
                foreach ($select_items as $select_item) {
                    $select_item['customer_id'] = $customer_id;
                    CustomerMainPrice::insert($select_item);
                }
            }

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
        $data['customer'] = Customer::findOrFail($id);
        $data['shippers'] = Dealer::orderBy('name', 'asc')->get();
        $data['items'] = Item::orderBy('particulars', 'asc')->get();
        $data['customer_main_dealers'] = CustomerMainDealer::with('dealer')->where('customer_id', '=', $id)->get();
        $data['customer_main_prices'] = CustomerMainPrice::with('item')->where('customer_id', '=', $id)->get();
        return view('edit_customer', $data);
    }

    public function update(Request $request, $id) {

        $input_all = $request->all();

        $select_shippers = $request->input('select_shipper');
        $select_items = $request->input('select_item');
        unset($input_all['select_shipper']);
        unset($input_all['select_item']);

        $input_all['date_update'] = date('Y-m-d H:i:s');

        $validator = Validator::make($request->all(), [
                    'tax_id_no' => 'required',
                    'branch' => 'required',
                    'company_name_eng' => 'required',
                    'company_name_thai' => 'required',
                    'address_eng' => 'required',
                    'address_thai' => 'required',
        ]);

        $return['title'] = 'แก้ไขข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();

        try {

            Customer::where('id', $id)->update($input_all);

            if (isset($select_shippers)) {
                if (count($select_shippers) > 0) {
                    foreach ($select_shippers as $select_shipper) {
                        if (isset($select_shipper['id'])) {
                            $select_shipper_id = $select_shipper['id'];
                            unset($select_shipper['id']);
                            CustomerMainDealer::where('id', $select_shipper_id)->delete();
                        } else {
                            $select_shipper['customer_id'] = $id;
                            CustomerMainDealer::insert($select_shipper);
                        }
                    }
                }
            }


            if (count($select_items) > 0) {
                foreach ($select_items as $select_item) {
                    if (isset($select_item['amount'])) {
                        if (isset($select_item['id'])) {
                            $select_item_id = $select_item['id'];
                            unset($select_item['id']);
                            CustomerMainPrice::where('id', $select_item_id)->delete();
                        } else if (isset($select_item['id_update'])) {
                            $select_item_id_update = $select_item['id_update'];
                            unset($select_item['id_update']);
                            CustomerMainPrice::where('id', $select_item_id_update)->update($select_item);
                        } else {
                            $select_item['customer_id'] = $id;
                            CustomerMainPrice::insert($select_item);
                        }
                    }
                }
            }

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
            Customer::where('id', $id)->delete();
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
