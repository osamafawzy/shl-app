@extends('admintempate.admintempate')

@section('page-style-level')
    <style>


        .dir {
            direction: rtl;
        }

        .sp-50 {
            width: 100%;
            height: 50px;
        }

        .sp-10 {
            width: 100%;
            height: 10px;
        }

    </style>
@endsection

@section('content')
    <div id="contact_us">
        <div class="row">
            <div class="sp-10"></div>
            <data-tables :data="ContactUsData"
                         v-loading="loading"
                         :show-action-bar="false"
                         :custom-filters="customFilters"
                         :actions-def="actionsDef">
                <el-row slot="custom-tool-bar" style="margin-bottom: 10px ; text-align: center">
                    <el-col :span="5">
                        <el-input v-model="customFilters[0].vals">
                        </el-input>
                    </el-col>

                    <el-col :span="19">
                        <el-button type="success" data-toggle="modal"
                                   @Click="GotoAddNewServices({},{},dialogFormVisible=true,false)">اضافه وسيله اتصال
                            جديدة
                        </el-button>
                    </el-col>

                </el-row>

                <el-table-column label="">
                    <template slot-scope="scope">

                        <el-button
                                class="el-icon-edit"
                                size="medium"
                                type="warning"
                                @click="GotoAddNewServices(scope.$index,scope.row,dialogFormVisible = true,true)">
                            &nbsp;&nbsp;
                            تعديل
                        </el-button>
                    </template>
                </el-table-column>
                <el-table-column
                        prop="phone"
                        label="ارقام الهاتف"
                >
                </el-table-column>

                <el-table-column
                        prop="address_ar"
                        label="العنوان بالعربية"
                >
                </el-table-column>
                <el-table-column
                        prop="address_en"
                        label="العنوان بالانجليزية"
                >
                </el-table-column>
                <el-table-column
                        prop="adress_ur"
                        label="العنوان بالاوردية"
                >
                </el-table-column>
                <el-table-column
                        prop="email"
                        label="البريد الالكترونى"
                >
                </el-table-column>

                <el-table-column label="">
                    <template slot-scope="scope">
                        <el-button
                                class="el-icon-delete"
                                size="medium"
                                type="danger"
                                @click="DeleteFromContactUs(scope.$index, scope.row)">
                            &nbsp;&nbsp;
                            حذف
                        </el-button>
                    </template>
                </el-table-column>
            </data-tables>
        </div>

        <el-dialog title="اضافة وصيلة تواصل" class="dir" :visible.sync="dialogFormVisible">
            <el-form :model="ContactUsForm" :rules="rules" ref="ContactUsForm" label-width="120px"
                     class="demo-ruleForm">

                <el-form-item label="" :label-width="formLabelWidth" prop="phone">
                    الجوال
                    <el-input v-model="ContactUsForm.phone" auto-complete="on"></el-input>
                </el-form-item>

                <el-form-item label="" :label-width="formLabelWidth" prop="address_ar">
                    العنوان بالعربية
                    <el-input v-model="ContactUsForm.address_ar" auto-complete="on"></el-input>
                </el-form-item>

                <el-form-item label="" :label-width="formLabelWidth" prop="address_en">
                    العنوان بالانجليزية
                    <el-input v-model="ContactUsForm.address_en" auto-complete="on"></el-input>
                </el-form-item>

                <el-form-item label=" " :label-width="formLabelWidth" prop="adress_ur">
                    العنوان بالاوردية
                    <el-input v-model="ContactUsForm.adress_ur" auto-complete="on"></el-input>
                </el-form-item>

                <el-form-item label="" :label-width="formLabelWidth" prop="email">
                    البريد الالكترونى
                    <el-input v-model="ContactUsForm.email" auto-complete="on"></el-input>
                </el-form-item>

            </el-form>
            <span slot="footer" class="dialog-footer">
    <el-button @click="resetForm('ContactUsForm'),dialogFormVisible = false">الغاء</el-button>
    <el-button type="primary" @click="AddCountact('ContactUsForm')">حفظ</el-button>
  </span>
        </el-dialog>

    </div>
@endsection
@section('page-script-level')
    <script src="{{asset('AppAdmin/contact_us.js')}}"></script>
@endsection