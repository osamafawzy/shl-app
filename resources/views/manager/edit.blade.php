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
                        <h3 class="box-title">التعديل علي  <strong>{{$manager->name}}</strong> </h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->


                    <form class="form-horizontal" method="post" action="{{url('/manager/'.$manager->id)}}">
                        {{csrf_field()}}
                        <input type="hidden" name="_method" value="patch">
                        <div class="box-body">

                            <div class="form-group">

                                <label for="name" class="col-sm-4 control-label">الاسم</label>

                                <div class="col-sm-4 {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="name" value="{{$manager->name}}">
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
                                    <input type="text" name="email" class="form-control" id="email" placeholder="email" value="{{$manager->email}}">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                    </span>
                                    @endif
                                </div>

                            </div>



                            <div class="form-group">

                                <label for="role" class="col-sm-4 control-label">Assign Role</label>

                                <div class="col-lg-4 text-center">
                                    <div class="row">
                                        @foreach($roles as $role)
                                            <label><input type="checkbox" name="role[]" value="{{$role->id}}"
                                                          @foreach ($manager->roles as $manager_role)
                                                          @if($role->id == $manager_role->id)

                                                          checked

                                                        @endif
                                                        @endforeach>{{$role->title}}</label>
                                        @endforeach

                                    </div>

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
