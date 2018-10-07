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
                @can('manager.create',\Illuminate\Support\Facades\Auth::user())
                    <a href="{{url('/manager/create')}}" class="btn btn-primary pull-right margin-bottom">
                        <i class="fa fa-plus"></i>
                        اضافه جديد
                    </a>
                @endcan
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            كل الاعضاء </h3>
                    </div>

                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>ID</th>
                                <th>الاسم</th>
                                <th>البريد الالكتروني</th>
                                <th>الوظيفه</th>
                                <th>الحدث</th>
                            </tr>
                            @foreach($managers as $manager)
                                <tr>
                                    <td>{{$manager->id}}</td>
                                    <td>{{$manager->name}}</td>
                                    <td>{{$manager->email}}</td>
                                    <td>
                                        @foreach ($manager->roles as $manager_role)
                                            {{$manager_role->title}},
                                        @endforeach
                                    </td>
                                    <td>
                                        @can('manager.update',\Illuminate\Support\Facades\Auth::user())
                                            <a href="{{url('/manager/'.$manager->id.'/edit')}}" class="btn btn-info btn-circle"><i class="fa fa-edit"></i></a>
                                          @endcan
                                            @can('manager.delete',\Illuminate\Support\Facades\Auth::user())
                                                <a href="{{url('/manager/'.$manager->id.'/delete')}}" class="btn btn-danger btn-circle"><i class="fa fa-trash-o"></i></a>
                                        @endcan
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
