<x-app-layout>

    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Create Receipt</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('receipt') }}">Receipt</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('receipt/page_add') }}">Create Receipt</a></li>
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
                                <form id="FormAdd">
                                    <div class="row">
                                        <div class="col-md-6">

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">Receipt No. </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input  name="receipt_no" 
                                                            type="text" 
                                                            class="form-control text-right" 
                                                            value="<?PHP
                                                            $year = date("Y", time());
                                                            $month = date("m", time());
                                                            echo "RV" . $year . $month . "-" . sprintf("%03d", $code);
                                                            ?>" 
                                                            > 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">DATE / วันที่ : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <input type="text" placeholder="" class="form-control text-right" value="<?php echo date('d-m-Y', time()); ?>" readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">ได้รับเงินจาก : </label>
                                                </div>
                                                <div class="col-lg-8 col-8">
                                                    <select class="form-control" id="customer_id" name="customer_id">
                                                        <option selected disabled="">กรุณาเลือก</option>  
                                                        @foreach($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->company_name_thai }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">Tax ID No : </label>
                                                </div>
                                                <div class="col-lg-4 col-4">
                                                    <input  id="tax_id_no" type="text" class="form-control"  readonly=""> 
                                                </div>
                                                <div class="col-lg-4 col-4">
                                                    <input  id="branch" type="text" placeholder="" class="form-control" readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-3 col-3">
                                                    <label class="col-form-label">Received from : </label>
                                                </div>
                                                <div class="col-lg-9 col-9">
                                                    <input  id="company_name_eng" type="text" class="form-control" readonly=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-3 col-3">
                                                    <label class="col-form-label">Address : </label>
                                                </div>
                                                <div class="col-lg-9 col-9">
                                                    <input  id="address_thai" type="text" class="form-control" readonly=""> 
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
                                                            <th>Received for Invoice No. / ได้รับเงินตามใบแจ้งหนี้เลขที่</th>
                                                            <th>Amount Non Vat</th>
                                                            <th>Amount Vat 7%</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="body_item">

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td class="text-right">รวม</td>
                                                            <td class="text-center"><input name="sum_amount_non_vat" id="sum_amount_non_vat" value="0" type="text" class="form-control text-right" readonly=""></td>
                                                            <td class="text-center"><input name="sum_amount_vat" id="sum_amount_vat" value="0" type="text" class="form-control text-right" readonly=""></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right">VAT 7%</td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"><input name="sum_vat_7" id="sum_vat_7" value="0" type="text" class="form-control text-right" readonly=""></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right">With Holding Tax {{ $mycompany->with_holding_tax }} %</td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"><input name="sum_holding_vat_3" id="sum_holding_vat_3" value="0" type="text" class="form-control text-right" readonly=""></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right">จำนวนเงินรวมทั้งสิ้น</td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"><input name="net" id="net" value="0" type="text" class="form-control text-right" readonly=""></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center" colspan="2"><input name="net_text" id="net_text" type="text" class="form-control " readonly=""></td>
                                                            <td class="text-center"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-1 col-1">
                                                    <input id="cash"  name="payment_type" onclick="check_typepayment();" type="radio"  value="cash" style="width: 20px; height: 20px;" checked=""> 
                                                </div>
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">เงินสด Cash : </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-1 col-1">
                                                    <input  id="chqu_bank" name="payment_type" onclick="check_typepayment();" type="radio"  value="chqu_bank" style="width: 20px; height: 20px;"> 
                                                </div>
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">เช็คธนาคาร CHQUE BANK : </label>
                                                </div>
                                                <div class="col-lg-1 col-1">
                                                    <label class="col-form-label">No. : </label>
                                                </div>
                                                <div class="col-lg-2 col-2">
                                                    <input id="check_no" name="check_no" type="text"  class="form-control" disabled=""> 
                                                </div>
                                                <div class="col-lg-1 col-1">
                                                    <label class="col-form-label">Date : </label>
                                                </div>
                                                <div class="col-lg-2 col-2">
                                                    <input id="check_date" name="check_date" type="text"  class="form-control" value="<?php echo date('d/m/Y', time()); ?>" disabled="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="form-group row align-items-center">
                                                <div class="col-lg-1 col-1">
                                                    <input id="tranfer" name="payment_type" onclick="check_typepayment();" type="radio"  value="tranfer" style="width: 20px; height: 20px;"> 
                                                </div>
                                                <div class="col-lg-4 col-4">
                                                    <label class="col-form-label">โอนเงินเข้าบัญชี้ : </label>
                                                </div>
                                                <div class="col-lg-1 col-1">
                                                    <label class="col-form-label">ธนาคาร : </label>
                                                </div>
                                                <div class="col-lg-2 col-2">
                                                    <input  id="bank_name" name="bank_name" type="text"  class="form-control" disabled=""> 
                                                </div>
                                                <div class="col-lg-1 col-1">
                                                    <label class="col-form-label">สาขา : </label>
                                                </div>
                                                <div class="col-lg-2 col-2">
                                                    <input id="bank_branch" name="bank_branch" type="text"  class="form-control" disabled=""> 
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
            </div>
        </section>

    </div>

</x-app-layout>

