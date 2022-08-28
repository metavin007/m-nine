<x-app-layout>

    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Create Item</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('item') }}">Item</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('item/pade_edit/'.$item->id) }}">Edit Item</a></li>
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
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="code">Code</label>
                                                <input type="text" id="code" class="form-control" name="code" value="{{ $item->code }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="particulars">Particulars</label>
                                                <input type="text" id="particulars" class="form-control" name="particulars" value="{{ $item->particulars }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="amount">Amount</label>
                                                <input type="number" id="amount" class="form-control" name="amount" value="{{ $item->amount }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="select_taxable">Vat</label>
                                                <br/>
                                                <input type="checkbox" id="select_taxable" name="select_taxable" style="width: 30px; height: 30px;"
                                                       value="1" {{ ($item->select_taxable == 1 ? 'checked=""':'') }} >
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


    var id = '{{ $item->id }}';

    $('#FormEdit').validate({
        focusCleanup: true,
        rules: {
            code: {
                required: true,
            },
            particulars: {
                required: true,
            },
            ori: {
                required: true,
            },
        },
        messages: {
            code: {
                required: 'กรุณาระบุ',
            },
            particulars: {
                required: 'กรุณาระบุ',
            },
            amount: {
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
                url: url_gb + "/item/update/" + id,
                dataType: 'json',
                data: $(form).serialize()
            }).done(function (rec) {
                if (rec.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: rec.title,
                        text: rec.content,
                    }).then(() => {
                        window.location.href = url_gb + '/item';
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