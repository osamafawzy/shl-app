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
                        <h3 class="box-title">اضافه رئيس جديد</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->


                    <form class="form-horizontal" method="post" action="{{url('/manager')}}">
                        {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">

                                <label for="name" class="col-sm-4 control-label">الاسم</label>

                                <div class="col-sm-4 {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="name" value="{{ old('name') }}">
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                    </span>
                                    @endif
                                </div>

                            </div>



                            <div class="form-group">

                                <label for="email" class="col-sm-4 control-label">البريد الالكتروني</label>

                                <div class="col-sm-4 {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <input type="text" name="email" class="form-control" id="email" placeholder="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                    </span>
                                    @endif
                                </div>

                            </div>





                            <div class="form-group">

                                <label for="password" class="col-sm-4 control-label">كلمه المرور</label>

                                <div class="col-sm-4 {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="password">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                    </span>
                                    @endif
                                </div>

                            </div>




                            <div class="form-group">

                                <label for="password_confirmation" class="col-sm-4 control-label">تأكيد كلمه المرور </label>

                                <div class="col-sm-4 {{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="confirm password">
                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                                    @endif
                                </div>

                            </div>


                            <div class="form-group">

                                <label for="role" class="col-sm-4 control-label">تعيين وظيفه</label>

                                <div class="col-lg-4 text-center {{ $errors->has('role') ? ' has-error' : '' }}">
                                    <div class="row">
                                        @foreach($roles as $role)
                                            <label><input type="checkbox"  name="role[]" value="{{$role->id}}">{{$role->title}}</label>
                                        @endforeach
                                        @if ($errors->has('role'))
                                            <span class="help-block">
                    <strong>{{ $errors->first('role') }}</strong>
                    </span>
                                        @endif

                                    </div>

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