<script>

    $('#customer_id').select2();

    var index_item = 0;
    $('body').on('change', '#customer_id', function (e) {
        e.preventDefault();
        $.ajax({
            method: "GET",
            url: url_gb + "/receipt/get_data_by_customer_id/" + $(this).val(),
            dataType: 'json'
        }).done(function (rec) {

            $('#tax_id_no').val(rec['customer'].tax_id_no);
            $('#branch').val(rec['customer'].branch);
            $('#company_name_eng').val(rec['customer'].company_name_eng);
            $('#address_thai').val(rec['customer'].address_thai);

            $('#body_item').html('');
            if (rec['customer'].invoice.length > 0) {
                $.each(rec['customer'].invoice, function (index, value) {
                    var invoice_number = '<td class="text-center">\n\
                                <input type="hidden" name="select_item[' + index_item + '][invoice_id]" value="' + value.id + '" readonly="">\n\
                                ' + value.invoice_number + ' - ' + value.house_way_number + ' &nbsp; \n\
                                <input type="checkbox" class="want_invoice" name="select_item[' + index_item + '][want_invoice]" value="1" onchange="calcurate();" style="width: 20px; height: 20px;">\n\
                                <input type="hidden" class="form-control vat_7" value="' + value.vat_7 + '" readonly="">\n\
                                <input type="hidden" class="form-control with_holding_tax_3" value="' + value.with_holding_tax_3 + '" readonly="">\n\
                            </td>';
                    var non_taxable_total = '<td class="text-center">\n\
                                                <input type="text" value="' + value.non_taxable_total + '" class="form-control text-right non_taxable_total" readonly="">\n\
                                            </td>';
                    var taxable_total = '<td class="text-center">\n\
                                            <input type="text" value="' + value.taxable_total + '" class="form-control text-right taxable_total" readonly="">\n\
                                        </td>';
                    $('#body_item').append('<tr class="row_item">' + invoice_number + non_taxable_total + taxable_total + '</tr>');
                    index_item++;
                });
            } else {
                $('#body_item').append('<tr class="row_item"><td class="text-center" colspan="2">ไม่มี invoice ที่ต้องจ่าย<td class="text-center"></tr>');
            }
            calcurate();
        }).fail(function () {
            Swal.fire({icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'กรุณาติดต่อผู้ดูแลระบบ !'});
        });
    });

    function calcurate() {
        var sum_amount_non_vat = 0;
        var sum_amount_vat = 0;
        var sum_vat_7 = 0;
        var sum_holding_vat_3 = 0;
        var net = 0;

        $(".row_item").each(function (i, e) {
            if ($(e).find(".want_invoice").is(':checked')) {
                sum_amount_non_vat = sum_amount_non_vat + Number($(e).find(".non_taxable_total").val());
                sum_amount_vat = sum_amount_vat + Number($(e).find(".taxable_total").val());
                sum_vat_7 = sum_vat_7 + Number($(e).find(".vat_7").val());
                sum_holding_vat_3 = sum_holding_vat_3 + Number($(e).find(".with_holding_tax_3").val());
            }
        });

        $('#sum_amount_non_vat').val(parseFloat(sum_amount_non_vat).toFixed(2));
        $('#sum_amount_vat').val(parseFloat(sum_amount_vat).toFixed(2));
        $('#sum_vat_7').val(parseFloat(sum_vat_7).toFixed(2));
        $('#sum_holding_vat_3').val(parseFloat(sum_holding_vat_3).toFixed(2));

        var net = Number(parseFloat(sum_amount_non_vat).toFixed(2)) + Number(parseFloat(sum_amount_vat).toFixed(2)) + Number(parseFloat(sum_vat_7).toFixed(2)) - Number(parseFloat(sum_holding_vat_3).toFixed(2));
        $('#net').val(parseFloat(net).toFixed(2));

        get_text_amount();
    }

    get_text_amount();
    function get_text_amount() {
        $.ajax({
            method: "GET",
            url: url_gb + "/invoice/chang_pice_to_text/" + $('#net').val(),
            dataType: 'json'
        }).done(function (rec) {

            $('#net_text').val(rec.text);

        }).fail(function () {
            Swal.fire({icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'กรุณาติดต่อผู้ดูแลระบบ !'});
        });
    }

    function check_typepayment() {
        if ($('input[id^=cash]').is(':checked')) {
            $('input[id^=check_no]').attr('disabled', 'disabled');
            $('input[id^=check_date]').attr('disabled', 'disabled');
            $('input[id^=bank_name]').attr('disabled', 'disabled');
            $('input[id^=bank_branch]').attr("disabled", 'disabled');
        }
        if ($('input[id^=chqu_bank]').is(':checked')) {
            $('input[id^=check_no]').removeAttr('disabled');
            $('input[id^=check_date]').removeAttr('disabled');
            $('input[id^=bank_name]').attr('disabled', 'disabled');
            $('input[id^=bank_branch]').attr("disabled", 'disabled');
        }
        if ($('input[id^=tranfer]').is(':checked')) {
            $('input[id^=check_no]').attr('disabled', 'disabled');
            $('input[id^=check_date]').attr('disabled', 'disabled');
            $('input[id^=bank_name]').removeAttr('disabled');
            $('input[id^=bank_branch]').removeAttr('disabled');
        }
    }

    $('#FormAdd').validate({
        focusCleanup: true,
        rules: {
            customer_id: {
                required: true,
            },
            receipt_no: {
                required: true,
            },
            net: {
                required: true,
            },
        },
        messages: {
            customer_id: {
                required: 'กรุณาระบุ',
            },
            receipt_no: {
                required: 'กรุณาระบุ',
            },
            net: {
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
                method: "post",
                url: url_gb + "/receipt/insert",
                dataType: 'json',
                data: $(form).serialize()
            }).done(function (rec) {
                if (rec.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: rec.title,
                        text: rec.content,
                    }).then(() => {
                        window.location.href = url_gb + '/receipt';
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