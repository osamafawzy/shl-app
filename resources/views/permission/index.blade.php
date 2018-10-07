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
            <div class="col-md-12">
                <a href="{{url('/permission/create')}}" class="btn btn-primary pull-right margin-bottom">
                    <i class="fa fa-plus"></i>
                    اضافه جديد
                </a>
            </div>
        </div>




        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            All Permissions </h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control pull-right"
                                       placeholder="Search">

                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>ID</th>
                                <th>اسم الصلاحيه</th>
                                <th>الصلاحيه ل</th>
                                <th>الحدث</th>
                            </tr>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>{{$permission->id}}</td>
                                    <td>{{$permission->title}}</td>
                                    <td>{{$permission->for}}</td>
                                    <td>
                                        <a href="{{url('/permission/'.$permission->id.'/edit')}}" class="btn btn-info btn-circle"><i class="fa fa-edit"></i></a>
                                        <a href="{{url('/permission/'.$permission->id.'/delete')}}" class="btn btn-danger btn-circle"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>

                </div>
                <!-- /.box -->
            </div>
        </div>


    </section>


@endsection
