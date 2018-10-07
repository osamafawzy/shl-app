@extends('admintempate.admintempate')

@section('page-style-level')
    <style>
        .dir {
            direction: rtl;
        }
    </style>
@endsection

@section('content')

    <section class="content">
        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"> التعديل علي الصلاحيه<strong>{{$permission->title}}</strong> </h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->


                    <form class="form-horizontal" method="post" action="{{url('/permission/'.$permission->id)}}">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="patch">
                        <div class="box-body">

                            <div class="form-group">

                                <label for="permission" class="col-sm-4 control-label">اسم الصلاحيه</label>

                                <div class="col-sm-4 {{ $errors->has('title') ? ' has-error' : '' }}">
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Permission" value="{{$permission->title}}">
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group">

                                <label for="for" class="col-sm-4 control-label">الصلاحيات ل</label>

                                <div class="col-sm-4 {{ $errors->has('for') ? ' has-error' : '' }}">
                                    <select name="for" id="for" class="form-control">
                                        <option value="مسئول" @if($permission->for == 'مسئول') selected @endif>مسئول</option>
                                        <option value="خدمة" @if($permission->for == 'خدمة') selected @endif>خدمة</option>
                                        <option value="عميل" @if($permission->for == 'عميل') selected @endif>عميل</option>
                                        <option value="مزود خدمة" @if($permission->for == 'مزود خدمة') selected @endif>مزود خدمة</option>
                                        <option value="استبيان" @if($permission->for == 'استبيان') selected @endif>استبيان</option>
                                        <option value="تقارير" @if($permission->for == 'تقارير') selected @endif>تقارير</option>
                                        <option value="اخري" @if($permission->for == 'اخري') selected @endif>اخري</option>
                                    </select>
                                    @if ($errors->has('for'))
                                        <span class="help-block">
                    <strong>{{ $errors->first('for') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>


                        </div>








                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info center-block"> حفظ</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>

            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </section>

@endsection
