<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Mycompany;
use Storage;

class ReportController extends Controller {

    public function notification_invoice() {
        return view('notification_invoice');
    }

    public function get_datatable_notification_invoice(Request $request) {

        $date_search_start = $request->input('date_search_start');
        $date_search_end = $request->input('date_search_end');

        $result = Invoice::with('customer')->where('status', '=', 0)->select();

        if ($date_search_start && $date_search_end) {
            $date_search_start = date('Y-m-d', strtotime($date_search_start));
            $date_search_end = date('Y-m-d', strtotime("+1 day", strtotime($date_search_end)));
            $result->whereBetween('invoice_date', [$date_search_start, $date_search_end]);
        }

        return \DataTables::of($result)
                        ->addIndexColumn()
                        ->editColumn('invoice_date', function($rec) {
                            return date_format_system_not_time($rec->invoice_date);
                        })
                        ->editColumn('status', function($rec) {
                            return 'ค้างจ่าย';
                        })
                        ->editColumn('total_invioced_thb', function($rec) {
                            return number_format($rec->total_invioced_thb, 2);
                        })
                        ->make(true);
    }

    public function costs() {
        return view('costs');
    }

    public function get_datatable_costs(Request $request) {
        $date_search_start = $request->input('date_search_start');
        $date_search_end = $request->input('date_search_end');

        $result = Invoice::with('customer')->select();

        if ($date_search_start && $date_search_end) {
            $date_search_start = date('Y-m-d', strtotime($date_search_start));
            $date_search_end = date('Y-m-d', strtotime("+1 day", strtotime($date_search_end)));
            $result->whereBetween('invoice_date', [$date_search_start, $date_search_end]);
        }

        return \DataTables::of($result)
                        ->addIndexColumn()
                        ->editColumn('invoice_date', function($rec) {
                            return date_format_system_not_time($rec->invoice_date);
                        })
                        ->editColumn('costs', function($rec) {
                            return number_format($rec->costs, 2);
                        })
                        ->editColumn('non_taxable_total', function($rec) {
                            return number_format($rec->non_taxable_total, 2);
                        })
                        ->editColumn('taxable_total', function($rec) {
                            return number_format($rec->taxable_total, 2);
                        })
                        ->editColumn('profit', function($rec) {
                            return number_format($rec->non_taxable_total + $rec->taxable_total - $rec->costs, 2);
                        })
                        ->make(true);
    }

    public function report_standard() {
        $data['mycompany'] = Mycompany::first();
        return view('report_standard', $data);
    }

    public function get_datatable_report_standard(Request $request) {

        $date_search_start = $request->input('date_search_start');
        $date_search_end = $request->input('date_search_end');

        $result = Invoice::with('customer')->with('dealer')->with('receipt_detail.receipt')->select();

        if ($date_search_start && $date_search_end) {
            $date_search_start = date('Y-m-d', strtotime($date_search_start));
            $date_search_end = date('Y-m-d', strtotime("+1 day", strtotime($date_search_end)));
            $result->whereBetween('invoice_date', [$date_search_start, $date_search_end]);
        }

        return \DataTables::of($result)
                        ->addIndexColumn()
                        ->addColumn('bank', function($rec) {
                            return '';
                        })
                        ->editColumn('invoice_date', function($rec) {
                            return date_format_system_not_time($rec->invoice_date);
                        })
                        ->editColumn('receipt_detail.receipt.receipt_no', function($rec) {
                            if (!is_null($rec->receipt_detail) && !is_null($rec->receipt_detail->receipt)) {
                                return $rec->receipt_detail->receipt->receipt_no;
                            } else {
                                return '';
                            }
                        })
                        ->editColumn('receipt_detail.receipt.date_add', function($rec) {
                            if (!is_null($rec->receipt_detail) && !is_null($rec->receipt_detail->receipt)) {
                                return date_format_system_not_time($rec->receipt_detail->receipt->date_add);
                            } else {
                                return '';
                            }
                        })
                        ->editColumn('non_taxable_total', function($rec) {
                            return number_format($rec->non_taxable_total, 2);
                        })
                        ->editColumn('taxable_total', function($rec) {
                            return number_format($rec->taxable_total, 2);
                        })
                        ->editColumn('total_amount', function($rec) {
                            return number_format($rec->total_amount, 2);
                        })
                        ->editColumn('vat_7', function($rec) {
                            return number_format($rec->vat_7, 2);
                        })
                        ->editColumn('with_holding_tax_3', function($rec) {
                            return number_format($rec->with_holding_tax_3, 2);
                        })
                        ->editColumn('total_invioced_thb', function($rec) {
                            return number_format($rec->total_invioced_thb, 2);
                        })
                        ->make(true);
    }

}
