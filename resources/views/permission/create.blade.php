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
                        <h3 class="box-title">انشاء صلاحيه جديده</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->


                    <form class="form-horizontal" method="post" action="{{url('/permission')}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">

                                <label for="title" class="col-sm-4 control-label">اسم الصلاحيه</label>

                                <div class="col-sm-4 {{ $errors->has('title') ? ' has-error' : '' }}">
                                    <input type="text" name="title" class="form-control" id="title" placeholder="Permission" value="{{ old('title') }}">
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
                                        <option value="مسئول">مسئول</option>
                                        <option value="خدمة">خدمة</option>
                                        <option value="عميل">عميل</option>
                                        <option value="مزود خدمة">مزود خدمة</option>
                                        <option value="استبيان">استبيان</option>
                                        <option value="تقارير">تقارير</option>
                                        <option value="اخري">اخري</option>
                                    </select>
                                    @if ($errors->has('for'))
                                        <span class="help-block">
                    <strong>{{ $errors->first('for') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>

                        </div>




                        <div class="box-footer">
                            <button type="submit" class="btn btn-info center-block">حفظ</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </section>


@endsection
