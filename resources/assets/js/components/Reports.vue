<template>

    <div id="reports">
        <div class="row">
            <div class="container">
                <h1 class="text-center"><b class="h1 head">تتبع مزودي الخدمة</b> </h1>
                <el-row>
                    <el-col :span="12">

                        <!-- Select BasicService -->
                        <div class="sp-100"><div class="block">
                            <span class="demonstration title serve">الخدمات الرئيسية</span>
                            <el-checkbox-group v-model="form.services_id">
                                <el-checkbox
                                        v-on:change="activeAll"
                                        :value=0
                                        :key=0
                                        label=0
                                ><p class="h4">جميع الخدمات</p>
                                </el-checkbox>
                                <el-checkbox
                                        v-show="AllIsActive"
                                        v-on:change="getSecondaries"
                                        v-for ="service in services"
                                        :key ="service.services_id"
                                        :value="service.services_id"
                                        :label="service.services_id"><p class="h4">@{{service.services_name_ar}}</p></el-checkbox>
                            </el-checkbox-group>
                        </div></div>
                        <!-- Select SecondaryService -->
                        <div class="sp-100"><div class="block"
                                                 v-show="form.services_id.length == 1  && form.services_id[0] != '0'" >
                            <span class="demonstration title  serve">الخدمات الفرعية</span>
                            <el-checkbox-group
                                    v-model="form.sub_services_id">
                                <el-checkbox
                                        v-on:change="AllSecondary"
                                        :value=0
                                        :key=0
                                        label=0
                                ><p class="h4">جميع الخدمات الفرعية</p>
                                </el-checkbox>
                                <el-checkbox
                                        v-show="AllIsSecondary"
                                        v-for ="secondary in secondaries"
                                        :key ="secondary.sub_services_id"
                                        :value="secondary.sub_services_id"
                                        :label="secondary.sub_services_id"><p class="h4">@{{secondary.sub_services_name_ar}}</p></el-checkbox>
                            </el-checkbox-group>
                        </div></div>

                        <el-button
                                @click="sendForm()"
                                type="primary"
                                icon="el-icon-view">    اعرض</el-button>
                    </el-col>
                </el-row>


            </div>


            <!--<div id="map_canvas" style="width: 800px; height: 400px; margin-right: 120px"></div>-->



        </div>
    </div>


</template>

<script>
    export default {
        name:"reports",
        data: function () {
            return{
                url: 'http://127.0.0.1:8000/',
                form : {
                    services_id :[] ,
                    sub_services_id:[]
                },
                services : [] ,
                secondaries:[],
                AllIsActive:true,

                AllIsSecondary:true ,
                secondaryIsHere : false ,
            }
        }
            ,
        created : function() {
            var self = this;


        },mounted: function () {
            var self = this;
            self.getServices();

        },
        methods : {

            getServices:function(){
                var self = this ;
                axios.get('mainServices?lang=ar')
                    .then(function(response){
                        self.services = response.data ;
                        console.log(self.services);
                    }).catch(function (error) {
                    console.log(error);
                });
            },
            getSecondaries:function(){
                var self = this ;
                axios.get('subServices/'+self.form.services_id[0]+'?lang=ar')
                    .then(function(response){
                        self.secondaries = response.data ;
                        console.log(self.secondaries);
                        self.secondaryIsHere = true ;
                    }).catch(function (error) {
                    console.log(error);
                });


            },
            activeAll: function(){
                this.AllIsActive = !this.AllIsActive;
                console.log(this.form.services_id) ;
            },
            AllSecondary:function(){
                this.AllIsSecondary = !this.AllIsSecondary;
            },
            sendForm:function(){
                var self = this;
                axios.post(self.url+'sendFollowProviderReport', self.form)
                    .then(function(response){
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }




        }
    }
</script>
