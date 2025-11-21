<x-app-layout>

    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Table Invoice</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active"><a href="{{ route('invoice') }}">Invoice</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">

            <div class="card">
                <div class="card-header" style="text-align: right;">
                    <a href="{{ url('invoice/page_add') }}" class="btn btn-primary">Add</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table_list" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Invoice number</th>
                                    <th>Status</th>
                                    <th>Date add</th>
                                    <th>Date update</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </section>

    </div>

    <div class="modal fade" id="ModalEditDate" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <input type="hidden" id="invoice_id">
                <form id="FormEditDate">
                    <div class="modal-header">
                        <h4 class="card-title">แก้ไขวันที่</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Date : </label>
                                    <input type="text" name="invoice_date" id="edit_invoice_date" class="form-control" maxlength="10">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Due Date : </label>
                                    <input type="text" name="due_date" id="edit_due_date" class="form-control" maxlength="10">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn pull-right btn-lg btn-primary">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    var TableList = $('#table_list').dataTable({
        // เซอเวอไซต์ต้องมี 2 อันนี้
        "processing": true,
        "serverSide": true,
        // -------------------
        scrollCollapse: true,
        autoWidth: false,
        responsive: true,
        columnDefs: [{
            targets: "datatable-nosort",
            orderable: false,
        }],
        "lengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "ajax": {
            "url": url_gb + "/invoice/get_datatable",
            "data": function(d) {
                //d.myKey = "myValue";
                // d.custom = $('#myInput').val();
                // etc
            }
        },
        "columns": [{
                "data": "DT_RowIndex",
                "className": "text-center",
                "orderable": false,
                "searchable": false
            },
            {
                "data": "invoice_number",
                "className": "text-center"
            },
            {
                "data": "status",
                "className": "text-center"
            },
            {
                "data": "invoice_date",
                "className": "text-center"
            },
            {
                "data": "date_update",
                "className": "text-center"
            },
            {
                "data": "action",
                "className": "action text-center text-nowrap",
                "orderable": false,
                "searchable": false
            }
        ],
        "order": [
            [3, "desc"]
        ],
        rowCallback: function(row, data, index) {

        }
    });

    $('body').on('click', '.btn-edit_date', function(e) {
        e.preventDefault();
        var btn = $(this);
        btn.button('loading');
        var id = $(this).data('id');
        $('#invoice_id').val(id);
        $.ajax({
            method: "get",
            url: url_gb + "/invoice/get_date_by_invoice_id/" + id,
            dataType: 'json'
        }).done(function(rec) {
            $('#edit_invoice_date').val(rec.invoice_date);
            $('#edit_due_date').val(rec.due_date);
            $('#ModalEditDate').modal("show");
            btn.button("reset");
        }).fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณาติดต่อผู้ดูแลระบบ !'
            });
            btn.button("reset");
        });
    });

    $('#FormEditDate').validate({
        focusCleanup: true,
        rules: {
            invoice_date: {
                required: true,
            },
            due_date: {
                required: true,
            }
        },
        messages: {
            invoice_date: {
                required: "กรุณาระบุ",
            },
            due_date: {
                required: "กรุณาระบุ",
            }
        },
        errorPlacement: function(error, element) { // คำสั่งโชกล่องข้อความ
            error.addClass("text-danger");
            error.insertAfter(element);
        },
        highlight: function(element, errorClass, validClass) { // ใส่สีเมื่อเกิด error
            $(element).addClass("is-invalid");
        },
        unhighlight: function(element, errorClass, validClass) { // ใส่สีเมื่อผ่าน error แล้ว;
            $(element).removeClass("is-invalid");
            $(element).addClass("is-valid");
        },
        submitHandler: function(form) {
            var btn = $(form).find('[type="submit"]');
            var id = $('#invoice_id').val();
            btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...').attr('disabled', true);
            $.ajax({
                method: "put",
                url: url_gb + "/invoice/update_date_by_invoice_id/" + id,
                dataType: 'json',
                data: $(form).serialize()
            }).done(function(rec) {
                if (rec.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: rec.title,
                        text: rec.content,
                    }).then(() => {
                        window.location.href = url_gb + '/invoice';
                        $('#ModalEditDate').modal("hide");
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: rec.title,
                        text: rec.content
                    });
                    $('#ModalEditDate').modal("hide");
                }
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'เกิดข้อผิดพลาด',
                    text: 'กรุณาติดต่อผู้ดูแลระบบ !'
                });
                btn.html('Save').attr('disabled', false);
            });
        }
    });
</script>
