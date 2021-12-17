@extends('layout.index')
@section('content')
     <section style="margin-left: 300px;" class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h1>Title</h1>
              </div>
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th class="text-center">STT</th>
                    <th class="text-center">title</th>
                    <th class="text-center">Funtap_title_element</th>
                    <th class="text-center">id_dad</th>
                    <th class="text-center">Url</th>
                    <th class="text-center">
                        <a href="" class="AddTitle">
                            <button type="button" class="btn btn-primary">Thêm mới</button>
                        </a>
                    </th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($list_title as $key =>$value)
                    <tr>
                        <td class="text-center">{{$key+1}}</td>
                        <td class="text-center">{{$value->title}}</td>
                        <td class="text-center">{{$value->title_element}}</td>
                        <td class="text-center">{{$value->id_dad}}</td>
                        <td class="text-center">{{Str::limit($value->url, 30) }}</td>
                        <td class="text-center">
                            <a onclick="event.preventDefault();editTitle({{$value->id}})" class="btn btn-primary btn-sm m-r-xs"><i class="fa fa-pencil"></i> Sửa</a>
                            <a href="{{route('ajax_deleteTitle',$value->id)}}" class="btn btn-danger btn-sm js-deleteTitle"><i class="fa fa-times "></i> Xóa</a>
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
<div class="modal fade" id="modal-addTitle">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm mới</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-addTitle" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <input type="text" maxlength="23" name="title" class="form-control" placeholder="tiêu đề">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">url</label>
                            <input type="text" name="url" class="form-control" placeholder="tiêu đề">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label class="control-label">Id_funtap</label>
                            <select name="id_funtap" id="id_funtap" class="id_dad col-sm-12">
                            @foreach($list_Funtap as $value)
                            <option value="{{$value->id}}">{{$value->title_element}}</option>
                            @endforeach
                            </select>
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label class="control-label">id_dad</label>
                            <select name="id_dad" id="id_dad" class="id_dad col-sm-12">
                            <option value="0">Get started</option>
                            @foreach($list_title as $value)
                            <option value="{{$value->id}}">{{$value->title}}</option>
                            @endforeach
                            </select>
                            <span class="error-form"></span>
                        </div>
                    </div>
                <button type="submit" class="btn btn-primary js-btn-addTitle">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-editTitle">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm mới</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="form-editTitle" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Title</label>
                            <input type="text" maxlength="23" name="title" class="form-control" placeholder="tiêu đề">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <input type="hidden" name="id">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">url</label>
                            <input type="text" name="url" class="form-control" placeholder="tiêu đề">
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label class="control-label">Id_funtap</label>
                            <select name="id_funtap" class="id_dad col-sm-12">
                            @foreach($list_Funtap as $value)
                            <option value="{{$value->id}}">{{$value->title_element}}</option>
                            @endforeach
                            </select>
                            <span class="error-form"></span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                        <label class="control-label">id_dad</label>
                            <select name="id_dad" class="id_dad col-sm-12">
                            <option value="0">Get started</option>
                            @foreach($list_title as $value)
                            <option value="{{$value->id}}">{{$value->title}}</option>
                            @endforeach
                            </select>
                            <span class="error-form"></span>
                        </div>
                    </div>
                <button type="submit" class="btn btn-primary js-btn-editTitle">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function() {
        $(".AddTitle").click(function(event) {
            event.preventDefault();
            $("#modal-addTitle").modal('show');
            $("#error_form").hide();
        })
        $('.js-btn-addTitle').click(function(event) {
            event.preventDefault();
            let $this = $(this);
            $(".error-form").text('');
            let $domForm = $this.closest('#form-addTitle');
            $.ajax({
                url: 'postTitle',
                data: new FormData($("#modal-addTitle form")[0]),
                contentType: false,
                processData: false,
                method: "POST",
            }).done(function(data) {
                $("#modal-addTitle").modal('hide');
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
    function editTitle(id) {
        $.ajax({
            type: 'GET',
            url: 'geteditTitle/' + id,
            success: function(data) {
                $("#form-editTitle input[name=id]").val(data.list_title.id);
                $("#form-editTitle input[name=title]").val(data.list_title.title);
                $("#form-editTitle select[name=id_funtap]").val(data.list_title.id_funtap);
                $("#form-editTitle #id_dad").val(data.list_title.id_dad);
                $("#form-editTitle input[name=url]").val(data.list_title.url);
                $('#modal-editTitle').modal('show');
            },
            error: function(data) {}
        });
    }
    $(function() {
    $('.js-btn-editTitle').click(function(e) {
      e.preventDefault();
      let $this = $(this);
      let $domForm = $this.closest('#form-editTitle');
      $.ajax({
        url: 'posteditTitle/' + $("#form-editTitle input[name=id]").val(),
        data: new FormData($("#modal-editTitle form")[0]),
        contentType: false,
        processData: false,
        method: "POST",
      }).done(function(data) {
        $("#modal-editTitle").modal('hide');
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
        $('body').on("click", '.js-deleteTitle', function(event) {
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
            }).fail(function(data) {
            });
        }
        })
    })
  function deleteTitle(id) {
        var r = confirm("Bạn có muốn xóa không?");
            if (r == true) {
            $.ajax({
                type: 'GET',
                url: 'deleteTitle/' + id,
            }).done(function(data) {

                window.location.reload().delay(100000)
              toastr.success('', 'Xóa thành công');
            }).fail(function(data) {

            });
    }
}
</script>
@endsection
