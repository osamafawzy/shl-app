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
                        <h3 class="box-title">اضافه وظيفه جديده</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->


                    <form class="form-horizontal" method="post" action="{{url('/role')}}">
                        {{csrf_field()}}
                        <div class="box-body" style="margin-left:60px">
                            <div class="form-group">

                                <label for="title" class="col-sm-4 control-label">الوظيفه</label>

                                <div class="col-sm-4 {{ $errors->has('title') ? ' has-error' : '' }}">
                                    <input type="text" name="title" class="form-control" id="title" placeholder="الوظيفه" value="{{ old('title') }}">
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                    <strong>{{ $errors->first('title') }}</strong>
                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-lg-3">
                                    <div >
                                        <label for="permission" class="control-label">صلاحيات الخدمات</label>
                                    </div>
                                    @foreach($permissions as $permission)
                                        @if($permission->for == 'خدمة')
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="permission[]" value="{{$permission->id}}">{{$permission->title}}</label>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>

                                <div class="col-lg-3">
                                    <div>
                                        <label for="permission" class="control-label">صلاحيات العملاء</label>
                                    </div>
                                    @foreach($permissions as $permission)
                                        @if($permission->for == 'عميل')
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="permission[]" value="{{$permission->id}}">{{$permission->title}}</label>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>

                                <div class="col-lg-3">
                                    <div>
                                        <label for="permission" class="control-label">صلاحيات مزودي الخدمة</label>
                                    </div>
                                    @foreach($permissions as $permission)
                                        @if($permission->for == 'مزود خدمة')
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="permission[]" value="{{$permission->id}}">{{$permission->title}}</label>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>

                                <div class="col-lg-3">
                                    <div>
                                        <label for="permission" class="control-label">صلاحيات الاستبيان</label>
                                    </div>
                                    @foreach($permissions as $permission)
                                        @if($permission->for == 'استبيان')
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="permission[]" value="{{$permission->id}}">{{$permission->title}}</label>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>

                                <div class="col-lg-3">
                                    <div>
                                        <label for="permission" class="control-label">صلاحيات التقارير</label>
                                    </div>
                                    @foreach($permissions as $permission)
                                        @if($permission->for == 'تقارير')
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="permission[]" value="{{$permission->id}}">{{$permission->title}}</label>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>

                                <div class="col-lg-3">
                                    <div>
                                        <label for="permission" class="control-label">صلاحيات اخري</label>
                                    </div>
                                    @foreach($permissions as $permission)
                                        @if($permission->for == 'اخري')
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="permission[]" value="{{$permission->id}}">{{$permission->title}}</label>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>

                                <div class="col-lg-3">
                                    <div>
                                        <label for="permission" class="control-label">صلاحيات المسئولين</label>
                                    </div>
                                    @foreach($permissions as $permission)
                                        @if($permission->for == 'مسئول')
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="permission[]" value="{{$permission->id}}">{{$permission->title}}</label>
                                            </div>
                                        @endif
                                    @endforeach

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
