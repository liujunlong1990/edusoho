webpackJsonp([5],{"qtn/":function(e,s,t){"use strict";Object.defineProperty(s,"__esModule",{value:!0});t("eqfM");var r=t("/QYm"),n=t("woOf"),o=t.n(n),a=t("Dd8w"),i=t.n(a),c=t("NyOD"),d=t("1JqO"),l=t("FVyg"),u=t("NYxO"),m=(t("KFVb"),t("SgDA")),g={binding:"绑定手机",register:"注册账号"},h={binding:"绑定",register:"注册"},f={binding:"请输入密码",register:"请设置密码（5-20位字符）"},p={components:{EDrag:l.a},mixins:[c.a,d.a],data:function(){return{registerInfo:{mobile:"",dragCaptchaToken:void 0,encrypt_password:"",smsCode:"",smsToken:"",type:"register"},dragEnable:!1,dragKey:0,errorMessage:{mobile:"",encrypt_password:""},validated:{mobile:!1,encrypt_password:!1},count:{showCount:!1,num:120,codeBtnDisable:!1},pathName:this.$route.name,registerType:g,btnType:h,placeHolder:f}},computed:i()({},Object(u.mapState)({isLoading:function(e){return e.isLoading}}),{btnDisable:function(){return!(this.registerInfo.mobile&&this.registerInfo.encrypt_password&&this.registerInfo.smsCode)}}),methods:i()({},Object(u.mapActions)(["addUser","setMobile","sendSmsCenter","userLogin"]),{validateMobileOrPsw:function(e){var s=0<arguments.length&&void 0!==e?e:"mobile",t=this.registerInfo[s],n=m.a[s];if(0==t.length)return this.errorMessage[s]="",!1;this.errorMessage[s]=n.validator(t)?"":n.message},validatedChecker:function(){var e=this.registerInfo.mobile,s=m.a.mobile;this.validated.mobile=s.validator(e)},handleSmsSuccess:function(e){this.registerInfo.dragCaptchaToken=e,this.handleSendSms()},handleSubmit:function(){var s=this,e=o()({},this.registerInfo),t=e.encrypt_password,n=e.mobile,a=window.XXTEA.encryptToBase64(t,window.location.host);e.encrypt_password=a,"binding"!==this.pathName?this.addUser(e).then(function(e){r.a.success({duration:2e3,message:"注册成功"}),s.afterLogin()}).then(function(){s.userLogin({password:t,username:n})}).catch(function(e){r.a.fail(e.message)}):this.setMobile({query:{mobile:n},data:{password:t,smsCode:e.smsCode,smsToken:e.smsToken}}).then(function(e){r.a.success({duration:2e3,message:"绑定成功"}),s.afterLogin()}).catch(function(e){r.a.fail(e.message)})},clickSmsBtn:function(){this.dragEnable?this.$refs.dragComponent.dragToEnd?this.$refs.dragComponent.initDragCaptcha():Object(r.a)("请先完成拼图验证"):this.handleSendSms()},handleSendSms:function(){var s=this;this.sendSmsCenter(this.registerInfo).then(function(e){s.registerInfo.smsToken=e.smsToken,s.countDown(),s.dragEnable=!1}).catch(function(e){switch(e.code){case 4030301:case 4030302:s.dragKey++,s.registerInfo.dragCaptchaToken="",s.registerInfo.smsToken="",r.a.fail(e.message);break;case 4030303:s.dragEnable?r.a.fail(e.message):s.dragEnable=!0;break;default:r.a.fail(e.message)}})},countDown:function(){var e=this;this.count.showCount=!0,this.count.codeBtnDisable=!0,this.count.num=120;var s=setInterval(function(){if(e.count.num<=0)return e.count.codeBtnDisable=!1,e.count.showCount=!1,void clearInterval(s);e.count.num--},1e3)}})},b={render:function(){var s=this,e=s.$createElement,t=s._self._c||e;return t("div",{staticClass:"register"},[s.isLoading?t("e-loading"):s._e(),s._v(" "),t("span",{staticClass:"register-title"},[s._v(s._s(s.registerType[s.pathName]))]),s._v(" "),t("van-field",{attrs:{placeholder:"请输入手机号",maxLength:"11",border:!1,"error-message":s.errorMessage.mobile},on:{blur:function(e){s.validateMobileOrPsw("mobile")},keyup:function(e){s.validatedChecker()}},model:{value:s.registerInfo.mobile,callback:function(e){s.$set(s.registerInfo,"mobile",e)},expression:"registerInfo.mobile"}}),s._v(" "),t("van-field",{attrs:{type:"password",maxLength:"20",border:!1,"error-message":s.errorMessage.encrypt_password,placeholder:s.placeHolder[s.pathName]},on:{blur:function(e){s.validateMobileOrPsw("encrypt_password")}},model:{value:s.registerInfo.encrypt_password,callback:function(e){s.$set(s.registerInfo,"encrypt_password",e)},expression:"registerInfo.encrypt_password"}}),s._v(" "),s.dragEnable?t("e-drag",{key:s.dragKey,ref:"dragComponent",on:{success:s.handleSmsSuccess}}):s._e(),s._v(" "),t("van-field",{attrs:{type:"text",border:!1,center:"",clearable:"",maxLength:"6",placeholder:"请输入验证码"},model:{value:s.registerInfo.smsCode,callback:function(e){s.$set(s.registerInfo,"smsCode",e)},expression:"registerInfo.smsCode"}},[t("van-button",{attrs:{slot:"button",size:"small",type:"primary",disabled:s.count.codeBtnDisable||!s.validated.mobile},on:{click:s.clickSmsBtn},slot:"button"},[s._v("\n        发送验证码\n        "),t("span",{directives:[{name:"show",rawName:"v-show",value:s.count.showCount,expression:"count.showCount"}]},[s._v("("+s._s(s.count.num)+")")])])],1),s._v(" "),t("van-button",{staticClass:"primary-btn mb20",attrs:{type:"default",disabled:s.btnDisable},on:{click:s.handleSubmit}},[s._v(s._s(s.btnType[s.pathName]))])],1)},staticRenderFns:[]},v=t("VU/8")(p,b,!1,null,null,null);s.default=v.exports}});