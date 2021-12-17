@extends('layout.index')
@section('content')
<section style="margin-left: 300px;" class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Access_token</h1>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-center">name page</th>
                                    <th class="text-center">id_page</th>
                                    <th class="text-center">token</th>
                                    <th class="text-center">
                                        <a href="" class="AddAccess_token">
                                            <button type="button" class="btn btn-primary">Thêm mới</button>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key =>$value)
                                <tr>
                                    <td class="text-center">{{$key+1}}</td>
                                    <td class="text-center">{{$value->name}}</td>
                                    <td class="text-center">{{$value->id_page}}</td>
                                    <td class="text-center">{{Str::limit($value->token, 30) }}</td>
                                    <td class="text-center">
                                        <a onclick="event.preventDefault();editAccess_token({{$value->id}})" class="btn btn-primary btn-sm m-r-xs"><i class="fa fa-pencil"></i> Sửa</a>
                                        <a href="{{route('ajax_deleteAccess_token',$value->id)}}" class="btn btn-danger btn-sm js-deleteAccess_token"><i class="fa fa-times "></i> Xóa</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<div class="modal fade" id="modal-AddAccess_token">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm mới</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-AddAccess_token" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Name fanpage">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Id_page</label>
                            <input type="text" name="id_page" class="form-control" placeholder="Id fanpage">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Access_token</label>
                            <input type="text" name="token" class="form-control" placeholder="Access_token fanpage">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary js-btn-AddAccess_token">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-EditAccess_token">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-EditAccess_token" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Id fanpage">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Id_page</label>
                            <input type="text" name="id_page" class="form-control" placeholder="Id fanpage">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <input type="hidden" name="id">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Access_token</label>
                            <input type="text" name="token" class="form-control" placeholder="Access_token fanpage">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary js-btn-EditAccess_token">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function() {
        $(".AddAccess_token").click(function(event) {
            event.preventDefault();
            $("#modal-AddAccess_token").modal('show');
            $("#error_form").hide();
        })
        $('.js-btn-AddAccess_token').click(function(event) {
            event.preventDefault();
            let $this = $(this);
            $(".error-form").text('');
            let $domForm = $this.closest('#form-AddAccess_token');
            $.ajax({
                url: 'postAccess_token',
                data: new FormData($("#modal-AddAccess_token form")[0]),
                contentType: false,
                processData: false,
                method: "POST",
            }).done(function(data) {
                $("#modal-AddAccess_token").modal('hide');
                $('tbody').append(data);
                toastr.success('', 'thêm mới thành công');
            }).fail(function(data) {
                $(".error-form").show();
                var errors = data.responseJSON;
                $.each(errors.errors, function(i, val) {
                    $domForm.find('input[name=' + i + ']').siblings(
                        '.error-form').text(
                        val[0]);
                });
            });
        });
    });

    function editAccess_token(id) {
        $.ajax({
            type: 'GET',
            url: 'geteditAccess_token/' + id,
            success: function(data) {
                $("#form-EditAccess_token input[name=id]").val(data.list_access_token.id);
                $("#form-EditAccess_token input[name=name]").val(data.list_access_token.name);
                $("#form-EditAccess_token input[name=id_page]").val(data.list_access_token.id_page);
                $("#form-EditAccess_token input[name=token]").val(data.list_access_token.token);
                $('#modal-EditAccess_token').modal('show');
            },
            error: function(data) {}
        });
    }

    $(function() {
        $('.js-btn-EditAccess_token').click(function(e) {
            e.preventDefault();
            let $this = $(this);
            let $domForm = $this.closest('#form-EditAccess_token');
            $.ajax({
                url: 'posteditAccess_token/' + $("#form-EditAccess_token input[name=id]").val(),
                data: new FormData($("#modal-EditAccess_token form")[0]),
                contentType: false,
                processData: false,
                method: "POST",
            }).done(function(data) {
                $("#modal-EditAccess_token").modal('hide');
                $('tbody').html(data);
                toastr.success('', 'Chỉnh sửa thành công');
            }).fail(function(data) {
                $('.error-form').show();
                var errors = data.responseJSON;
                $.each(errors.errors, function(i, val) {
                    $domForm.find('input[name=' + i + ']').siblings('.error-form').text(val[0]);
                });
            });
        });
    })
    $(function() {
        $('body').on("click", '.js-deleteAccess_token', function(event) {
            var r = confirm("Bạn có muốn xóa không?");
            if (r == true) {
                event.preventDefault();
                let URL = $(this).attr('href');
                let $this = $(this);
                $.ajax({
                    url: URL,
                }).done(function(results) {
                    if (results.code == 200) {
                        $this.parents("tr").remove();
                        toastr.success('', 'Xóa thành công');
                    }
                }).fail(function(data) {});
            }
        })
    })

    function deleteAccess_token(id) {
        var r = confirm("Bạn có muốn xóa không?");
        if (r == true) {
            $.ajax({
                type: 'GET',
                url: 'deleteAccess_token/' + id,
            }).done(function(data) {
                window.location.reload().delay(100000)
                toastr.success('', 'Xóa thành công');
            }).fail(function(data) {

            });
        }
    }
</script>
</script>
@endsection
