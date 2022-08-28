<x-app-layout>

    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Create Customer</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('customer') }}">Customer</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('customer/page_add') }}">Create Customer</a></li>
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
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name">Tax Id No</label>
                                                <input type="text" id="tax_id_no" class="form-control" name="tax_id_no">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="ori">Branch</label>
                                                <input type="text" id="branch" class="form-control" name="branch">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="dest">Company name En</label>
                                                <input type="text" id="company_name_eng" class="form-control" name="company_name_eng">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="dest">Company name TH</label>
                                                <input type="text" id="company_name_thai" class="form-control" name="company_name_thai">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="dest">Address En</label>
                                                <textarea rows="5" id="address_eng" class="form-control" name="address_eng"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="dest">Address TH</label>
                                                <textarea rows="5" id="address_eng" class="form-control" name="address_thai"></textarea>
                                            </div>
                                        </div>
                                        <hr/>
                                        <h6>Select shipper</h6>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%;" class="text-center">Action</th>
                                                        <th style="width: 20%;">Group</th>
                                                        <th style="width: 30%;">Company name</th>
                                                        <th style="width: 20%;">ORI</th>
                                                        <th style="width: 20%;">DEST</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="body_shipper">

                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center">
                                                        <td><button type="button" class="btn btn-info btn_add_shipper">Add Shipper</button></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <hr/>
                                        <h6>Select Item main</h6>
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

                                                </tbody>
                                                <tfoot>
                                                    <tr class="text-center">
                                                        <td><button type="button" class="btn btn-info btn_add_item">Add Item</button></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
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

    var index_shipper = 0;
    $('body').on('click', '.btn_add_shipper', function (e) {
        e.preventDefault();
        var btn_delete = '<td class="text-center"><button class="btn btn-danger btn_delete_shipper">Delete</button></td>';
        var group = '<td class="text-center group"></td>';
        var company_name = `<td class="text-center company_name">
                                <select class="form-control select_shipper" name="select_shipper[` + index_shipper + `][dealer_id]" title="กรุณาระบุ" required="">
                                <option selected="" disabled="">กรุณาเลือก</option>
<?php foreach ($shippers as $shipper) { ?>       
                            <option 
                            value="<?php echo $shipper->id; ?>" 
                            data-group="<?php echo $shipper->group; ?>"
                            data-ori="<?php echo $shipper->ori; ?>"
                            data-dest="<?php echo $shipper->dest; ?>"    
                            ><?php echo "(" . $shipper->group . ") " . $shipper->name; ?>
                            </option>
<?php } ?>
                                </select>    
                            </td>`;
        var ori = '<td class="text-center ori"></td>';
        var dest = '<td class="text-center dest"></td>';
        $('#body_shipper').append('<tr class="row_shipper">' + btn_delete + group + company_name + ori + dest + '</tr>');
        index_shipper++;
        $('.select_shipper').select2();
    });

    $('body').on('change', '.select_shipper', function (e) {
        e.preventDefault();
        $(this).closest('.row_shipper').find('.group').html($(this).find(':selected').data('group'));
        $(this).closest('.row_shipper').find('.ori').html($(this).find(':selected').data('ori'));
        $(this).closest('.row_shipper').find('.dest').html($(this).find(':selected').data('dest'));
    });

    $('body').on('click', '.btn_delete_shipper', function (e) {
        e.preventDefault();
        $(this).closest('.row_shipper').remove();
    });

    var index_item = 0;
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
        var amount = '<td class="text-center"><input class="form-control text-right amount" name="select_item[' + index_item + '][amount]" type="number" title="กรุณาระบุ" required=""></td>';
        var select_taxable = '<td class="text-center select_taxable"></td>';
        $('#body_item').append('<tr class="row_item">' + btn_delete + code + particulars + amount + select_taxable + '</tr>');
        index_item++;
        $('.select_item').select2();
    });

    $('body').on('change', '.select_item', function (e) {
        e.preventDefault();
        $(this).closest('.row_item').find('.particulars').html($(this).find(':selected').data('particulars'));
        $(this).closest('.row_item').find('.amount').val($(this).find(':selected').data('amount'));
        if ($(this).find(':selected').data('select_taxable') == 1) {
            $(this).closest('.row_item').find('.select_taxable').html('Vat');
        } else {
            $(this).closest('.row_item').find('.select_taxable').html('Non Vat');
        }
    });

    $('body').on('click', '.btn_delete_item', function (e) {
        e.preventDefault();
        $(this).closest('.row_item').remove();
    });

    $('#FormAdd').validate({
        focusCleanup: true,
        rules: {
            tax_id_no: {
                required: true,
            },
            branch: {
                required: true,
            },
            company_name_eng: {
                required: true,
            },
            company_name_thai: {
                required: true,
            },
            address_eng: {
                required: true,
            },
            address_thai: {
                required: true,
            },
        },
        messages: {
            tax_id_no: {
                required: 'กรุณาระบุ',
            },
            branch: {
                required: 'กรุณาระบุ',
            },
            company_name_eng: {
                required: 'กรุณาระบุ',
            },
            company_name_thai: {
                required: 'กรุณาระบุ',
            },
            address_eng: {
                required: 'กรุณาระบุ',
            },
            address_thai: {
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
                url: url_gb + "/customer/insert",
                dataType: 'json',
                data: $(form).serialize()
            }).done(function (rec) {
                if (rec.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: rec.title,
                        text: rec.content,
                    }).then(() => {
                        window.location.href = url_gb + '/customer';
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
