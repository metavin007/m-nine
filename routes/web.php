<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Route::middleware(['auth'])->group(function () {

    Route::get('/', [App\Http\Controllers\ReportController::class, 'report_standard'])->name('report_standard');

    Route::get('profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::post('profile/change_to_white_mode', [App\Http\Controllers\ProfileController::class, 'change_to_white_mode'])->name('change_to_white_mode');
    Route::post('profile/change_to_dark_mode', [App\Http\Controllers\ProfileController::class, 'change_to_dark_mode'])->name('change_to_dark_mode');
    Route::post('profile/update_profile', [App\Http\Controllers\ProfileController::class, 'update_profile']);
    Route::post('profile/change_password_profile', [App\Http\Controllers\ProfileController::class, 'change_password_profile']);

    Route::get('notification_invoice', [App\Http\Controllers\ReportController::class, 'notification_invoice'])->name('notification_invoice');
    Route::get('notification_invoice/get_datatable_notification_invoice', [App\Http\Controllers\ReportController::class, 'get_datatable_notification_invoice']);

    Route::get('costs', [App\Http\Controllers\ReportController::class, 'costs'])->name('costs');
    Route::get('costs/get_datatable_costs', [App\Http\Controllers\ReportController::class, 'get_datatable_costs']);

    Route::get('report_standard', [App\Http\Controllers\ReportController::class, 'report_standard'])->name('report_standard');
    Route::get('report_standard/get_datatable_report_standard', [App\Http\Controllers\ReportController::class, 'get_datatable_report_standard']);

    Route::get('header_pdf', [App\Http\Controllers\MycompanyController::class, 'index'])->name('header_pdf');
    Route::put('header_pdf/update_my_company/{id}', [App\Http\Controllers\MycompanyController::class, 'update_my_company']);

    Route::get('shipper', [App\Http\Controllers\DealerController::class, 'index'])->name('shipper');
    Route::get('shipper/get_datatable', [App\Http\Controllers\DealerController::class, 'get_datatable']);
    Route::get('shipper/page_add', [App\Http\Controllers\DealerController::class, 'page_add']);
    Route::post('shipper/insert', [App\Http\Controllers\DealerController::class, 'insert']);
    Route::get('shipper/pade_edit/{id}', [App\Http\Controllers\DealerController::class, 'pade_edit']);
    Route::put('shipper/update/{id}', [App\Http\Controllers\DealerController::class, 'update']);
    Route::delete('shipper/delete/{id}', [App\Http\Controllers\DealerController::class, 'delete']);

    Route::get('item', [App\Http\Controllers\ItemController::class, 'index'])->name('item');
    Route::get('item/get_datatable', [App\Http\Controllers\ItemController::class, 'get_datatable']);
    Route::get('item/page_add', [App\Http\Controllers\ItemController::class, 'page_add']);
    Route::post('item/insert', [App\Http\Controllers\ItemController::class, 'insert']);
    Route::get('item/pade_edit/{id}', [App\Http\Controllers\ItemController::class, 'pade_edit']);
    Route::put('item/update/{id}', [App\Http\Controllers\ItemController::class, 'update']);
    Route::delete('item/delete/{id}', [App\Http\Controllers\ItemController::class, 'delete']);

    Route::get('customer', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer');
    Route::get('customer/get_datatable', [App\Http\Controllers\CustomerController::class, 'get_datatable']);
    Route::get('customer/page_add', [App\Http\Controllers\CustomerController::class, 'page_add']);
    Route::post('customer/insert', [App\Http\Controllers\CustomerController::class, 'insert']);
    Route::get('customer/pade_edit/{id}', [App\Http\Controllers\CustomerController::class, 'pade_edit']);
    Route::put('customer/update/{id}', [App\Http\Controllers\CustomerController::class, 'update']);
    Route::delete('customer/delete/{id}', [App\Http\Controllers\CustomerController::class, 'delete']);

    Route::get('invoice', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoice');
    Route::get('invoice/get_datatable', [App\Http\Controllers\InvoiceController::class, 'get_datatable']);
    Route::get('invoice/page_add', [App\Http\Controllers\InvoiceController::class, 'page_add']);
    Route::get('invoice/get_data_by_customer_id/{customer_id}', [App\Http\Controllers\InvoiceController::class, 'get_data_by_customer_id']);
    Route::get('invoice/chang_pice_to_text/{price}', [App\Http\Controllers\InvoiceController::class, 'chang_pice_to_text']);
    Route::post('invoice/insert', [App\Http\Controllers\InvoiceController::class, 'insert']);
    Route::get('invoice/pade_edit/{id}', [App\Http\Controllers\InvoiceController::class, 'pade_edit']);
    Route::put('invoice/update/{id}', [App\Http\Controllers\InvoiceController::class, 'update']);
    Route::get('invoice/export_for_pdf/{id}/{copy?}', [App\Http\Controllers\InvoiceController::class, 'export_for_pdf']);
    Route::get('invoice/get_date_by_invoice_id/{id}', [App\Http\Controllers\InvoiceController::class, 'get_date_by_invoice_id']);
    Route::put('invoice/update_date_by_invoice_id/{id}', [App\Http\Controllers\InvoiceController::class, 'update_date_by_invoice_id']);

    Route::get('receipt', [App\Http\Controllers\ReceiptController::class, 'index'])->name('receipt');
    Route::get('receipt/get_datatable', [App\Http\Controllers\ReceiptController::class, 'get_datatable']);
    Route::get('receipt/get_data_by_customer_id/{customer_id}', [App\Http\Controllers\ReceiptController::class, 'get_data_by_customer_id']);
    Route::get('receipt/page_add', [App\Http\Controllers\ReceiptController::class, 'page_add']);
    Route::post('receipt/insert', [App\Http\Controllers\ReceiptController::class, 'insert']);
    Route::delete('receipt/delete/{id}', [App\Http\Controllers\ReceiptController::class, 'delete']);
    Route::get('receipt/export_for_pdf/{id}/{copy?}', [App\Http\Controllers\ReceiptController::class, 'export_for_pdf']);
    Route::get('receipt/get_date_by_receipt_id/{id}', [App\Http\Controllers\ReceiptController::class, 'get_date_by_receipt_id']);
    Route::put('receipt/update_date_by_receipt_id/{id}', [App\Http\Controllers\ReceiptController::class, 'update_date_by_receipt_id']);
    
});

Route::get('/testlot', function () {
    return view('testlot');
});

require __DIR__ . '/auth.php';
