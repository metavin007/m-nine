<x-app-layout>

    <div class="page-heading">

        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Edit Shipper</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('shipper') }}">Shipper</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{ url('shipper/pade_edit/'.$shipper->id) }}">Edit Shipper</a></li>
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
                                                <label for="group">Shipper/Consignee</label>
                                                <select id="group" class="form-control" name="group">
                                                    <option value="Shipper" {{ ($shipper->group == 'Shipper' ? 'selected=""':'') }}>Shipper</option>
                                                    <option value="Consignee" {{ ($shipper->group == 'Consignee' ? 'selected=""':'') }}>Consignee</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="name">Company Name</label>
                                                <input type="text" id="name" class="form-control" name="name" value="{{ $shipper->name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="ori">Ori</label>
                                                <input type="text" id="ori" class="form-control" name="ori" value="{{ $shipper->ori }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="dest">Dest</label>
                                                <input type="text" id="dest" class="form-control" name="dest" value="{{ $shipper->dest }}">
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

    var id = '{{ $shipper->id }}';

    $('#FormEdit').validate({
        focusCleanup: true,
        rules: {
            group: {
                required: true,
            },
            name: {
                required: true,
            },
            ori: {
                required: true,
            },
            dest: {
                required: true,
            },
        },
        messages: {
            group: {
                required: 'กรุณาระบุ',
            },
            name: {
                required: 'กรุณาระบุ',
            },
            ori: {
                required: 'กรุณาระบุ',
            },
            dest: {
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
                url: url_gb + "/shipper/update/" + id,
                dataType: 'json',
                data: $(form).serialize()
            }).done(function (rec) {
                if (rec.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: rec.title,
                        text: rec.content,
                    }).then(() => {
                        window.location.href = url_gb + '/shipper';
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