//UI CONTROLLER
var viewController = (function()
{
    
    var strings = 
    {
        submitSpan: ".btn-loader span",
        submitImg: ".btn-loader img",
        submitIcon: ".btn-loader i",
        allElements: "textarea,button,input,select",
        checkError: ".check-error",
        checkError_P: ".check-error p",
        checkError_I: ".check-error i",
        alertDanger: "alert alert-danger",
        alertDanger_style: "5px solid #b54442",
        alertInfo: "alert alert-info",
        alertInfo_style: "5px solid #3170a1",
        alertSuccess: "alert alert-success",
        alertSuccess_style: "5px solid #3c763d",
        alertWarning: "alert alert-warning",
        alertWarning_style: "5px solid #8a6d3b",
        hidden: "hidden",
        selected: "selected",
        disabled: "disabled",
        notifyIn: "animated bounceIn",
        notifyOut: "animated bounceOut",
        notifyIcon: "fa fa-info-circle",
        notifyFrom: "top",
        notifyAlign: "right",
        animateEffect: "fadeIn",
        animateEffectIn: "flipInY",
        animateEffectOut: "flipOutY",
        animated: "animated",
        swalTitle: "<p class='pop-error-title'>",
        swalHtml: "<p class='pop-error'>",
        swalClose: "</p>",
        introSkip_Done: ".introjs-skipbutton",
        fakeLoader: '',
        fakeLoaderBG: '#2ecc71',
        fakeLoaderSpinner: 'spinner1',
        winWidth: 767
    };
    
    var messageTemp = {
        success: function(parent, message)
        {
            $(parent).find(strings.checkError).removeClass(strings.hidden);
            $(parent).find(strings.checkError).removeClass(strings.alertDanger);
            $(parent).find(strings.checkError).removeClass(strings.alertInfo);
            $(parent).find(strings.checkError).removeClass(strings.alertWarning);
            $(parent).find(strings.checkError_I).removeClass(strings.hidden);
            $(strings.checkError_P).css({'color': '#3c763d'});
            $(parent).find(strings.checkError_P).html(message).parent().addClass(strings.alertSuccess).css({'border-left': strings.alertSuccess_style}).fadeIn();
        },
        danger: function(parent, message)
        {
            $(parent).find(strings.checkError).removeClass(strings.hidden);
            $(parent).find(strings.checkError).removeClass(strings.alertSuccess);
            $(parent).find(strings.checkError).removeClass(strings.alertInfo);
            $(parent).find(strings.checkError).removeClass(strings.alertWarning);
            $(parent).find(strings.checkError_I).removeClass(strings.hidden);
            $(strings.checkError_P).css({'color': '#b54442'});
            $(parent).find(strings.checkError_P).html(message).parent().addClass(strings.alertDanger).css({'border-left': strings.alertDanger_style}).fadeIn();
        },
        info: function(parent, message)
        {
            $(parent).find(strings.checkError).removeClass(strings.hidden);
            $(parent).find(strings.checkError).removeClass(strings.alertSuccess);
            $(parent).find(strings.checkError).removeClass(strings.alertDanger);
            $(parent).find(strings.checkError).removeClass(strings.alertWarning);
            $(parent).find(strings.checkError_I).removeClass(strings.hidden);
            $(strings.checkError_P).css({'color': '#3170a1'});
            $(parent).find(strings.checkError_P).html(message).parent().addClass(strings.alertInfo).css({'border-left': strings.alertInfo_style}).fadeIn();
        },
        warning: function(parent, message)
        {
            $(parent).find(strings.checkError).removeClass(strings.hidden);
            $(parent).find(strings.checkError).removeClass(strings.alertSuccess);
            $(parent).find(strings.checkError).removeClass(strings.alertDanger);
            $(parent).find(strings.checkError).removeClass(strings.alertInfo);
            $(parent).find(strings.checkError_I).removeClass(strings.hidden);
            $(strings.checkError_P).css({'color': '#8a6d3b'});
            $(parent).find(strings.checkError_P).html(message).parent().addClass(strings.alertWarning).css({'border-left': strings.alertWarning_style}).fadeIn();
        }
    };
    
    return {
        getStrings: function()
        {
            return strings;
        },
        getMessageTemp: function()
        {
            return messageTemp;
        }
    };
})();


