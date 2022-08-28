<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Mycompany;
use App\Models\Customer;
use App\Models\Dealer;
use App\Models\Item;
use App\Models\CustomerMainDealer;
use App\Models\CustomerMainPrice;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller {

    public function index() {
        return view('invoice');
    }

    public function get_datatable() {
        $result = Invoice::select();
        return \DataTables::of($result)
                        ->addIndexColumn()
                        ->editColumn('invoice_date', function($rec) {
                            return date_format_system($rec->invoice_date);
                        })
                        ->editColumn('date_update', function($rec) {
                            return date_format_system($rec->date_update);
                        })
                        ->editColumn('status', function($rec) {
                            if ($rec->status == 1) {
                                return 'จ่ายแล้ว';
                            } else {
                                return 'ค้างจ่าย';
                            }
                        })
                        ->addColumn('action', function($rec) {
                            $str = '
                          <a href="' . url('/invoice/export_for_pdf/' . $rec->id) . '" class="btn btn-info" target="_blank">ต้นฉบับ</a>                   
                          <a href="' . url('/invoice/pade_edit/' . $rec->id) . '" class="btn btn-edit btn-warning">Edit</a>    
                            ';
//                            <a href="' . url('/invoice/export_for_pdf/' . $rec->id . '/1') . '" class="btn btn-info" target="_blank">สำเนา</a>
                            return $str;
                        })->make(true);
    }

    public function page_add() {
        $data['mycompany'] = Mycompany::first();
        $data['customers'] = Customer::orderBy('company_name_eng', 'asc')->get();
        $data['items'] = Item::orderBy('code', 'asc')->get();
        $id_last_ar = \DB::select('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "lnwlnw_mnine" AND TABLE_NAME = "tb_invoice";');
        $id_last = $id_last_ar[0]->AUTO_INCREMENT;
        if (date('Ym') != substr($id_last, 0, 6)) {
            $data['code'] = "0001";
        } else {
            $data['code'] = substr($id_last, 6);
        }
        return view('add_invoice', $data);
    }

    public function get_data_by_customer_id($customer_id) {
        $result['customer'] = Customer::where('id', $customer_id)->first();
        $result['dealers'] = CustomerMainDealer::with('dealer')->where('customer_id', $customer_id)->get();
        $result['items'] = CustomerMainPrice::with('item')->where('customer_id', $customer_id)->get();
        return json_encode($result);
    }

    public function chang_pice_to_text($price) {
        $price = str_replace(',', '', number_format($price, 2));
        $result['text'] = bahtEng($price);
        return json_encode($result);
    }

    public function insert(Request $request) {

        $input_all = $request->all();

        $id_last_ar = \DB::select('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "lnwlnw_mnine" AND TABLE_NAME = "tb_invoice";');
        $id_last = $id_last_ar[0]->AUTO_INCREMENT;
        if (date('Ym') != substr($id_last, 0, 6)) {
            $code = "0001";
        } else {
            $code = substr($id_last, 6);
        }
        $input_all['id'] = date('Ym') . $code;
        $input_all['invoice_date'] = date('Y-m-d H:i:s');
        $input_all['date_update'] = date('Y-m-d H:i:s');
        $input_all['status'] = 0;

        if (isset($input_all['due_date'])) {
            $input_all['due_date'] = date('Y-m-d H:i:s', strtotime($input_all['due_date']));
        }

        unset($input_all['select_item']);
        $select_items = $request->input('select_item');

        $validator = Validator::make($request->all(), [
                    'customer_id' => 'required',
                    'dealer_id' => 'required',
                    'our_reference_number' => 'required',
                    'vessel_date' => 'required',
                    'mark_and_numbers1' => 'required',
                    'costs' => 'required',
        ]);


        $return['title'] = 'เพิ่มข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();
        try {

            $invoice_id = Invoice::insertGetId($input_all);

            if (isset($select_items)) {
                if (count($select_items) > 0) {
                    foreach ($select_items as $key => $select_item) {
                        $select_item['invoice_id'] = $invoice_id;
                        if (isset($select_item['select_taxable'])) {
                            $select_item['select_taxable'] = 1;
                        } else {
                            $select_item['select_taxable'] = 0;
                        }
                        InvoiceDetail::insert($select_item);
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

    public function pade_edit($id) {
        $data['invoice'] = Invoice::with('invoice_detail')->with('customer')->with('dealer')->findOrFail($id);
        $data['mycompany'] = Mycompany::first();
        $data['customers'] = Customer::orderBy('company_name_eng', 'asc')->get();
        $data['items'] = Item::orderBy('code', 'asc')->get();
        return view('edit_invoice', $data);
    }

    public function update(Request $request, $id) {

        $input_all = $request->all();
        $input_all['date_update'] = date('Y-m-d H:i:s');

        if (isset($input_all['due_date'])) {
            $input_all['due_date'] = date('Y-m-d H:i:s', strtotime($input_all['due_date']));
        }

        unset($input_all['select_item']);
        $select_items = $request->input('select_item');

        $validator = Validator::make($request->all(), [
                    'customer_id' => 'required',
                    'dealer_id' => 'required',
                    'our_reference_number' => 'required',
                    'vessel_date' => 'required',
                    'mark_and_numbers1' => 'required',
                    'costs' => 'required',
        ]);

        $return['title'] = 'แก้ไขข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();

        try {

            Invoice::where('id', $id)->update($input_all);

            if (count($select_items) > 0) {
                foreach ($select_items as $select_item) {
                    if (isset($select_item['amount'])) {
                        if (isset($select_item['id'])) {
                            $select_item_id = $select_item['id'];
                            unset($select_item['id']);
                            InvoiceDetail::where('id', $select_item_id)->delete();
                        } else if (isset($select_item['id_update'])) {
                            $select_item_id_update = $select_item['id_update'];
                            unset($select_item['id_update']);
                            InvoiceDetail::where('id', $select_item_id_update)->update($select_item);
                        } else {
                            $select_item['invoice_id'] = $id;
                            InvoiceDetail::insert($select_item);
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

    public function export_for_pdf($id, $copy = null) {

        if (isset($copy)) {
            $data['copy'] = 1;
        } else {
            $data['original'] = 1;
        }
        $data['mycompany'] = Mycompany::first();
        $data['invoice'] = Invoice::with('customer')->with('dealer')->with('invoice_detail')->where('id', $id)->first();
        if (isset($copy)) {
            $pdf = PDF::loadView('pdf.pdf_invoice_body_copy', $data);
        } else {
            $pdf = PDF::loadView('pdf.pdf_invoice_body', $data);
        }
        return $pdf->stream($data['invoice']->invoice_number . '.pdf', $data);
    }

}
