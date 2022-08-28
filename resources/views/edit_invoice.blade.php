<x-app-layout>

    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Invoice</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('invoice') }}">Invoice</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('invoice/pade_edit') }}">Edit Invoice</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form id="FormEdit">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">Tax ID No : </label>
                                                </div>
                                                <div class="col-lg-4 col-4">
                                                    <input id="customer_tax_id_no" type="text" class="form-control" value="{{ $invoice->customer->tax_id_no }}" readonly=""> 
                                                </div>
                                                <div class="col-lg-4 col-4">
                                                    <input  id="branch" type="text" class="form-control" value="{{ $invoice->customer->branch }}" readonly="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">INVOICE NUMBER : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input name="invoice_number" value="{{ $invoice->invoice_number }}" type="text" placeholder="" class="form-control text-right"  readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" id="customer_id" name="customer_id">
                                                <option selected disabled="">กรุณาเลือก</option>
                                                @foreach($customers as $customer)
                                                @if($invoice->customer_id == $customer->id)
                                                <option value="{{ $customer->id }}" selected="">{{ $customer->company_name_eng }}</option>
                                                @else
                                                <option value="{{ $customer->id }}">{{ $customer->company_name_eng }}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">INVOICE DATE : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input id="date_add" 
                                                           type="text"
                                                           class="form-control text-right" 
                                                           value="{{ date('d-m-Y', strtotime($invoice->invoice_date)) }}" 
                                                           readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input id="customer_address" type="text" class="form-control" value="{{ $invoice->customer->address_eng }}" readonly="">   
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">Due Date : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input id="due_date" name="due_date" type="text" class="form-control text-right" value="{{ date('d-m-Y', strtotime($invoice->due_date)) }}" readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">Our Reference number : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input  name="our_reference_number" type="text" class="form-control " value="{{ $invoice->our_reference_number }}" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">Credit Terms : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <select class="form-control" id="credit_Terms" name="credit_Terms">
                                                        <option value="0" <?php
                                                        if ($invoice->credit_Terms == '0') {
                                                            echo 'selected';
                                                        }
                                                        ?>>-</option>
                                                        <option value="30" <?php
                                                        if ($invoice->credit_Terms == '30') {
                                                            echo 'selected';
                                                        }
                                                        ?>>30 Days</option>
                                                        <option value="60" <?php
                                                        if ($invoice->credit_Terms == '60') {
                                                            echo 'selected';
                                                        }
                                                        ?>>60 Days</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>       
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">HOUSE WAYBILL NUMBER : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input id="house_way_number" name="house_way_number" type="text" class="form-control" value="{{ $invoice->house_way_number }}"  readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">VESSEL/DATE : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input name="vessel_date" type="text" class="form-control" value="{{ $invoice->vessel_date }}" required=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-lg-6 col-6">
                                            <div class="form-group">
                                                <label for="dealer_id">เลือก shipper :</label>
                                                <select id="dealer_id" name="dealer_id" class="form-control select_dealer" disabled="">

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3 col-3">
                                            <div class="form-group">
                                                <label for="code">Marks and Numbers :</label>
                                                <input id="mark_and_numbers1" name="mark_and_numbers1" type="text" class="form-control" value="{{ $invoice->mark_and_numbers1 }}"  required=""> 
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-3">
                                            <div class="form-group">
                                                <label for="code">Description of Goods :(ช่อง 1:52 ตัว 2:26 ตัว)</label>
                                                <input name="description_of_goods1" type="text" class="form-control" value="{{ $invoice->description_of_goods1 }}"> 
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-2">
                                            <div class="form-group">
                                                <label for="code">No.of Packages :</label>
                                                <div class="input-group mb-3">
                                                    <input name="no_of_packages1" type="text" maxlength="52" class="form-control" value="{{ $invoice->no_of_packages1 }}">
                                                    <span class="input-group-text">Packages</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-2">
                                            <div class="form-group">
                                                <label for="code">ACT Weight :</label>
                                                <div class="input-group mb-3">
                                                    <input name="act_weight" type="text" class="form-control" value="{{ $invoice->act_weight }}"> 
                                                    <span class="input-group-text">KGM.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-2">
                                            <div class="form-group">
                                                <label for="code">Volume :</label>
                                                <div class="input-group mb-3">
                                                    <input name="volume" type="text" class="form-control" value="{{ $invoice->volume }}"> 
                                                    <span class="input-group-text">CBM.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>     
                                    <div class="row">
                                        <div class="col-md-3 col-3">
                                            <div class="form-group">
                                                <input  name="mark_and_numbers2" type="text" class="form-control" value="{{ $invoice->mark_and_numbers2 }}"> 
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-3">
                                            <div class="form-group">
                                                <input  name="description_of_goods2" type="text" maxlength="26" class="form-control" value="{{ $invoice->description_of_goods2 }}"> 
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-2">
                                            <div class="form-group">
                                                <div class="input-group mb-3">
                                                    <input  name="no_of_packages2" type="text" class="form-control" value="{{ $invoice->no_of_packages2 }}"> 
                                                    <span class="input-group-text">Packages</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 10%;" class="text-center">Action</th>
                                                            <th style="width: 20%;">CODE</th>
                                                            <th style="width: 30%;">PARTICULARS</th>
                                                            <th style="width: 20%;">AMOUNT(BAHT)</th>
                                                            <th style="width: 20%;">SELECT TAXABLE</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="body_item">
                                                        @if(count($invoice->invoice_detail) > 0)
                                                        @foreach($invoice->invoice_detail as $key=>$invoice_detail)
                                                        <tr class="row_item">
                                                            <td class="text-center"><input onchange="calcurate();" class="id_delete_item" type="checkbox" style="width: 24px;height: 24px;" name="select_item[{{$key}}][id]" value="{{ $invoice_detail->id }}"> Delete</td>
                                                            <td class="text-center code">{{ $invoice_detail->item->code }}</td>
                                                            <td class="text-left particulars">{{ $invoice_detail->item->particulars }}</td>
                                                            <td class="text-center ori"><input onchange="calcurate();" class="form-control text-right amount" name="select_item[{{$key}}][amount]" type="number" title="กรุณาระบุ" required="" value="{{ $invoice_detail->amount }}">
                                                                <input class="form-control text-right amount" name="select_item[{{$key}}][id_update]" type="hidden" title="กรุณาระบุ" required="" value="{{ $invoice_detail->id }}"></td>
                                                            <td class="text-center">
                                                                @if($invoice_detail->select_taxable == 1)
                                                                <input onchange="calcurate();" class="select_taxable" name="select_item[{{$key}}][select_taxable]" style="width: 30px; height: 30px;" type="checkbox" value="1" checked=""> vat
                                                                @else
                                                                <input onchange="calcurate();" class="select_taxable" name="select_item[{{$key}}][select_taxable]" style="width: 30px; height: 30px;" type="checkbox" value="1"> vat
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="text-center">
                                                            <td><button type="button" class="btn btn-info btn_add_item">Add Item</button></td>
                                                            <td colspan="4"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">Non Taxable Total : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input id="non_taxable_total" name="non_taxable_total" value="{{ $invoice->non_taxable_total }}" type="text" placeholder="" class="form-control text-right" readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>  
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">Taxable Total : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input id="taxable_total"  name="taxable_total" value="{{ $invoice->taxable_total }}" type="text" class="form-control text-right" readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">Total Amount : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input id="total_amount" name="total_amount" value="{{ $invoice->total_amount }}" type="text" class="form-control text-right" readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">VAT 7% : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input id="vat_7" name="vat_7" value="{{ $invoice->vat_7 }}" type="text" class="form-control text-right" readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">Grand Total : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input id="grand_total" name="grand_total" value="{{ $invoice->grand_total }}" type="text" class="form-control text-right" readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">With Holding Tax {{ $mycompany->with_holding_tax }} % : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <div class="form-group">
                                                        <div class="input-group mb-3">
                                                            <span class="input-group-text">
                                                                <input type="checkbox" 
                                                                       id="want_with_holding_tax_3" 
                                                                       onchange="calcurate();" 
                                                                       value="1" 
                                                                       style="width: 20px; height: 20px;"
                                                                       <?php
                                                                       if ($invoice->with_holding_tax_3 != 0) {
                                                                           echo 'checked';
                                                                       }
                                                                       ?>>
                                                                <input id="with_holding_tax_persent" type="hidden" placeholder="" class="form-control text-right" readonly="" value="{{ $mycompany->with_holding_tax }}">
                                                            </span>
                                                            <input id="with_holding_tax_3" name="with_holding_tax_3" value="{{ $invoice->with_holding_tax_3 }}" type="text" class="form-control text-right" readonly=""> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">Total Invoiced THB : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input id="total_invioced_thb" name="total_invioced_thb" value="{{ $invoice->total_invioced_thb }}" type="text" class="form-control text-right" readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-2 col-2">
                                                    <label class="col-form-label">AMOUNT : </label>
                                                </div>
                                                <div class="col-lg-6 col-6">
                                                    <input id="amount" name="amount" value="{{ $invoice->amount }}" type="text" class="form-control" readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-2 col-2">
                                                    <label class="col-form-label">Costs : </label>
                                                </div>
                                                <div class="col-lg-2 col-2">
                                                    <input id="costs" name="costs" value="{{ $invoice->costs }}" type="number" step="any" class="form-control text-right" required=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

    </div>