//SLICK SLIDERS
var slickSlider = (function(){ 
    // Check selected dom
    var check = function(selector)
    {
        return $("html, body").find(selector).length;
    };
    
    return {
        slick: function(selector, sts_lg, sts_md, sts_sm, sts_xs)
        {
            //SLICK CAROUSEL
            if(check(selector) !== 0)
            {
                $(selector).slick({
                    slidesToShow: typeof sts_lg[0] === 'string' ? 4 : sts_lg[0],
                    slidesToScroll: 1,
                    rows: 1,
                    autoplay: typeof sts_lg[1] === 'string' ? false : sts_lg[1],
                    infinite: typeof sts_lg[2] === 'string' ? true : sts_lg[2],
                    autoplaySpeed: typeof sts_lg[3] === 'string' ? 1500 : sts_lg[3],
                    draggable:true,
                    dots:false,
                    pauseOnHover:true,
                    arrows:true,
                    centerMode: typeof sts_lg[4] === 'string' ? true : sts_lg[4],
                    slidesPerRow:1,
                    centerPadding: '0px',
                    //prevArrow: $(sts_lg[5]),
                    //nextArrow: $(sts_lg[6]),
                    speed: typeof sts_lg[7] === 'string' ? 300 : sts_lg[7],
                    responsive: [
                        {
                          breakpoint: 991,
                          settings: {
                            slidesToShow: typeof sts_md[0] === 'string' ? 3 : sts_md[0],
                            centerMode: typeof sts_md[1] === 'string' ? true : sts_md[1]
                          }
                        },
                        {
                          breakpoint: 767,
                          settings: {
                            slidesToShow: typeof sts_sm[0] === 'string' ? 3 : sts_sm[0],
                            centerMode: typeof sts_sm[1] === 'string' ? false : sts_sm[1]
                          }
                        },
                        {
                          breakpoint: 550,
                          settings: {
                            slidesToShow: typeof sts_xs[0] === 'string' ? 2 : sts_xs[0],
                            centerMode: typeof sts_xs[1] === 'string' ? false : sts_xs[1]
                          }
                        }    
                    ]
                });  
            }
        }
    };
})();


