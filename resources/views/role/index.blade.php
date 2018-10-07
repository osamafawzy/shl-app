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
                <a href="{{url('/role/create')}}" class="btn btn-primary pull-right margin-bottom">
                    <i class="fa fa-plus"></i>
                    اضف جديد
                </a>
            </div>
        </div>




        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">

                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->title}}</td>
                                    <td>
                                        <a href="{{url('/role/'.$role->id.'/edit')}}" class="btn btn-info btn-circle"><i class="fa fa-edit"></i></a>
                                        <a href="{{url('/role/'.$role->id.'/delete')}}" class="btn btn-danger btn-circle"><i class="fa fa-trash-o"></i></a>
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
