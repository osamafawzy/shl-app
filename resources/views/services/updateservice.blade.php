@extends('admintempate.admintempate')

@section('page-style-level')
    <style>
        /*@import url("//unpkg.com/element-ui@2.3.9/lib/theme-chalk/index.css");*/

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
    <div id="updatedServices">
        <div class="sp-50"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                تعديل خدمة
            </div>
            <div class="sp-50"></div>

            <div class="panel-body">
                <div :model="ServicesForm">
                    <div class="row">
                        <div class="col-md-2"><label for="services"> اسم الخدمة الرئيسية:</label>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="الخدمة الرئيسية" v-model="ServicesForm.services_name_ar"
                                   class="form-control" id="services"/>
                        </div>
                        <div class="col-md-2">
                            <input placeholder="الخدمة الرئيسية بالانجليزية" v-model="ServicesForm.services_name_en"
                                   class="form-control" id="services"
                            >
                        </div>
                        <div class="col-md-2">
                            <input placeholder="الخدمة الرئيسية بالاردو" v-model="ServicesForm.services_name_ur"
                                   class="form-control" id="services"/>
                        </div>
                        <div class="col-md-2">
                            <input type="file" @change="ConvertServicesIamge()" class="form-control"
                                   id="services_icone"/>
                        </div>
                        <div class="col-md-2">
                            <img :src="'http://admin.shl-app.com/'+ServicesForm.icone" class="img-responsive"
                                 id="services_icone" width="70px" height="70px">
                        </div>
                    </div>
                    <div class="sp-10"></div>
                    <div class="row" v-for="(sub_services,index) in ServicesForm.sub_services">
                        <div class="sp-10"></div>
                        <div class="col-md-2">
                            <label for="sub_services"> اسم الخدمة الفرعية: </label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" placeholder="الخدمة الفرعية" id="sub_services_ar"
                                   v-model="sub_services.sub_services_name_ar" class="form-control"/>
                        </div>
                        <div class="col-md-2">
                            <input type="text" placeholder="الخدمة الفرعية بالانجليزية" id="sub_services_en"
                                   v-model="sub_services.sub_services_name_en" class="form-control"/>
                        </div>
                        <div class="col-md-2">
                            <input type="text" placeholder="الخدمة الفرعية بالاورديه" id="sub_services_ur"
                                   v-model="sub_services.sub_services_name_ur" class="form-control"/>
                        </div>
                        <div class="col-md-2">
                            <input type="file" :id=index class="sub_services_icone form-control"
                                   @change="ConvertIamge(index)">
                        </div>
                        <div class="col-md-1">
                            <img width="100px" width="100px" src="" :src="'http://admin.shl-app.com/'+sub_services.icone"
                                 :id=index+'img' class="img-responsive">

                        </div>
                        <div class="col-md-1">
                            <el-button type="danger" icon="el-icon-delete"
                                       @click="RemoveSubSerives(index,sub_services,ServicesForm.sub_services)"></el-button>

                        </div>
                        <div class="sp-10"></div>
                    </div>

                    <div class="sp-10"></div>
                    <div class="row">
                        <div class="col-md-12">
                            <center>
                                <button type="button" class="btn btn-success el-icon-circle-plus"
                                        @click="AddMordeSubServices()"> اضف خدمة
                                    فرعية جديدة
                                </button>

                            </center>
                        </div>

                    </div>
                    <div class="sp-10"></div>
                    <div class="sp-10"></div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="Service_color">لون الخدمة </label>
                        </div>
                        <div class="col-md-2">
                            <center>
                                <input v-model="ServicesForm.color" type="color" class="form-control">
                            </center>
                        </div>
                    </div>
                    <div class="sp-10"></div>
                    <div class="sp-10"></div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="WorkDays">ايام العمل</label>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <el-radio v-model="ServicesForm.type" label="1"> 24 ساعة</el-radio>
                            </div>
                            <div class="form-group">
                                <el-checkbox v-model="ServicesForm.saturday"><h4>السبت</h4></el-checkbox>
                                <el-checkbox v-model="ServicesForm.sunday"><h4>الاحد</h4></el-checkbox>
                                <el-checkbox v-model="ServicesForm.monday"><h4>الاثنين</h4></el-checkbox>
                                <el-checkbox v-model="ServicesForm.tuesday"><h4>الثلاثاء</h4></el-checkbox>
                                <el-checkbox v-model="ServicesForm.wednesday"><h4>الاربعاء</h4></el-checkbox>
                                <el-checkbox v-model="ServicesForm.thursday"><h4>الخميس</h4></el-checkbox>
                                <el-checkbox v-model="ServicesForm.friday"><h4>الجمعة</h4></el-checkbox>
                            </div>
                            <div class="form-group">
                                <el-radio v-model="ServicesForm.type" label="2">مجدول 2</el-radio>
                            </div>
                            <div v-for="services_work_preiod in ServicesForm.services_work_preiod">

                                <div class="form-group">
                                    <el-time-select
                                            v-model="services_work_preiod.from_hr"
                                            :picker-options="{
                                            start: '00:00',
                                            step: '01:00',
                                             end: '24:00'
                                             }"
                                            placeholder="من ساعة">
                                    </el-time-select>


                                    <el-time-select
                                            v-model="services_work_preiod.to_hr"
                                            :picker-options="{
                                                start: '00:00',
                                                step: '01:00',
                                                end: '24:00'
                                            }"
                                            placeholder="الى ساعة">
                                    </el-time-select>
                                </div>
                                <div class="form-group">
                                    <el-checkbox v-model="services_work_preiod.saturday"><h4>السبت</h4></el-checkbox>
                                    <el-checkbox v-model="services_work_preiod.sunday"><h4>الاحد</h4></el-checkbox>
                                    <el-checkbox v-model="services_work_preiod.monday"><h4>الاثنين</h4></el-checkbox>
                                    <el-checkbox v-model="services_work_preiod.tuesday"><h4>الثلاثاء</h4></el-checkbox>
                                    <el-checkbox v-model="services_work_preiod.wednesday"><h4>الاربعاء</h4>
                                    </el-checkbox>
                                    <el-checkbox v-model="services_work_preiod.thursday"><h4>الخميس</h4></el-checkbox>
                                    <el-checkbox v-model="services_work_preiod.friday"><h4>الجمعة</h4></el-checkbox>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-success el-icon-circle-plus"
                                        @click="AddSechdule()"> اضف مجدول
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="sp-10"></div>

                    <div class="row">
                        <div class="col-md-2">
                            <label class="PricesType">الاسعار</label>
                        </div>
                        <div class="col-md-10">
                            <el-radio v-model="ServicesForm.price_type" label="1">محدد</el-radio>
                            <el-radio v-model="ServicesForm.price_type" label="2"> غير محدد</el-radio>
                            <el-checkbox v-model="ServicesForm.price_type_visiable">تظهر للعميل قبل تأكيد تسجيل الطلب
                            </el-checkbox>
                        </div>
                    </div>
                    <div class="sp-10"></div>
                    <div class="row">
                        <div class="col-md-2"><h4>عموله التطبيق على الطلبات المكتملة </h4></div>
                        <div class="col-md-10">
                            <div class="form-group" v-for="ServicesForm in ServicesForm.services_commission">
                                <el-radio v-model="ServicesForm.commission_type" label="1">نسبه
                                    <input type="text" v-model="ServicesForm.commission_precent"
                                           :disabled="ServicesForm.commission_type === '2'"
                                           class="form-control col-md-3">
                                </el-radio>
                                &nbsp;&nbsp;&nbsp;
                                <el-radio v-model="ServicesForm.commission_type" label="2">مبلغ ثابت
                                    <input type="text" v-model="ServicesForm.commission_cash"
                                           :disabled="ServicesForm.commission_type === '1'"
                                           class="form-control col-md-3">
                                </el-radio>
                            </div>
                        </div>
                    </div>
                    <div class="sp-10"></div>
                    <div class="row">
                        <div class="col-md-2"><h4> الحد الائتمانى لمزود الخدمة </h4></div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <el-radio v-model="ServicesForm.provider_credit_limit_type" label="1">عدد الطلبات
                                    <input type="text" v-model="ServicesForm.credit_limit_finsih_order"
                                           :disabled="ServicesForm.provider_credit_limit_type === '2'"
                                           class="form-control col-md-3">
                                    / طلبات مكتمله
                                </el-radio>
                                &nbsp;&nbsp;&nbsp;
                                <el-radio v-model="ServicesForm.provider_credit_limit_type" label="2">اجمالى القيمة
                                    <input type="text" v-model="ServicesForm.credit_limit_total"
                                           :disabled="ServicesForm.provider_credit_limit_type === '1'"
                                           class="form-control col-md-3">
                                </el-radio>
                            </div>
                        </div>
                    </div>

                    <div class="sp-10"></div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="minimumrate">الحد الاقصى للبحث عن مزود الخدمة </label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" v-model="ServicesForm.serach_provider_limit"
                                   class="form-control col-md-2">
                        </div>
                        <div class="col-md-2">
                            كيلومتر
                        </div>
                    </div>
                    <div class="sp-10"></div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="minimumrate">الحد الادنى للتقيم لاظهار كتابه النص</label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" v-model="ServicesForm.minimum_time_rate_boxwrite"
                                   class="form-control col-md-2">
                        </div>
                        <div class="col-md-2">
                            نجمة
                        </div>
                    </div>
                    <div class="sp-10"></div>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="minimumrate">الحدالاقصى لعمل طلب مجدول</label>
                        </div>
                        <div class="col-md-2">
                            <input type="text" v-model="ServicesForm.maxmum_schedule_order"
                                   class="form-control col-md-2">
                        </div>
                        <div class="col-md-2">
                            ساعة
                        </div>
                    </div>
                    <div class="sp-10"></div>
                    <div v-for="ServicesForm in ServicesForm.service_type">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="">نوع الخدمة</label>
                            </div>
                            <div class="col-md-4">

                                <el-radio
                                        v-model="ServicesForm.services_type"
                                        label="1">موقع
                                    واحد
                                </el-radio>
                                &nbsp;&nbsp;&nbsp;
                            </div>
                            <div class="col-md-4">
                                <el-radio v-model="ServicesForm.services_type"
                                          label="2">موقعين
                                </el-radio>
                                &nbsp;&nbsp;&nbsp;

                            </div>
                        </div>
                        <div class="sp-10"></div>
                        <div class="sp-10"></div>
                        <div class="row">
                            <div class="col-md-2" v-show="ServicesForm.services_type === '2'"><label for="">طريقة
                                    الدفع</label>
                            </div>
                            <div class="col-md-4 " v-show="ServicesForm.services_type === '2'">
                                <el-radio v-model="ServicesForm.serivces_payment_type_id"
                                          label="1">كاش
                                </el-radio>


                                <el-radio v-model="ServicesForm.serivces_payment_type_id"
                                          label="2"> اخرى
                                </el-radio>
                            </div>

                            <div class="col-md-2" v-show="ServicesForm.services_type === '1'">
                                <label for="">طريقة الدفع</label>
                            </div>

                            <div class="col-md-4" v-show="ServicesForm.services_type === '1'">
                                <el-radio v-model="ServicesForm.serivces_payment_type_id"
                                          label="1">كاش
                                </el-radio>

                                <el-radio v-model="ServicesForm.serivces_payment_type_id"
                                          label="2"> اخرى
                                </el-radio>
                            </div>

                        </div>
                        <div class="sp-10"></div>
                        <div class="sp-10"></div>
                        <div class="row">
                            <div class="col-md-2" v-show="ServicesForm.services_type === '1'"><label for="">مدة انتقال
                                    العرض
                                    من مزود لاخر</label></div>
                            <div class="col-md-4" v-show="ServicesForm.services_type === '1'"><input
                                        v-model="ServicesForm.request_time_duration" type="text"
                                        class="form-control" placeholder="ثانيه">
                            </div>
                            <div class="col-md-push-6">
                                <div class="col-md-2" v-show="ServicesForm.services_type === '2'"><label for=""> عدد
                                        العروض</label></div>
                                <div class="col-md-2" v-show="ServicesForm.services_type === '2'">
                                    <input type="text" v-model="ServicesForm.offer_count" class="form-control">
                                </div>
                                <div class="col-md-1" v-show="ServicesForm.services_type === '2'"><label for=""> مدة
                                        فاعليه
                                        العروض </label></div>
                                <div class="col-md-2" v-show="ServicesForm.services_type === '2'">
                                    <input type="text" v-model="ServicesForm.offer_time" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="sp-10"></div>
                    <div class="sp-10"></div>
                    <div class="sp-10"></div>
                    <div class="row">
                        <div class="col-md-6 col-md-push-5">
                            <button type="button" class="btn btn-success col-md-4" @click="Save()">حفظ</button>
                        </div>
                    </div>
                    <div class="sp-50"></div>
                    </form>
                </div>
            </div>
        </div>
        @endsection
        @section('page-script-level')
            <script src="{{asset('AppAdmin/updated_services.js')}}"></script>
@endsection