//APP CONTROLLER
var baseController = (function(view, SLICK)
{
    // HTML DOM ELEMENTS
    var DOM = view.getStrings();
    var MSG = view.getMessageTemp();
    
    // Check selected dom
    var check = function(selector)
    {
        return $("html, body").find(selector).length;
    };
    
    // CONSOLE WARNING
    var openConsole = function()
    {
        console.log("%cYou should'nt %cbe here!", "color: #10609f; font-size: 20px;", "color: #438106; font-size: 20px;");
    };
    
    // OPEN LOADER FOR JSON
    var openLoader = function(parent,disable,text)
    {
        if (disable) {
            $(parent).find(DOM.submitSpan).html(text);
            $(parent).find(DOM.submitImg).removeClass(DOM.hidden);
        }
        else{
            $(parent).find(DOM.submitSpan).html(text);
            $(parent).find(DOM.submitImg).addClass(DOM.hidden);
        }
        $(parent).find(DOM.allElements).prop(DOM.disabled, disable);
    }
    
    // window position
    var winPosition = function()
    {
        return $(window).scrollTop();
    };
    
    // return element position
    var elemPostion = function(selector)
    {
        if(check(selector) !== 0){
            return $(selector).offset().top;
        }
    };
    
    // window on scroll
    var winOnScroll = function(selector, callback)
    {
        // getting the element position length
        if(check(selector) !== 0){
            selector = elemPostion(selector);
            $(window).on("scroll",function(){
                // Getting the window length only when onscroll event
                var win = winPosition();
                if (win >= selector) {
                    callback(true);
                }
                else{
                    callback(false);
                }
            })
        }
    };
    
    // window scroll detect
    var scrollDetecting = function(callback)
    {
        var position, scroll;
        position = winPosition();
        
        $(window).scroll(function(){
            scroll = winPosition();
            if(scroll > position) {
                callback(true, 'scrolling down');
            } else {
                callback(false, 'scrolling up');
            }
            position = scroll;
        });
    };
    
    //Scroll to window top
    var hideURLbar = function(scroll) 
    {
        if(scroll){
            window.scrollTo(0, 1);
        }
    };
    
    
    return {
        init: function() 
        {
            openConsole();
        },
        intro: function(start, cookieName, expires, timeout)
        {
            var cookieCheck = baseController.getCookie(cookieName);
            // If intro is true
            if (start) {
                // If cookie has not been set
                if (cookieCheck === "") {
                    // Start intro plugin
                    setTimeout(function(){
                       introJs().start();

                       // Set the cookie
                       baseController.introDone(cookieName, expires);
                    }, timeout === "" ? 3000 : timeout);
                }
            }
        },
        introDone: function(cookieName, expires)
        {
            var dataSkip_Done, date, cookieValue;
            
            dataSkip_Done = DOM.introSkip_Done;
            // js time syntax: Mar 25 2015 || ISO FORMATS - 2015-03-25
            date = new Date(expires);
            cookieValue = "checked";
            expires = "expires="+ date.toUTCString();
            $(dataSkip_Done).one("click",function(){
                document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
            });
        },
        setCookie: function(cookieName, cookieValue, expires)
        {
            // setCookie(cookieName, cookieValue, expires);
            var date;
            // js time syntax: Mar 25 2015 || ISO FORMATS - 2015-03-25
            date = new Date(expires);
            expires = "expires="+ date.toUTCString();
            document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
        },
        getCookie: function(cname)
        {
            // getCookie(cookiename)
            var name = cname + "=";
            var ca = document.cookie.split(';');

            for(var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                  c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                  return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        datePicker: function(selector) 
        {
            // datePicker($("selector"))
            if(check(selector) !== 0){
                selector.datepicker({
                    autoHide: true
                });
            }
        },
        timePicker: function(selector) 
        {
            // timePicker($("selector"))
            if(check(selector) !== 0){
                selector.timepicker({ 
                    'scrollDefault': 'now'
                });
            } 
        },
        goBack: function(selector)
        {
            // goBack($("selector"));
            if(check(selector) !== 0){
                selector.click(function(){
                    window.history.back();
                });
            }
        },
        scrollTopOnLoad: function(scroll)
        {
            addEventListener("load", function() {
                setTimeout(hideURLbar(scroll), 0);
            }, false);
        },
        scrollToObject: function(selector, scroll=10, callback)
        {
            // scrollToObject($("selector"), 90, function(){})
            selector = $(selector);
            if(check(selector) !== 0){
                $("html, body").animate({"scrollTop":selector.offset().top-scroll},500, callback);  
            }
        },
        scrollToElemExecute: function(selector, callback)
        {
            // scrollToElemExecute($("selector"), function(){});
            if(check(selector) !== 0){
                winOnScroll(selector, callback);
            }
        },
        scrollDetect: function(callback)
        {
            // scrollDetect(function(bool, m){});
            scrollDetecting(callback);
        },
        generalFormSubmit: function(form, btnText, normal, before, after, message, debugError, scroll) 
        {
            // (form,[],true,function(){},function(m,t){},function(m,t){},function(e){},true)
            before();
            var param = new FormData(form); 
            openLoader(form,true,btnText[0]); 
            var ajax = new XMLHttpRequest();
            ajax.onreadystatechange = function(){
                if (ajax.readyState === 4 && ajax.status === 200) {
                    openLoader(form,false,btnText[1]);
                    debugError(ajax.responseText);
                    if (normal) {
                        var data = JSON.parse(ajax.responseText);
                        if (data.response === RESPONSE_SUCCESS) {
                            after(data.message,"success");
                            if (scroll) {
                                baseController.scrollToObject($(form));
                            }
                        }
                        else if (data.response === RESPONSE_DANGER) {
                            message(data.message,"danger");
                            if (scroll) {
                                baseController.scrollToObject($(form));
                            }
                        }
                        else if (data.response === RESPONSE_ERROR) {
                            message(data.message,"error");
                            if (scroll) {
                                baseController.scrollToObject($(form));
                            }
                        }
                        else if (data.response === RESPONSE_INFO) {
                            message(data.message,"info");
                            if (scroll) {
                                baseController.scrollToObject($(form));
                            }
                        }
                        else{
                            message(data.message,"warning");
                            if (scroll) {
                                baseController.scrollToObject($(form));
                            }
                        }
                    }
                }
            };
            ajax.open("POST",XHR,true);
            ajax.send(param);

           return false;
        },
        generalPromiseSubmit: function(html, btnConfirm, btnCancel, param, before, after, message, debugError)
        {
                // function(html, 'confirm', 'cancel', param, function(){}, function(m, t){}, function(m, t){}, function(e){});
                swal({title:"",
                html: html,
                type: "question",
                allowOutsideClick:false,
                allowEscapeKey:false,
                showCancelButton:true,
                showLoaderOnConfirm: true,
                confirmButtonText: btnConfirm,
                cancelButtonText: btnCancel,
                reverseButtons:true,
                preConfirm: function () 
                {
                    return new Promise(function (resolve, reject) {
                            before();
                            $.post(XHR, param,function(result){
                                resolve(result);
                            });
                    })
                }
            })
            .then(function(data){
                debugError(data);
                data = JSON.parse(data);
                if (data.response === RESPONSE_SUCCESS) {
                    after(data.message, "success");
                }
                else if (data.response === RESPONSE_DANGER) {
                    message(data.message, "danger");
                }
                else if (data.response === RESPONSE_ERROR) {
                    message(data.message, "error");
                }
                else if (data.response === RESPONSE_INFO) {
                    message(data.message, "info");
                }
                else{
                    message(data.message, "warning");
                }
            })
            .catch(swal.noop); 
        },
        generalDirectSubmit: function(param, before, after, message, debugError)
        {
            //(param, function(m, t){}, function(m, t){}, function(m, t){}, function(e){});
            before();
            $.post(XHR, param,function(result){
                debugError(result);
                var data = JSON.parse(result);
                if (data.response === RESPONSE_SUCCESS) {
                    after(data.message, "success");
                }
                else if (data.response === RESPONSE_DANGER) {
                    message(data.message, "danger");
                }
                else if (data.response === RESPONSE_ERROR) {
                    message(data.message, "error");
                }
                else if (data.response === RESPONSE_INFO) {
                    message(data.message, "info");
                }
                else{
                    message(data.message, "warning");
                }
            });
        },
        showResponseMSG: function(parent, message, type, callback)
        {
            // showResponseMSG(parent, message, type);
            if (type === "success") {
                MSG.success(parent, message);
            } 
            else if(type === "danger"){
                MSG.danger(parent, message);
            }
            else if(type === "info"){
                MSG.info(parent, message);
            }
            else{
                MSG.warning(parent, message);
            }
            
            callback();
        },
        showResponseMSG_POP: function(title, html, type, btnText, callback)
        {
            // showResponseMSG_POP(title, html, type, btnText, function(){});
            swal({title:DOM.swalTitle + title + DOM.swalClose,
                html: DOM.swalHtml + html + DOM.swalClose,
                type: type,
                allowOutsideClick:false,
                allowEscapeKey:false,
                confirmButtonText: btnText == '' ? 'Okay' : btnText,
            }).then(function(resolve){
                callback(resolve);
            });
        },
        fetchOnKeyUp: function(select, before, after, message, debugError)
        {
            // fetchOnKeyUp(select, function(){}, function(m, t){}, function(m, t){}, function(e){});
            $(select).keyup(function(){
                var param = before(this.value);
                $.post(XHR, param, function(result){
                    debugError(result);
                    var data = JSON.parse(result);
                    if (data.response === RESPONSE_SUCCESS) {
                        after(data.message, "success");
                    }
                    else if (data.response === RESPONSE_DANGER) {
                        message(data.message, "danger");
                    }
                    else if (data.response === RESPONSE_ERROR) {
                        message(data.message, "error");
                    }
                    else if (data.response === RESPONSE_INFO) {
                        message(data.message, "info");
                    }
                    else{
                        message(data.message, "warning");
                    }
                });
            });
        },
        customNotify: function(allowDismiss,type,delay,icon,title,msg,enterAM,exitAM,from,align, callback)
        {
            // customNotify(true,"info",5000,"fa fa-paw","Title","Hello All","","","bottom","left", function(){})
            $.notifyDefaults({
                type: type,
                offset: 15,
                z_index: 1031,
                delay: delay === "" ? 3000 : delay,
                allow_dismiss: allowDismiss,
                newest_on_top: true,
                showProgressbar: false,
                onShow: function(){
                    //
                }
            });
            $.notify({
                icon: icon === "" ? DOM.nofityIcon : icon,
                title: title,
                message: msg
            }, {
                animate: {
                    enter: enterAM === "" ? DOM.nofityIn : DOM.animated + ' ' + enterAM,
                    exit: exitAM === "" ? DOM.nofityOut : DOM.animated + ' ' + exitAM
                },
                placement: {
                    from: from === "" ? DOM.nofityFrom : from,
                    align: align === "" ? DOM.nofityAlign :align
                }
            });
            callback();
        },
        animateElem: function(before, selector, element, effect)
        {
            // animateElem(function(){},$("selector"),$("element"),"effect")
            if(check(selector) !== 0){
                effect === "" ? DOM.animateEffect : effect; //bounceIn
                var animationend = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oAnimationEnd animationend";
                selector.on("click",function(){
                        before();
                        element.addClass(DOM.animated);
                        element.addClass(effect).one(animationend, function(){
                            element.removeClass(effect);
                    });
                });
            }
        },
        animateDropdown: function(selector,element,effectIn, effectOut)
        {
            // animateDropdown($('selector'), $('element'), 'flipInY', 'flipOutY');
            if(check(selector) !== 0){
                effectIn === "" ? DOM.animateEffectIn : effectIn; //flipInX
                effectOut === "" ? DOM.animateEffectOut : effectOut; //flipOutX
                
                var animationend = "webkitAnimationEnd mozAnimationEnd MSAnimationEnd oAnimationEnd animationend";
                element.addClass(DOM.animated);
                
                //https://www.w3schools.com/bootstrap/bootstrap_ref_js_dropdown.asp
                //https://stackoverflow.com/questions/12115833/adding-a-slide-effect-to-bootstrap-dropdown
                selector.on('show.bs.dropdown', function() {
                    $(this).find(element).first().stop(true, true).addClass(effectIn).one(animationend, function(){
                        element.removeClass(effectIn);
                    });
                }).on('hide.bs.dropdown', function() {
                    $(this).find(element).first().stop(true, false).addClass(effectOut).one(animationend, function(){
                        element.removeClass(effectOut);
                        $(this).parent().removeClass('open');
                    });
                }).on('hidden.bs.dropdown', function() {
                    $(this).addClass('open');
                });
            }
        },
        toggleSelector: function(selector,size,onText,offText,onColor,offColor)
        {
            // toggleSelector($(selector), "onText", "offText", "small", "onColor","offColor")
            if(check(selector) !== 0){
                selector.bootstrapToggle({
                    on: onText,
                    off: offText,
                    size: size,
                    onstyle: onColor,
                    offstyle: offColor
                }); 
            }
        },
        toggleDataForm: function(selector,inputName,page,after,debugError)
        {
            // toggleDataForm($("#selector"),"inputName",page,function(a){},function(e){})
            if(check(selector) !== 0){
                selector.change(function(){
                    var param;
                    param = inputName+"=1&page="+page;
                    if ($(this).prop('checked')) {
                        $(selector).val("0");
                        $.post(XHR,param,function(result){
                            debugError(result);
                            var json=JSON.parse(result);
                            if (json.response === RESPONSE_SUCCESS) {
                                // return Success message
                                after(json.message,"success");
                            }
                        });
                    }
                    else{
                        param = inputName+"=0&page="+page;
                        $(selector).val("1"); 
                        $.post(XHR,param,function(result){
                            debugError(result);
                            var json=JSON.parse(result);
                            if (json.response === RESPONSE_DANGER) {
                                // return disabled message
                                after(json.message,"danger");
                            }
                        });
                    }
                });
            }
            
        },
        toggleHamburger: function(selector,sidebar)
        {
            //toggleHamburger($("#sidebarCollapse"),$("#sidebar"))
            if(check(selector) !== 0){
                selector.on('click', function () {
                    sidebar.toggleClass('active');
                    $('.collapse.in').toggleClass('in');
                    $('a[aria-expanded=true]').attr('aria-expanded', 'false');
                });
            }
        },
        slickSlider: function(selector, sts_lg, sts_md, sts_sm, sts_xs)
        {
            // slickSlider(selector, sts_lg, sts_md, sts_sm, sts_xs);
            if(check(selector) !== 0){
                SLICK.slick(selector, sts_lg, sts_md, sts_sm, sts_xs);
            }
        },
        tableFilter: function(selector, table)
        {
            // tableFilter($(selector), "");
            // $('table tr');
            if(check(selector) !== 0){
                selector.on("keyup", function() {
                    var value = $(this).val().toLowerCase();
                    $(table).filter(function() {
                      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                });
            }
        },
        fakeLoader: function(start, selector, bgColor, spinner, time)
        {
            // fakeLoader ($(selector), '', '');
            // Spinners -- spinner1 | spinner2 | spinner3 | spinner4 | spinner5 | spinner6 | spinner7
            if(check(selector) !== 0){
                if(!start){
                    selector.css({'display': 'none'});
                }else{
                    selector.css({'display': 'block', 'z-index':'9999999999'});
                    $.fakeLoader({
                        bgColor: bgColor == '' ? DOM.fakeLoaderBG : bgColor,
                        spinner: bgColor == '' ? DOM.fakeLoaderSpinner : spinner,
                        timeToHide: typeof time == 'string' ? 1200 : time
                    });
                }
            }
        },
        imgAutoUpload: function(imgid,btnid,debug)
        {
            // imgAutoUpload(imgid,btnid,function(fn,ft,fs,len){}) 
            if(check(imgid) !== 0){
                var fileToRead = document.getElementById(imgid);
                var getSubmitBTN = document.getElementById(btnid);

                fileToRead.addEventListener("change", function(event) {
                    var files = fileToRead.files;
                    var len = files.length;

                    if (len) {
                        var filename = files[0].name;
                        var filetype = files[0].type;
                        var filesize = files[0].size;

                        debug(filename,filetype,filesize,len);  
                        getSubmitBTN.click();  
                    }
                }, false);
            }
            
        },
        imagePreview: function(selector, container)
        {
            
        },
        checkCheckBox: function(selector, callback)
        {
            //checkCheckBox("#selector", function(e){});
            if(check(selector) !== 0){
                $(selector).change(function() {
                    if($(this).is(":checked")) {
                        callback($(this)[0].checked, $(this));
                    } else {
                        callback($(this)[0].checked, $(this));
                    }
                });
            }
        },
        isMobile: function()
        {
            var win = window.innerWidth;
            return win <= DOM.winWidth ? true : false;
        },
        windows: function()
        {
            return {
                width: window.innerWidth,
                height: window.innerHeight
            };
        },
        internet: function()
        {
            if(navigator.onLine){
                return true;
            }else{
                return false;
            }
        },
        findDom: function(selector)
        {
            return check(selector);
        },
        checkDom: function(selector, callback)
        {
            //checkDom("selector", function(){});
            if(baseController.findDom($(selector)) != 0){
                callback();
            }
        },
        copyToClipboard: function(elemID, callback)
        {
            // copyToClipboard(elemID, function(e){});
            /* Get the text field */
            var copyText = document.getElementById(elemID);
            
            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /*For mobile devices*/

            /* Copy the text inside the text field */
            document.execCommand("copy");
            
            //show copy text
            callback(copyText.value);
        },
        passwordGenerator: function (max_char = 12, max_symbol = 4)
        {
            var password = {
                // Add another object to the rules array here to add rules.
                // They are executed from top to bottom, with callbacks in between if defined.
                rules: [

                    //Take a combination of 12 letters and numbers, both lower and upper case.
                    {
                        characters: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890',
                        max: max_char
                    },

                    //Take 4 special characters, use the callback to shuffle the resulting 16 character string
                    {
                        characters: '!@#$%^&*()_+|~-={}[]:";<>?,./',
                        max: max_symbol,
                        callback: function (s) {
                            var a = s.split(""),
                                n = a.length;

                            for (var i = n - 1; i > 0; i--) {
                                var j = Math.floor(Math.random() * (i + 1));
                                var tmp = a[i];
                                a[i] = a[j];
                                a[j] = tmp;
                            }
                            return a.join("");
                        }
                    }
                ],
                generate: function () 
                {
                    var g = '';

                    $.each(password.rules, function (k, v) {
                        var m = v.max;
                        for (var i = 1; i <= m; i++) {
                            g = g + v.characters[Math.floor(Math.random() * (v.characters.length))];
                        }
                        if (v.callback) {
                            g = v.callback(g);
                        }
                    });
                    return g;
                }
            }
            return password.generate();
        },
        //start print
        startPrint: function(btn, elem, header = null, footer = null)
        {
            $(btn).on('click', function(){
                return $(elem).printThis({
                    importCSS: true,
                    loadCSS: "",
                    header: "",
                    header: header,   // prefix to html
                    footer: footer
                });
            });
        }
    };
})(viewController, slickSlider);



/*
|-------------------------------------------------------
| get url parameters
|-------------------------------------------------------
*/

function GetURLParam(param)
{
    //GetURLParam(param);
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == param) 
        {
            return sParameterName[1];
        }
    }
}


/*
|-------------------------------------------------------
| Creating pagination handlers
|-------------------------------------------------------
*/

// Pagination result function
function getPaginationResult(getURL, loader)
{
    // getPaginationResult("url",false);
    $.ajax({
        url: getURL,
        type: 'GET',
        data: {
            rowcount: $("#rowcount").val(),
            query: GetURLParam('query'),
            pagination_setting: $("#pagination-setting").val(),
            param: $("#param").val()
        },
        beforeSend: function(){
            if(loader){
                $("#overlay").show();
            }
        },
        success: function(data){
            //Creating a new function
            printResult(data);
            if(loader){
                setInterval(function(){
                    $("#overlay").hide();
                }, 1500);
            }
        }
    });
}

// Change of pagination result
function changePagination(selector,getURL,loader)
{
    // changePagination($(selector),'url',false);
    if(baseController.domCheck !== 0){
        selector.change(function(){
            var getSelect = selector.val();
            if(getSelect !== ''){
                getPaginationResult(getURL, loader);
            }
        });
    }
}

//share to whatsapp
function shareOnWhatsAppMessage(element, whatsappMessage, phone)
{
   whatsappMessage=window.encodeURIComponent(whatsappMessage);
     if (phone===null) {
           $(element).attr("href","https://api.whatsapp.com/send?text="+whatsappMessage);                                                     
       }
       else{
          $(element).attr("href","https://api.whatsapp.com/send?phone="+phone+"&text="+whatsappMessage); 
       }
}

//share to facebook
function shareOnFacebook(element, url)
{
    url=window.encodeURIComponent(url);
    $(element).attr("href","https://www.facebook.com/sharer?u="+url);                                                      
}

//share to twitter
function shareOnTwitter(element, text)
{
    text=window.encodeURIComponent(text);
    $(element).attr("href","https://twitter.com/intent/tweet?text="+text);                                                      
}

//share to sms
function shareOnSMS(element, text)
{
    text=window.encodeURIComponent(text);
    $(element).attr("href","sms://?body="+text);                                                      
}

//password generator
var password = {
    // Add another object to the rules array here to add rules.
    // They are executed from top to bottom, with callbacks in between if defined.
    rules: [

        //Take a combination of 12 letters and numbers, both lower and upper case.
        {
            characters: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890',
            max: 12
        },

        //Take 4 special characters, use the callback to shuffle the resulting 16 character string
        {
            characters: '!@#$%^&*()_+|~-={}[]:";<>?,./',
            max: 4,
            callback: function (s) {
                var a = s.split(""),
                    n = a.length;

                for (var i = n - 1; i > 0; i--) {
                    var j = Math.floor(Math.random() * (i + 1));
                    var tmp = a[i];
                    a[i] = a[j];
                    a[j] = tmp;
                }
                return a.join("");
            }
        }
    ],
    generate: function () 
    {
        var g = '';

        $.each(password.rules, function (k, v) {
            var m = v.max;
            for (var i = 1; i <= m; i++) {
                g = g + v.characters[Math.floor(Math.random() * (v.characters.length))];
            }
            if (v.callback) {
                g = v.callback(g);
            }
        });
        return g;
    }
}
