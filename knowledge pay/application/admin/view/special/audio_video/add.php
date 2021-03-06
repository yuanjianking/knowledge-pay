{extend name="public/container"}
{block name='head_top'}
<style>
    .layui-form-item .special-label {
        width: 50px;
        float: left;
        height: 30px;
        line-height: 38px;
        margin-left: 10px;
        margin-top: 5px;
        border-radius: 5px;
        background-color: #0092DC;
        text-align: center;
    }

    .layui-form-item .special-label i {
        display: inline-block;
        width: 18px;
        height: 18px;
        font-size: 18px;
        color: #fff;
    }

    .layui-form-item .label-box {
        border: 1px solid;
        border-radius: 10px;
        position: relative;
        padding: 10px;
        height: 30px;
        color: #fff;
        background-color: #393D49;
        text-align: center;
        cursor: pointer;
        display: inline-block;
        line-height: 10px;
    }

    .layui-form-item .label-box p {
        line-height: inherit;
    }

    .layui-form-mid {
        margin-left: 18px;
    }

    .m-t-5 {
        margin-top: 5px;
    }

    .edui-default .edui-for-image .edui-icon {
        background-position: -380px 0px;
    }
</style>
<script type="text/javascript" charset="utf-8"
        src="{__ADMIN_PATH}plug/ueditor/third-party/zeroclipboard/ZeroClipboard.js"></script>