</x-app-layout>

<script>

    var id = '{{ $invoice->id }}';

    $('#customer_id').select2();
    function parseMDY(s) {
        var b = s.split("-");
        return new Date(b[2], b[1] - 1, b[0]);
    }
    function formatMDY(d) {
        function z(n) {
            return (n < 10 ? '0' : '') + n
        }
        if (isNaN(+d))
            return d.toString();
        return z(d.getDate()) + '-' + z(d.getMonth() + 1) + '-' + d.getFullYear();
    }
    function addDays(s, days) {
        var d = parseMDY(s);
        d.setDate(d.getDate() + Number(days));
        return formatMDY(d);
    }
    $('body').on('change', '#credit_Terms', function (e) {
        e.preventDefault();
        var date_next = addDays($('#date_add').val(), $('#credit_Terms').val());
        $('#due_date').val(date_next);
    });
    $('body').on('input', '#mark_and_numbers1', function (e) {
        e.preventDefault();
        $('#house_way_number').val($('#mark_and_numbers1').val());
    });

    var dealer_id = '{{ $invoice->dealer_id  }}';

    var index_item = 100;
    $('body').on('change', '#customer_id', function (e) {
        e.preventDefault();
        $.ajax({
            method: "GET",
            url: url_gb + "/invoice/get_data_by_customer_id/" + $(this).val(),
            dataType: 'json'
        }).done(function (rec) {

            $('#customer_tax_id_no').val(rec['customer'].tax_id_no);
            $('#branch').val(rec['customer'].branch);
            $('#customer_address').val(rec['customer'].address_eng);

            $('#dealer_id').removeAttr('disabled');
            $('#dealer_id').html('');
            $.each(rec['dealers'], function (index, value) {
                if (value.dealer_id == dealer_id) {
                    $('#dealer_id').append(`<option value="` + value.dealer_id + `" selected="">` + '<b>' + value.dealer.group + ' :</b> ' + value.dealer.name + ' &nbsp;&nbsp;<b>ORI :</b> ' + value.dealer.ori + ' &nbsp;&nbsp;<b>DEST :</b> ' + value.dealer.dest + `</option>`);
                } else {
                    $('#dealer_id').append(`<option value="` + value.dealer_id + `" >` + '<b>' + value.dealer.group + ' :</b> ' + value.dealer.name + ' &nbsp;&nbsp;<b>ORI :</b> ' + value.dealer.ori + ' &nbsp;&nbsp;<b>DEST :</b> ' + value.dealer.dest + `</option>`);
                }
            })
            $('.select_dealer').select2();

        }).fail(function () {
            Swal.fire({icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'กรุณาติดต่อผู้ดูแลระบบ !'});
        });
    });

    $('#customer_id').trigger('change');

    $('body').on('click', '.btn_add_item', function (e) {
        e.preventDefault();
        var btn_delete = '<td class="text-center"><button class="btn btn-danger btn_delete_item">Delete</button></td>';
        var code = `<td class="text-center code">
                                <select class="form-control select_item" name="select_item[` + index_item + `][item_id]" title="กรุณาระบุ" required="">
                                <option selected="" disabled="">กรุณาเลือก</option>
<?php foreach ($items as $item) { ?>       
                                                                                    <option 
                                                                                    value="<?php echo $item->id; ?>" 
                                                                                    data-particulars="<?php echo $item->particulars; ?>"
                                                                                    data-amount="<?php echo $item->amount; ?>"
                                                                                    data-select_taxable="<?php echo $item->select_taxable; ?>"    
                                                                                    ><?php echo $item->code; ?>
                                                                                    </option>
<?php } ?>
                                </select>    
                            </td>`;
        var particulars = '<td class="text-center particulars"></td>';
        var amount = '<td class="text-center"><input onchange="calcurate();" class="form-control text-right amount" name="select_item[' + index_item + '][amount]" type="number" title="กรุณาระบุ" required=""></td>';
        var select_taxable = '<td class="text-center"><input onchange="calcurate();" class="select_taxable" name="select_item[' + index_item + '][select_taxable]" style="width: 30px; height: 30px;" type="checkbox" value="1"> vat</td>';
        $('#body_item').append('<tr class="row_item">' + btn_delete + code + particulars + amount + select_taxable + '</tr>');
        index_item++;
        $('.select_item').select2();
    });
    $('body').on('click', '.btn_delete_item', function (e) {
        e.preventDefault();
        $(this).closest('.row_item').remove();
        calcurate();
    });
    $('body').on('change', '.select_item', function (e) {
        e.preventDefault();
        $(this).closest('.row_item').find('.particulars').html($(this).find(':selected').data('particulars'));
        $(this).closest('.row_item').find('.amount').val(Number($(this).find(':selected').data('amount')).toFixed(2));
        if ($(this).find(':selected').data('select_taxable') == 1) {
            $(this).closest('.row_item').find('.select_taxable').attr('checked', true);
        } else {
            $(this).closest('.row_item').find('.select_taxable').removeAttr('checked');
        }
        calcurate();
    });

    function calcurate() {
        var sum_nontax = 0;
        var sum_tax = 0;

        $(".row_item").each(function (i, e) {
            if (!$(e).find(".id_delete_item").is(':checked')) {
                if ($(e).find(".select_taxable").is(':checked')) {
                    sum_tax = sum_tax + Number($(e).find(".amount").val());
                } else {
                    sum_nontax = sum_nontax + Number($(e).find(".amount").val());
                }
            }
        });

        $('#non_taxable_total').val(parseFloat(sum_nontax).toFixed(2));
        $('#taxable_total').val(parseFloat(sum_tax).toFixed(2));
        $('#total_amount').val(parseFloat(sum_nontax + sum_tax).toFixed(2));

        var vat = parseFloat((sum_tax * 7) / 100).toFixed(2);
        $('#vat_7').val(vat);

        var grand_total = parseFloat(sum_nontax + sum_tax + Number(vat)).toFixed(2);
        $('#grand_total').val(grand_total);

        if ($('#want_with_holding_tax_3').is(':checked')) {
            var with_holding_tax_3 = parseFloat((sum_tax * $('#with_holding_tax_persent').val()) / 100).toFixed(2);
            $('#with_holding_tax_3').val(with_holding_tax_3);
        } else {
            var with_holding_tax_3 = 0;
            $('#with_holding_tax_3').val(with_holding_tax_3);
        }

        var total_invioced_thb = parseFloat(grand_total - with_holding_tax_3).toFixed(2);
        $('#total_invioced_thb').val(total_invioced_thb);

        get_text_amount();
    }

    function get_text_amount() {
        $.ajax({
            method: "GET",
            url: url_gb + "/invoice/chang_pice_to_text/" + $('#total_invioced_thb').val(),
            dataType: 'json'
        }).done(function (rec) {

            $('#amount').val(rec.text);

        }).fail(function () {
            Swal.fire({icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'กรุณาติดต่อผู้ดูแลระบบ !'});
        });
    }

    $('#FormEdit').validate({
        focusCleanup: true,
        rules: {
            customer_id: {
                required: true,
            },
            dealer_id: {
                required: true,
            },
            our_reference_number: {
                required: true,
            },
            vessel_date: {
                required: true,
            },
            mark_and_numbers1: {
                required: true,
            },
            costs: {
                required: true,
            },
        },
        messages: {
            customer_id: {
                required: 'กรุณาระบุ',
            },
            dealer_id: {
                required: 'กรุณาระบุ',
            },
            our_reference_number: {
                required: 'กรุณาระบุ',
            },
            vessel_date: {
                required: 'กรุณาระบุ',
            },
            mark_and_numbers1: {
                required: 'กรุณาระบุ',
            },
            costs: {
                required: 'กรุณาระบุ',
            },
        },
        errorPlacement: function (error, element) { // คำสั่งโชกล่องข้อความ
            error.addClass("text-danger");
            error.insertAfter(element);
        },
        highlight: function (element, errorClass, validClass) { // ใส่สีเมื่อเกิด error
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) { // ใส่สีเมื่อผ่าน error แล้ว;
            $(element).removeClass("is-invalid");
            $(element).addClass("is-valid");
        },
        submitHandler: function (form) {
            var btn = $(form).find('[type="submit"]');
            btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...').attr('disabled', true);
            $.ajax({
                method: "put",
                url: url_gb + "/invoice/update/" + id,
                dataType: 'json',
                data: $(form).serialize()
            }).done(function (rec) {
                if (rec.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: rec.title,
                        text: rec.content,
                    }).then(() => {
                        window.location.href = url_gb + '/invoice';
                    });
                } else {
                    Swal.fire({icon: 'error', title: rec.title, text: rec.content});
                }
            }).fail(function () {
                Swal.fire({icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'กรุณาติดต่อผู้ดูแลระบบ !'});
                btn.html('Save').attr('disabled', false);
            });
        }
    });
</script>