function copy(textDiv, btn) {
    let text = $(textDiv).text();
    var clipboard = new Clipboard(btn, {
        text: function() {
            return text;
        }
    });
    clipboard.on('success', function(e) {
        msg('复制成功 | Successfully');
    });
    clipboard.on('error', function(e) {
        msg(e);
    });
}

function msg(str, time) {
    if (!time) {
        time = 3000;
    }
    $('#tipDiv').html(str).show().css({
        'opacity': 1,
        'top': '30%'
    });
    setTimeout(function() {
        $('#tipDiv').css({
            'opacity': 0,
            'top': '35%'
        });
        setTimeout(function() {
            $('#tipDiv').css({
                'top': '25%'
            }).hide();
        }, 1000);
    }, time);
}

function showCircuit(num) {
    console.log(num)
    $('.circuitDiv .process li').parent().attr('style', 'background-position-y:' + -133 * (num - 1) + 'px');
    $('.circuitDiv .process li').removeClass('cur');
    $('.circuitDiv .process li[data-num=' + num + ']').addClass('cur');
    $('http://www.mghx77.com/joychash/js/.circuitDiv .blocks .item').hide();
    $('.circuitDiv .stepBlock .leftNoeDATE').hide();
    $('.circuitDiv .blocks .item[data-num=' + num + ']').show();
    $('.circuitDiv .stepBlock .leftNoeDATE[data-num=' + num + ']').show();
}

function showRule(num) {
    $('.ruleDiv .tabItem').removeClass('active');
    $('.ruleDiv .tabItem[data-num=' + num + ']').addClass('active');
    $('.ruleDiv .blocks .items').hide();
    $('.ruleDiv .blocks .items[data-num=' + num + ']').show();
}

function showWhy(num) {
    $('.whyDiv .buts li').removeClass('cur');
    $('.whyDiv .buts li[data-num=' + num + ']').addClass('cur');
    $('http://www.mghx77.com/joychash/js/.whyDiv .blocks .item').removeClass('cur');
    $('.whyDiv .blocks .item[data-num=' + num + ']').addClass('cur');
    var ageWidth = parseInt($('http://www.mghx77.com/joychash/js/.whyDiv .blocks .item').width() + 2);
    $('.whyDiv .blocks').css('margin-left', (ageWidth * (num - 1) * -1) + 'px');
}

function showWin(divName) {
    $('http://www.mghx77.com/joychash/js/.winDiv .item').hide();
    $('.winDiv .' + divName).show();
    $('.winDiv').fadeIn(200);
    $('.winMask').fadeIn(200);
}
$(window).scroll(function() {
    var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
    if (scrollTop > 18) {
        $('.headNav').addClass('in');
    } else {
        $('.headNav').removeClass('in');
    }
    var menu = $(".headNav ul");
    var items = $(".container").find(".block");
    var curId = "";
    if (window.innerWidth <= 1023) {
        menu = $("http://www.mghx77.com/joychash/js/.headNav ul.nav2");
    }
    items.each(function() {
        var m = $(this);
        var itemsTop = m.offset().top;
        if (scrollTop > itemsTop - 300) {
            curId = "#" + m.prev().attr("id");
        } else {
            return false;
        }
    });
    var curLink = menu.find(".active");
    if (curId && curLink.attr("data-href") != curId) {
        curLink.removeClass("active");
        menu.find("[data-href='" + curId + "']").addClass("active");
    }
})
$('.headNav a').click(function() {
    var href = $(this).data('href');
    $('.headNav a').removeClass('active')
    $(this).toggleClass('active')
    if (href.indexOf("#") != -1) {
        var headNavHeight = $('.headNav').height();
        $('html, body').animate({
            scrollTop: $(href).offset().top - headNavHeight
        }, 500);
    } else {
        showWin(href);
    }
    return false;
});
$('.circuitDiv .process li').click(function(event) {
    showCircuit($(this).data('num'));
});
$('.ruleDiv .tabItem').click(function(event) {
    console.log("1111");
    showRule($(this).data('num'));
});
$('.exchangeDiv .form button').click(function(event) {
    var b1value = $('.exchangeDiv .b1 input').val();
    if (b1value == '') {
        msg('请填写您要兑换的数量');
        return;
    }
});
$('.whyDiv .buts li').click(function(event) {
    showWhy($(this).data('num'));
});
$('.faqDiv .list .arrow').click(function(event) {
    $(this).eq().isUp = !$(this).eq().isUp
    console.log($(this).eq())
    $(this).toggleClass('up')
    $(this).parent().next().toggle()
});
$('.winDiv .colse').click(function(event) {
    $('.winDiv').fadeOut(200);
    $('.winMask').fadeOut(200);
});
$('.winMask').click(function(event) {
    $('.winDiv').fadeOut(200);
    $('.winMask').fadeOut(200);
});
showCircuit(1);
showWhy(1);
$('#tipDiv').hide();
let exchangeType = 'usdt_to_trx';
$('.countBox button.count').click(function(event) {
    var b1value = $('.countBox .b1 input').val();
    if (b1value == '' || b1value == 0) {
        msg('请填写您要兑换的数量');
        return;
    }
    var b2value;
    let late = {
        Late: 0.04,
        TRXPrice: 0.057592,
        gasLastTrxUsdtPrice: 0.25586282656,
        gasUsdtPrice: 0.25586282656
    }
    if (exchangeType == 'usdt_to_trx') {
        b2value = (b1value / late.TRXPrice) * (1 - late.Late) - late.gasLastTrxUsdtPrice;
    } else {
        b2value = (b1value * late.TRXPrice) * (1 - late.Late) - late.gasUsdtPrice;
    }
    let oldVal = b2value + '';
    let val = '';
    if (oldVal.indexOf('.') > -1) {
        val = oldVal.substring(0, oldVal.indexOf('.') + 7);
    } else {
        val = oldVal
    }
    console.log(val, 'val')
    $('.countBox .b2 input').val(val);
});
$('.countBox .currencyChange').click(function(event) {
    console.log(event, $(this).attr('data-type'));
    exchangeType = $(this).attr('data-type') === 'usdt_to_trx' ? 'trx_to_usdt' : 'usdt_to_trx';
    $(this).attr('data-type', exchangeType);
    $('.countBox .b1 input').val(0);
    $('.countBox .b2 input').val('');
    if (exchangeType === 'usdt_to_trx') {
        $('.countBox .b1 span').html('USDT');
        $('.countBox .b2 span').html('TRX');
    } else {
        $('.countBox .b1 span').html('TRX');
        $('.countBox .b2 span').html('USDT');
    }
});