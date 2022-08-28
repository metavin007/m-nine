<x-app-layout>

    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Header PDF</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="{{ route('header_pdf') }}">Header PDF</a></li>
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
                                <form id="FormEditMyCompany">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="tax_id_no">Tax Id No (required)</label>
                                                <input type="text" id="tax_id_no" class="form-control" name="tax_id_no" value="{{ $my_company->tax_id_no }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="tel">Tel (required)</label>
                                                <input type="text" id="tel" class="form-control" name="tel" value="{{ $my_company->tel }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name_th">Name TH (required)</label>
                                                <input type="text" id="name_th" class="form-control" name="name_th" value="{{ $my_company->name_th }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name_en">Name EN (required)</label>
                                                <input type="text" id="name_en" class="form-control" name="name_en" value="{{ $my_company->name_en }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="address_th">Address TH (required)</label>
                                                <input type="text" id="address_th" class="form-control" name="address_th" value="{{ $my_company->address_th }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="eaddress_en">Address EN (required)</label>
                                                <input type="text" id="address_en" class="form-control" name="address_en" value="{{ $my_company->address_en }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="with_holding_tax">With Holding Tax</label>
                                                <input type="number" id="with_holding_tax" class="form-control" name="with_holding_tax" value="{{ $my_company->with_holding_tax }}">
                                            </div>
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

    $('#FormEditMyCompany').validate({
        focusCleanup: true,
        rules: {
            tax_id_no: {
                required: true,
            },
            tel: {
                required: true,
            },
            name_th: {
                required: true,
            },
            name_en: {
                required: true,
            },
            address_th: {
                required: true,
            },
            address_en: {
                required: true,
            },
            with_holding_tax: {
                required: true,
            },
        },
        messages: {
            tax_id_no: {
                required: 'กรุณาระบุ',
            },
            tel: {
                required: 'กรุณาระบุ',
            },
            name_th: {
                required: 'กรุณาระบุ',
            },
            name_en: {
                required: 'กรุณาระบุ',
            },
            address_th: {
                required: 'กรุณาระบุ',
            },
            address_en: {
                required: 'กรุณาระบุ',
            },
            with_holding_tax: {
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
                method: "PUT",
                url: url_gb + "/header_pdf/update_my_company/1",
                dataType: 'json',
                data: $(form).serialize()
            }).done(function (rec) {
                if (rec.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: rec.title,
                        text: rec.content,
                    }).then(() => {
                        location.reload();
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