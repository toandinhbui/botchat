@extends('layout.index')
@section('content')
<section style="margin-left: 300px;" class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h1>Funtap</h1>
                    </div>
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-center">Title_element</th>
                                    <th class="text-center">Image_url</th>
                                    <th class="text-center">Name page</th>
                                    <th class="text-center">Content</th>
                                    <th class="text-center">Subtitle</th>
                                    <th class="text-center">
                                        <a href="" class="AddFuntap">
                                            <button type="button" class="btn btn-primary">Thêm mới</button>
                                        </a>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key =>$value)
                                <tr>
                                    <td class="text-center">{{$key+1}}</td>
                                    <td class="text-center">{{$value->title_element}}</td>
                                    <td class="text-center">{{Str::limit($value->image_url, 30)}}</td>
                                    <td class="text-center">{{$value->name}}</td>
                                    <td class="text-center">{!!Str::limit($value->content, 30)!!}</td>
                                    <td class="text-center">{{$value->subtitle}}</td>
                                    <td class="text-center">
                                        <a onclick="event.preventDefault();editFuntap({{$value->id}})" class="btn btn-primary btn-sm m-r-xs"><i class="fa fa-pencil"></i> Sửa</a>
                                        <a href="{{route('ajax_deleteFuntap',$value->id)}}" class="btn btn-danger btn-sm js-deleteFuntap"><i class="fa fa-times "></i> Xóa</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="modal-AddFuntap">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm mới</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-AddFuntap" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">title_element</label>
                            <input type="text" name="title_element" class="form-control" placeholder="tiêu đề">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">image_url</label>
                            <input type="text" name="image_url" class="form-control">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Page</label>
                            <select name="id_token" class="id_dad col-sm-12">
                                @foreach($access_token as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Content</label>
                            <input type="text" name="content" class="form-control" placeholder="nội dung">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">subtitle</label>
                            <input type="text" name="subtitle" class="form-control" placeholder="phụ đề">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary js-btn-AddFuntap">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-EditFuntap">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Sửa</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-EditFuntap" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">title_element</label>
                            <input type="text" name="title_element" class="form-control" placeholder="tiêu đề">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <input type="hidden" name="id">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">image_url</label>
                            <input type="text" name="image_url" class="form-control">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Page</label>
                            <select name="id_page" class="id_dad col-sm-12">
                                @foreach($access_token as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                                @endforeach
                            </select>
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Content</label>
                            <input type="text" name="content" class="form-control" placeholder="nội dung">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">subtitle</label>
                            <input type="text" name="subtitle" class="form-control" placeholder="phụ đề">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary js-btn-EditFuntap">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    CKEDITOR.replace('editor1');
    CKEDITOR.replace('editor2');
    $(function() {
        $(".AddFuntap").click(function(event) {
            event.preventDefault();
            $("#modal-AddFuntap").modal('show');
            $("#error_form").hide();
        })
        $('.js-btn-AddFuntap').click(function(event) {
            event.preventDefault();
            let $this = $(this);
            $.ajax({
                url: 'postFuntap',
                data: new FormData($("#modal-AddFuntap form")[0]),
                contentType: false,
                processData: false,
                method: "POST",
            }).done(function(data) {
                $("#modal-AddFuntap").modal('hide');
                $('tbody').append(data);
                toastr.success('', 'thêm mới thành công');
            }).fail(function(data) {});
        });
    });

    function editFuntap(id) {
        $.ajax({
            type: 'GET',
            url: 'geteditFuntap/' + id,
            success: function(data) {
                $("#form-EditFuntap input[name=id]").val(data.list_funtap.id);
                $("#form-EditFuntap input[name=title_element]").val(data.list_funtap.title_element);
                $("#form-EditFuntap input[name=image_url]").val(data.list_funtap.image_url);
                $("#form-EditFuntap select[name=id_page]").val(data.list_funtap.id_token);
                $("#form-EditFuntap input[name=content]").val(data.list_funtap.content);
                $("#form-EditFuntap input[name=subtitle]").val(data.list_funtap.subtitle);
                $('#modal-EditFuntap').modal('show');
            },
            error: function(data) {}
        });
    }

    $(function() {
        $('.js-btn-EditFuntap').click(function(e) {
            e.preventDefault();
            let $this = $(this);
            $.ajax({
                url: 'posteditFuntap/' + $("#form-EditFuntap input[name=id]").val(),
                data: new FormData($("#modal-EditFuntap form")[0]),
                contentType: false,
                processData: false,
                method: "POST",
            }).done(function(data) {
                $("#modal-EditFuntap").modal('hide');
                $('tbody').html(data);
                toastr.success('', 'Chỉnh sửa thành công');
            }).fail(function(data) {});
        });
    })
    $(function() {
        $('body').on("click", '.js-deleteFuntap', function(event) {
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

    function deleteFuntap(id) {
        var r = confirm("Bạn có muốn xóa không?");
        if (r == true) {
            $.ajax({
                type: 'GET',
                url: 'deleteFuntap/' + id,
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