<script type="text/javascript" charset="utf-8" src="{__ADMIN_PATH}plug/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="{__ADMIN_PATH}plug/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="{__ADMIN_PATH}plug/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="{__ADMIN_PATH}js/aliyun-oss-sdk-4.4.4.min.js"></script>
<script type="text/javascript" src="{__ADMIN_PATH}js/request.js"></script>
<script type="text/javascript" src="{__MODULE_PATH}widget/lib/plupload-2.1.2/js/plupload.full.min.js"></script>
<script type="text/javascript" src="{__MODULE_PATH}widget/OssUpload.js"></script>
{/block}
{block name="content"}
<div class="layui-fluid" style="background: #fff">
    <div class="layui-row layui-col-space15" id="app">
        <form action="" class="layui-form">
            <div class="layui-col-md12">
                <div class="layui-card" v-cloak="">
                    <div class="layui-card-header">????????????</div>
                    <div class="layui-card-body" style="padding: 10px 150px;">
                        <div class="layui-form-item m-t-5">
                            <label class="layui-form-label">????????????</label>
                            <div class="layui-input-block">
                                <input type="text" name="title" v-model="formData.title" autocomplete="off"
                                       placeholder="?????????????????????" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item m-t-5">
                            <label class="layui-form-label">????????????</label>
                            <div class="layui-input-block">
                                <select name="subject_id" v-model="formData.subject_id" lay-search=""
                                        lay-filter="subject_id">
                                    <option value="0">????????????</option>
                                    <option :value="item.id" v-for="item in subject_list">{{item.name}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="layui-form-item m-t-5">
                            <label class="layui-form-label">????????????</label>
                            <div class="layui-input-block">
                                <textarea placeholder="?????????????????????" v-model="formData.abstract"
                                          class="layui-textarea"></textarea>
                            </div>
                        </div>
                        <div class="layui-form-item m-t-5">
                            <label class="layui-form-label">????????????</label>
                            <div class="layui-input-block">
                                <textarea placeholder="?????????????????????" v-model="formData.phrase"
                                          class="layui-textarea"></textarea>
                            </div>
                        </div>
                        <!--<div class="layui-form-item m-t-5" v-if="is_live">
                            <label class="layui-form-label" v-text="'????????????'"></label>
                            <div class="layui-input-block">
                                <textarea placeholder="???????????????????????????????????????" v-model="formData.auto_phrase" class="layui-textarea"></textarea>
                            </div>
                        </div>-->
                        <div class="layui-form-item m-t-5">
                            <label class="layui-form-label">????????????</label>
                            <div class="layui-input-block">
                                <input type="number" style="width: 20%" name="sort" v-model="formData.sort"
                                       autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item m-t-5" v-cloak="">
                            <div class="layui-inline">
                                <label class="layui-form-label" style="margin-right: 28px">????????????</label>
                                <div class="layui-input-inline" style="width: 300px;">
                                    <input type="text" v-model="label" name="price_min" placeholder="??????4??????"
                                           autocomplete="off" class="layui-input" style="float: left;width: 200px">
                                    <p class="special-label" @click="addLabrl"><i class="fa fa-plus"
                                                                                  aria-hidden="true"></i></p>
                                </div>
                            </div>
                            <div class="layui-input-block">
                                <div class="label-box" v-for="(item,index) in formData.label" @click="delLabel(index)">
                                    <p>{{item}}</p>
                                </div>
                            </div>
                            <div class="layui-form-mid layui-word-aux">??????????????????????????????+???????????????;????????????6??????;?????????????????????</div>
                        </div>
                        <div class="layui-form-item m-t-5" v-cloak="">
                            <label class="layui-form-label">????????????</label>
                            <div class="layui-input-block">
                                <div class="upload-image-box" v-if="formData.image" @mouseenter="mask.image = true"
                                     @mouseleave="mask.image = false">
                                    <img :src="formData.image" alt="">
                                    <div class="mask" v-show="mask.image" style="display: block">
                                        <p><i class="fa fa-eye" @click="look(formData.image)"></i><i
                                                    class="fa fa-trash-o" @click="delect('image')"></i></p>
                                    </div>
                                </div>
                                <div class="upload-image" v-show="!formData.image" @click="upload('image')">
                                    <div class="fiexd"><i class="fa fa-plus"></i></div>
                                    <p>????????????</p>
                                </div>
                            </div>
                            <div class="layui-form-item m-t-5" v-cloak="">
                                <label class="layui-form-label">??????banner</label>
                                <div class="layui-input-block">
                                    <div class="upload-image-box" v-if="formData.banner.length"
                                         v-for="(item,index) in formData.banner" @mouseenter="enter(item)"
                                         @mouseleave="leave(item)">
                                        <img :src="item.pic" alt="">
                                        <div class="mask" v-show="item.is_show" style="display: block">
                                            <p><i class="fa fa-eye" @click="look(item)"></i><i class="fa fa-trash-o"
                                                                                               @click="delect('banner',index)"></i>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="upload-image" v-show="formData.banner.length <= 3"
                                         @click="upload('banner',5)">
                                        <div class="fiexd"><i class="fa fa-plus"></i></div>
                                        <p>????????????</p>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item m-t-5" v-cloak="">
                                <label class="layui-form-label">????????????</label>
                                <div class="layui-input-block">
                                    <div class="upload-image-box" v-if="formData.poster_image"
                                         @mouseenter="mask.poster_image = true" @mouseleave="mask.poster_image = false">
                                        <img :src="formData.poster_image" alt="">
                                        <div class="mask" v-show="mask.poster_image" style="display: block">
                                            <p><i class="fa fa-eye" @click="look(formData.poster_image)"></i><i
                                                        class="fa fa-trash-o" @click="delect('poster_image')"></i></p>
                                        </div>
                                    </div>
                                    <div class="upload-image" v-show="!formData.poster_image"
                                         @click="upload('poster_image')">
                                        <div class="fiexd"><i class="fa fa-plus"></i></div>
                                        <p>????????????</p>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item m-t-5" v-cloak="">
                                <label class="layui-form-label">???????????????</label>
                                <div class="layui-input-block">
                                    <div class="upload-image-box" v-if="formData.service_code"
                                         @mouseenter="mask.service_code = true" @mouseleave="mask.service_code = false">
                                        <img :src="formData.service_code" alt="">
                                        <div class="mask" v-show="mask.service_code" style="display: block">
                                            <p><i class="fa fa-eye" @click="look(formData.service_code)"></i><i
                                                        class="fa fa-trash-o" @click="delect('service_code')"></i></p>
                                        </div>
                                    </div>
                                    <div class="upload-image" v-show="!formData.service_code"
                                         @click="upload('service_code')">
                                        <div class="fiexd"><i class="fa fa-plus"></i></div>
                                        <p>????????????</p>
                                    </div>
                                </div>
                            </div>

                            <!--<div class="layui-form-item m-t-5" v-show="is_live">
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="margin-right: 28px">????????????</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="live_time" v-model="formData.live_time" id="live_time" autocomplete="off" class="layui-input" placeholder="????????????">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">????????????</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="is_remind" lay-filter="is_remind" v-model="formData.is_remind" value="1" title="???">
                                        <input type="radio" name="is_remind" lay-filter="is_remind" v-model="formData.is_remind" value="0" title="???">
                                    </div>
                                </div>
                                <div class="layui-form-item" v-show="formData.is_remind == 1">
                                    <label class="layui-form-label">????????????</label>
                                    <div class="layui-input-block">
                                        <input type="text" name="time" lay-verify="number" id="remind_time"  v-model="formData.remind_time" autocomplete="off" class="layui-input" placeholder="???????????????">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label">????????????</label>
                                    <div class="layui-input-block">
                                        <input type="number" name="time" lay-verify="number" v-model="formData.live_duration" autocomplete="off" class="layui-input" placeholder="???????????????">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">????????????</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="is_recording" lay-filter="is_recording" v-model="formData.is_recording" value="1" title="???">
                                        <input type="radio" name="is_recording" lay-filter="is_recording" v-model="formData.is_recording" value="0" title="???">
                                    </div>
                                </div>
                            </div>-->
                            <div class="layui-form-item m-t-5">
                                <label class="layui-form-label">????????????</label>
                                <div class="layui-input-block">
                                    <input type="text" name="title" v-model="link"
                                           style="width:50%;display:inline-block;margin-right: 10px;" autocomplete="off"
                                           placeholder="?????????????????????" class="layui-input">
                                    <button type="button" class="layui-btn layui-btn-sm layui-btn-normal"
                                            @click="uploadVideo()">????????????
                                    </button>
                                    <button type="button" class="layui-btn layui-btn-sm layui-btn-normal"
                                            id="ossupload">????????????
                                    </button>
                                </div>
                                <input type="file" name="video" v-show="" ref="video">
                                <div class="layui-input-block" style="width: 50%;margin-top: 20px" v-show="is_video">
                                    <div class="layui-progress" style="margin-bottom: 10px">
                                        <div class="layui-progress-bar layui-bg-blue"
                                             :style="'width:'+videoWidth+'%'"></div>
                                    </div>
                                    <button type="button" class="layui-btn layui-btn-sm layui-btn-danger"
                                            @click="cancelUpload">??????
                                    </button>
                                </div>
                                <div class="layui-form-mid layui-word-aux">?????????????????????????????????????????????,?????????????????????????????????</div>
                            </div>
                            <div class="layui-form-item m-t-5">
                                <label class="layui-form-label">????????????</label>
                                <div class="layui-input-block">
                                    <textarea id="myEditor"
                                              style="width:100%;height: 500px">{{formData.content}}</textarea>
                                </div>
                            </div>
                            <div class="layui-form-item m-t-5">
                                <label class="layui-form-label">????????????</label>
                                <div class="layui-input-block">
                                    <input type="hidden" id="check_source_tmp" name="check_source_tmp"/>
                                    <button type="button" class="layui-btn layui-btn-fluid" @click='search_task'>
                                        ??????????????????
                                    </button>
                                    <table class="layui-hide"  id="List" lay-filter="List"></table>
                                    <script type="text/html" id="toolbarDemo" >
                                        <div class="layui-btn-container">
                                            <a class="layui-btn layui-btn-xs" lay-event="getCheckData">??????</a>
                                        </div>
                                    </script>
                                </div>
                            </div>
                            <div class="layui-form-item m-t-5">
                                <label class="layui-form-label">????????????</label>
                                <div class="layui-input-block">
                                    <input type="hidden" id="check_source_sure" name="check_source_sure"/>
                                    <table class="layui-hide" id="showSourceList" lay-filter="showSourceList"></table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md12">
                    <div class="layui-card">
                        <div class="layui-card-header">????????????</div>
                        <div class="layui-card-body" style="padding: 10px 150px;">
                            <div class="layui-form-item">
                                <label class="layui-form-label">????????????</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="pay_type" lay-filter="pay_type"
                                           v-model="formData.pay_type" value="1" title="??????">
                                    <input type="radio" name="pay_type" lay-filter="pay_type"
                                           v-model="formData.pay_type" value="0" title="??????">
                                    <!--<input type="radio" name="pay_type" lay-filter="pay_type" v-model="formData.pay_type" value="2" title="??????" >-->
                                </div>
                            </div>
                            <div class="layui-form-item" v-show="formData.pay_type == 1">
                                <label class="layui-form-label">????????????</label>
                                <div class="layui-input-block">
                                    <input style="width: 20%" type="number" name="money" lay-verify="number"
                                           v-model="formData.money" autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">??????????????????</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="member_pay_type" lay-filter="member_pay_type"
                                               v-model="formData.member_pay_type" value="1" title="??????">
                                        <input type="radio" name="member_pay_type" lay-filter="member_pay_type"
                                               v-model="formData.member_pay_type" value="0" title="??????">
                                    </div>
                                </div>
                                <div class="layui-form-item" v-show="formData.member_pay_type == 1">
                                    <label class="layui-form-label">??????????????????</label>
                                    <div class="layui-input-block">
                                        <input style="width: 20%" type="number" name="member_money" lay-verify="number"
                                               v-model="formData.member_money" autocomplete="off" class="layui-input" min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item" v-show="formData.pay_type == 1">
                                <label class="layui-form-label">??????????????????</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="is_pink" lay-filter="is_pink" v-model="formData.is_pink"
                                           value="0" title="??????" checked="">
                                    <input type="radio" name="is_pink" lay-filter="is_pink" v-model="formData.is_pink"
                                           value="1" title="??????">
                                </div>
                            </div>

                            <div class="layui-form-item" v-show="formData.is_pink">
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="margin-right: 28px">????????????</label>
                                    <div class="layui-input-inline">
                                        <input type="number" name="pink_money" v-model="formData.pink_money"
                                               autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label">????????????</label>
                                    <div class="layui-input-inline">
                                        <input type="number" name="pink_number" v-model="formData.pink_number"
                                               autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item" v-show="formData.is_pink">
                                <div class="layui-inline">
                                    <label class="layui-form-label" style="margin-right: 28px">????????????</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="pink_strar_time" v-model="formData.pink_strar_time"
                                               id="start_time" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-inline">
                                    <label class="layui-form-label">????????????</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="pink_end_time" v-model="formData.pink_end_time"
                                               id="end_time" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item" v-show="formData.is_pink">
                                <label class="layui-form-label">????????????</label>
                                <div class="layui-input-block">
                                    <input style="width: 20%" type="number" v-model="formData.pink_time"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item" v-show="formData.is_pink">
                                <label class="layui-form-label">????????????</label>
                                <div class="layui-input-block">
                                    <input type="radio" name="is_fake_pink" lay-filter="is_fake_pink"
                                           v-model="formData.is_fake_pink" value="1" title="??????" checked="">
                                    <input type="radio" name="is_fake_pink" lay-filter="is_fake_pink"
                                           v-model="formData.is_fake_pink" value="0" title="??????">
                                </div>
                            </div>
                            <div class="layui-form-item" v-show="formData.is_fake_pink && formData.is_pink">
                                <label class="layui-form-label">????????????</label>
                                <div class="layui-input-block">
                                    <input style="width: 20%" type="number" v-model="formData.fake_pink_number"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="layui-col-md12">
                    <div class="layui-form-item submit" style="margin-bottom: 10px">
                        <div class="layui-input-block">
                            <button class="layui-btn layui-btn-normal" type="button" @click="save">{$id ?
                                '????????????':'????????????'}
                            </button>
                            <button class="layui-btn layui-btn-primary clone" type="button" @click="clone_form">??????
                            </button>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>
<script type="text/javascript" src="{__ADMIN_PATH}js/layuiList.js"></script>
{/block}
{block name='script'}
<script>
    var id = {$id},
        special =<?=isset($special) ? $special : "{}"?>,
        checkStatus;
        sourceCheckList =<?= isset($sourceCheckList) ? $sourceCheckList : "{}"?>;
        require(['vue'], function (Vue) {
            new Vue({
                el: "#app",
                data: {
                    subject_list: [],
                    source_tmp_list:[],//???????????????????????????????????????????????????
                    source_list: [],
                    formData: {
                        phrase: special.phrase || '',
                        label: special.label || [],
                        abstract: special.abstract || '',
                        title: special.title || '',
                        subject_id: special.subject_id || 0,
                        task_id: 0,
                        image: special.image || '',
                        banner: special.banner || [],
                        poster_image: special.poster_image || '',
                        service_code: special.service_code || '',
                        money: special.money || '',
                        pink_money: special.pink_money || '',
                        pink_number: special.pink_number || 0,
                        pink_strar_time: special.pink_strar_time || '',
                        pink_end_time: special.pink_end_time || '',
                        fake_pink_number: special.fake_pink_number || 0,
                        sort: special.sort || 0,
                        is_pink: special.is_pink || 0,
                        is_fake_pink: special.is_fake_pink || 1,
                        fake_sales: special.fake_sales || 0,
                        browse_count: special.browse_count || 0,
                        pink_time: special.pink_time || 0,
                        content: special.profile ? (special.profile.content || '') : '',
                        pay_type: special.pay_type == 1 ? 1 : 0,
                        check_source_sure:sourceCheckList ? sourceCheckList : "",
                        member_pay_type: special.member_pay_type == 1 ? 1 : 0,
                        member_money: special.member_money || '',
                        link:special.link || '',
                    },
                    but_title: '????????????',
                    link: '',
                    label: '',
                    host: ossUpload.host + '/',
                    mask: {
                        poster_image: false,
                        image: false,
                        service_code: false,
                    },
                    ue: null,
                    is_video: false,
                    //????????????
                    mime_types: {
                        Image: "jpg,gif,png,JPG,GIF,PNG",
                        Video: "mp4,MP4",
                    },
                    videoWidth: 0,
                    //is_live:is_live,
                    uploader: null,
                    searchTask:false
                },
                watch: {

                },
                methods: {
                    //??????
                    cancelUpload: function () {
                        this.uploader.stop();
                        this.is_video = false;
                        this.videoWidth = 0;
                    },
                    //????????????
                    delect: function (key, index) {
                        var that = this;
                        if (index != undefined) {
                            that.formData[key].splice(index, 1);
                            that.$set(that.formData, key, that.formData[key]);
                        } else {
                            that.$set(that.formData, key, '');
                        }
                    },
                    //????????????
                    look: function (pic) {
                        $eb.openImage(pic);
                    },
                    //??????????????????
                    enter: function (item) {
                        if (item) {
                            item.is_show = true;
                        } else {
                            this.mask = true;
                        }
                    },
                    //??????????????????
                    leave: function (item) {
                        if (item) {
                            item.is_show = false;
                        } else {
                            this.mask = false;
                        }
                    },
                    changeIMG: function (key, value, multiple) {
                        if (multiple) {
                            var that = this;
                            value.map(function (v) {
                                that.formData[key].push({pic: v, is_show: false});
                            });
                            this.$set(this.formData, key, this.formData[key]);
                        } else {
                            this.$set(this.formData, key, value);
                        }
                    },
                    uploadVideo: function () {
                        if (this.link.substr(0, 7).toLowerCase() == "http://" || this.link.substr(0, 8).toLowerCase() == "https://") {
                            this.setContent(this.link);
                        } else {
                            layList.msg('??????????????????????????????');
                        }
                    },
                    setContent: function (link) {
                        this.formData.link = link;
                        this.ue.setContent('<div><video style="width: 100%" src="' + link + '" class="video-ue" controls="controls"><source src="' + link + '"></source></video></div><br>', true);
                    },
                    //????????????
                    upload: function (key, count) {
                        ossUpload.createFrame('???????????????', {fodder: key, max_count: count === undefined ? 0 : count});
                    },
                    //????????????
                    get_subject_list: function () {
                        var that = this;
                        layList.baseGet(layList.U({a: 'get_subject_list'}), function (res) {
                            that.$set(that, 'subject_list', res.data);
                            that.$nextTick(function () {
                                layList.form.render('select');
                            })
                        });
                    },
                    delLabel: function (index) {
                        this.formData.label.splice(index, 1);
                        this.$set(this.formData, 'label', this.formData.label);
                    },
                    addLabrl: function () {
                        if (this.label) {
                            if (this.label.length > 6) return layList.msg('??????????????????????????????');
                            var length = this.formData.label.length;
                            if (length >= 2) return layList.msg('??????????????????2???');
                            for (var i = 0; i < length; i++) {
                                if (this.formData.label[i] == this.label) return layList.msg('??????????????????');
                            }
                            this.formData.label.push(this.label);
                            this.$set(this.formData, 'label', this.formData.label);
                            this.label = '';
                        }
                    },
                    save: function () {
                        var that = this, banner = new Array();
                        that.formData.content = that.ue.getContent();
                        if (!that.formData.subject_id) return layList.msg('???????????????');
                        if(Object.keys(that.formData.check_source_sure).length == 0) return layList.msg('???????????????');
                        if (!that.formData.title) return layList.msg('?????????????????????');
                        if (!that.formData.abstract) return layList.msg('?????????????????????');
                        if (!that.formData.phrase) return layList.msg('?????????????????????');
                        if (!that.formData.label.length) return layList.msg('???????????????');
                        if (!that.formData.image) return layList.msg('?????????????????????');
                        if (!that.formData.banner.length) return layList.msg('?????????banner???,??????1???');
                        if (!that.formData.poster_image) return layList.msg('?????????????????????');
                        if (!that.formData.service_code) return layList.msg('????????????????????????');
                        if (!that.formData.content) return layList.msg('??????????????????????????????');
                        if (that.formData.is_pink) {
                            if (!that.formData.pink_money) return layList.msg('?????????????????????');
                            if (!that.formData.pink_number) return layList.msg('?????????????????????');
                            if (!that.formData.pink_strar_time) return layList.msg('???????????????????????????');
                            if (!that.formData.pink_end_time) return layList.msg('???????????????????????????');
                            if (!that.formData.pink_time) return layList.msg('?????????????????????');
                            if (that.formData.is_fake_pink && !that.formData.fake_pink_number) return layList.msg('?????????????????????');
                        }
                        if (that.formData.pay_type == 1) {
                            if (!that.formData.money || that.formData.money == 0.00) return layList.msg('?????????????????????');
                        }
                        if (that.formData.member_pay_type == 1) {
                            if (!that.formData.member_money || that.formData.member_money == 0.00) return layList.msg('???????????????????????????');
                        }
                        layList.loadFFF();
                        layList.basePost(layList.U({
                            a: 'save_special',
                            q: {id: id, special_type: '{$special_type}'}
                        }), that.formData, function (res) {
                            layList.loadClear();
                            if (parseInt(id) == 0) {
                                layList.layer.confirm('????????????,????????????????????????????', {
                                    btn: ['????????????', '??????'] //??????
                                }, function () {
                                    window.location.reload();
                                }, function () {
                                    parent.layer.closeAll();
                                });
                            } else {
                                layList.msg('????????????', function () {

                                    window.location.href = layList.U({
                                        a: 'index',
                                        p: {type: 1, special_type: '{$special_type}'}
                                    });
                                })
                            }
                        }, function (res) {
                            layList.msg(res.msg);
                            layList.loadClear();
                        });
                    },
                    clone_form: function () {
                        if (parseInt(id) == 0) {
                            var that = this;
                            if (that.formData.image.pic) return layList.msg('??????????????????????????????????????????');
                            if (that.formData.poster_image.pic) return layList.msg('??????????????????????????????????????????');
                            if (that.formData.banner.length) return layList.msg('??????????????????????????????????????????');
                            if (that.formData.service_code.pic) return layList.msg('??????????????????????????????????????????');
                            parent.layer.closeAll();
                        }
                        window.location.href = layList.U({a: 'index', p: {type: 1,special_type:'{$special_type}'}});
                    },
                    //??????
                    search_task:function () {
                        var that=this;
                        that.searchTask=true;
                        var table = layui.table;
                        table.render({
                            elem: '#List'
                            ,url:"{:Url('source_list')}?special_id="+id+"&special_type={$special_type}"
                            ,toolbar: '#toolbarDemo' //???????????????????????????????????????????????????
                            ,defaultToolbar: ['filter', 'exports', 'print', { //?????????????????????????????????????????????????????????????????????????????????
                                title: '??????'
                                ,layEvent: 'LAYTABLE_TIPS'
                                ,icon: 'layui-icon-tips'
                            }]
                            ,cols: [[
                                {type: 'checkbox'},
                                {field: 'id', title: '??????', sort: true,event:'id'},
                                {field: 'title', title: '????????????'},
                                {field: 'image', title: '??????',templet:'<div><img src="{{ d.image }}"></div>'},
                            ]]
                            ,page: true
                        });
                    },
                    show_source_list:function () {
                        var that = this;
                        var table = layui.table,form = layui.form;
                        table.render({
                            elem: '#showSourceList'
                            ,cols: [[
                                {field: 'id', title: '??????', sort: true,event:'id'},
                                {field: 'title', title: '????????????',edit:'title'},
                                {field: 'image', title: '??????',templet:'<div><img src="{{ d.image }}"></div>'},
                                {field: 'pay_status', title: '????????????',width:'10%',templet:function(d){
                                        var is_checked = d.pay_status == 0 ? "checked" : "";
                                        return "<input type='checkbox' name='pay_status' lay-skin='switch' value='"+d.id+"' lay-filter='pay_status' lay-text='??????|??????' "+is_checked+">";
                                    }},
                            ]]
                            ,data:that.formData.check_source_sure
                            ,page: true
                        });
                        //??????????????????????????????
                        form.on('switch(pay_status)', function(obj){
                            if (that.formData.check_source_sure) {
                                $.each(that.formData.check_source_sure, function(index, value){
                                    if(value.id == obj.value){
                                        that.formData.check_source_sure[index].pay_status = obj.elem.checked == true ? 0 : 1;
                                    }
                                })
                            }
                        });
                    }
                },
                mounted: function () {
                    var that = this;
                    window.changeIMG = that.changeIMG;
                    layList.date({
                        elem: '#start_time',
                        theme: '#393D49',
                        type: 'datetime',
                        done: function (value) {
                            that.formData.pink_strar_time = value;
                        }
                    });

                    layList.date({
                        elem: '#end_time',
                        theme: '#393D49',
                        type: 'datetime',
                        done: function (value) {
                            that.formData.pink_end_time = value;
                        }
                    });
                    var table = layui.table;
                    table.on('toolbar(List)', function(obj){
                        console.log(obj);
                        var checkStatus = table.checkStatus(obj.config.id);
                        switch(obj.event){
                            case 'getCheckData':
                                var data = checkStatus.data;
                                // $("#check_source_tmp",window.parent.document).val(JSON.stringify(data));
                                var source_tmp =JSON.stringify(data);
                                that.source_tmp_list = JSON.parse(source_tmp);
                                that.formData.check_source_sure = JSON.parse(source_tmp);
                                that.show_source_list();
                                break;
                        };
                    });
                    //????????????
                    function changeIMG(index, pic) {
                        $(".image_img").css('background-image', "url(" + pic + ")");
                        $(".active").css('background-image', "url(" + pic + ")");
                        $('#image_input').val(pic);
                    }

                    //?????????????????????????????????
                    window.insertEditor = function (list) {
                        that.ue.execCommand('insertimage', list);
                    }

                    this.$nextTick(function () {
                        layList.form.render();
                        //??????????????????
                        UE.registerUI('imagenone', function (editor, name) {
                            var $btn = new UE.ui.Button({
                                name: 'image',
                                onclick: function () {
                                    ossUpload.createFrame('????????????', {fodder: 'editor'});
                                },
                                title: '????????????'
                            });

                            return $btn;

                        });
                        that.ue = UE.getEditor('myEditor');
                    });
                    //????????????
                    that.get_subject_list();
                    //??????????????????
                    that.show_source_list();
                    //???????????????????????????
                    layList.form.on('radio(is_pink)', function (data) {
                        that.formData.is_pink = parseInt(data.value);
                    });
                    layList.form.on('radio(is_remind)', function (data) {
                        that.formData.is_remind = parseInt(data.value);
                    });
                    layList.form.on('radio(is_recording)', function (data) {
                        that.formData.is_recording = parseInt(data.value);
                    });
                    layList.form.on('radio(pay_type)', function (data) {
                        that.formData.pay_type = parseInt(data.value);
                        if (that.formData.pay_type != 1) {
                            that.formData.is_pink = 0;
                            that.formData.member_pay_type = 0;
                            that.formData.member_money = 0;
                        };
                        that.$nextTick(function () {
                            layList.form.render('radio');
                        });
                    });
                    layList.form.on('radio(member_pay_type)', function (data) {
                        that.formData.member_pay_type = parseInt(data.value);
                        if (that.formData.member_pay_type != 1) {
                            that.formData.member_money = 0;
                        };
                        that.$nextTick(function () {
                            layList.form.render('radio');
                        });
                    });
                    layList.select('subject_id', function (obj) {
                        that.formData.subject_id = obj.value;
                    });

                    layList.form.on('radio(is_fake_pink)', function (data) {
                        that.formData.is_fake_pink = parseInt(data.value);
                    });

                    that.$nextTick(function () {
                        that.uploader = ossUpload.upload({
                            id: 'ossupload',
                            FilesAddedSuccess: function () {
                                that.is_video = true;
                            },
                            uploadIng: function (file) {
                                that.videoWidth = file.percent;
                            },
                            success: function (res) {
                                layList.msg('????????????');
                                that.videoWidth = 0;
                                that.is_video = false;
                                that.setContent(res.url);
                            },
                            fail: function (err) {
                                that.videoWidth = 0;
                                that.is_video = false;
                                layList.msg(err);
                            }
                        })
                    });
                }
            })
        })

</script>
{/block}