<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Receipt;
use App\Models\ReceiptDetail;
use App\Models\Mycompany;
use App\Models\Customer;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller {

    public function index() {
        return view('receipt');
    }

    public function get_datatable() {
        $result = Receipt::select();
        return \DataTables::of($result)
                        ->addIndexColumn()
                        ->editColumn('date_add', function($rec) {
                            return date_format_system($rec->date_add);
                        })
                        ->editColumn('date_update', function($rec) {
                            return date_format_system($rec->date_add);
                        })
                        ->editColumn('net', function($rec) {
                            return number_format($rec->net, 2);
                        })
                        ->addColumn('action', function($rec) {
                            $str = '
                          <a href="' . url('/receipt/export_for_pdf/' . $rec->id) . '" class="btn btn-info" target="_blank">ต้นฉบับ</a>
                          <a href="' . url('/receipt/export_for_pdf/' . $rec->id . '/1') . '" class="btn btn-info" target="_blank">สำเนา</a>    
                          <button type="button" class="btn btn-delete btn-danger" data-id="' . $rec->id . '" data-name="' . $rec->receipt_no . '">Delete</button>
                          <button type="button" class="btn btn-edit_date btn-warning" data-id="' . $rec->id . '">แก้ไขวันที่</button>    
                            ';
                            return $str;
                        })->make(true);
    }

    public function page_add() {
        $data['mycompany'] = Mycompany::first();
        $data['customers'] = Customer::orderBy('company_name_thai', 'asc')->get();
        $id_last_ar = \DB::select('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "lnwlnw_mnine" AND TABLE_NAME = "tb_receipt";');
        $id_last = $id_last_ar[0]->AUTO_INCREMENT;
        if (date('Ym') != substr($id_last, 0, 6)) {
            $data['code'] = "0001";
        } else {
            $data['code'] = substr($id_last, 6);
        }
        return view('add_receipt', $data);
    }

    public function get_data_by_customer_id($customer_id) {
        $result['customer'] = Customer::with('invoice')->where('id', $customer_id)->first();
        return json_encode($result);
    }

    public function insert(Request $request) {

        $input_all = $request->all();

        $id_last_ar = \DB::select('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = "lnwlnw_mnine" AND TABLE_NAME = "tb_receipt";');
        $id_last = $id_last_ar[0]->AUTO_INCREMENT;
        if (date('Ym') != substr($id_last, 0, 6)) {
            $code = "0001";
        } else {
            $code = substr($id_last, 6);
        }
        $input_all['id'] = date('Ym') . $code;
        $input_all['date_add'] = date('Y-m-d H:i:s');
        $input_all['date_update'] = date('Y-m-d H:i:s');

        if ($input_all['payment_type'] == 'cash') {
            $input_all['payment_type'] = 'เงินสด Cash';
        }
        if ($input_all['payment_type'] == 'chqu_bank') {
            $input_all['payment_type'] = 'เช็คธนาคาร CHQUE BANK';
        }
        if ($input_all['payment_type'] == 'tranfer') {
            $input_all['payment_type'] = 'โอนเงินเข้าบัญชี้';
        }

        unset($input_all['select_item']);
        $select_items = $request->input('select_item');

        $validator = Validator::make($request->all(), [
                    'customer_id' => 'required',
                    'receipt_no' => 'required',
                    'net' => 'required',
        ]);


        $return['title'] = 'เพิ่มข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();
        try {

            $receipt_id = Receipt::insertGetId($input_all);

            if (isset($select_items)) {
                if (count($select_items) > 0) {
                    foreach ($select_items as $key => $select_item) {
                        if (isset($select_item['want_invoice'])) {
                            unset($select_item['want_invoice']);
                            $select_item['receipt_id'] = $receipt_id;
                            ReceiptDetail::insert($select_item);
                            Invoice::where('id', $select_item['invoice_id'])->update(['status' => 1]);
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

            $receipt_details = ReceiptDetail::where('receipt_id', $id)->get();

            if (count($receipt_details) > 0) {
                foreach ($receipt_details as $receipt_detail) {
                    Invoice::where('id', $receipt_detail->invoice_id)->update(['status' => 0]);
                }
            }

            Receipt::where('id', $id)->delete();

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
        $data['receipt'] = Receipt::with('customer')->with('receipt_detail')->where('id', $id)->first();
        if (isset($copy)) {
            $pdf = PDF::loadView('pdf.pdf_receipt_body_copy', $data);
        } else {
            $pdf = PDF::loadView('pdf.pdf_receipt_body', $data);
        }
        return $pdf->stream($data['receipt']->receipt_no . '.pdf', $data);
    }

    public function get_date_by_receipt_id($id) {
        $result = Receipt::where('id', $id)->selectRaw(\DB::raw('DATE_FORMAT(date_add, "%d-%m-%Y") as date_add'))->first();
        return json_encode($result);
    }

    public function update_date_by_receipt_id(Request $request, $id) {

        $date_add = $request->input('date_add');

        $validator = Validator::make($request->all(), [
                    'date_add' => 'required',
        ]);

        if (isset($date_add)) {
            $date_add = date('Y-m-d', strtotime($date_add));
        }

        $return['title'] = 'แก้ไขข้อมูล';

        if ($validator->fails()) {
            $return['status'] = 0;
            $return['content'] = $validator->errors()->first();
            return $return;
        }

        \DB::beginTransaction();

        try {

            Receipt::where('id', $id)->update(['date_add' => $date_add]);

            \DB::commit();
            $return['status'] = 1;
            $return['content'] = 'สำเร็จ';
        } catch (Exception $e) {
            \DB::rollBack();
            $return['status'] = 0;
            $return['content'] = 'ติด Validation : ' . json_encode($validator->failed());
        }

        return $return;
    }

}
