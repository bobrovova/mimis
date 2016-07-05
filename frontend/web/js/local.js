function subscrubeUser(){
    $(".subscrube a.submit").click(function (){
        if($("[name='SubscrubeForm[email]']").val() != ''){
            var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
            if(pattern.test($("[name='SubscrubeForm[email]']").val())){
                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    method: "POST",
                    url: "index.php?r=service/subscribeuser",
                    data: { email: $("[name='SubscrubeForm[email]']").val(), _csrf : csrfToken}
                })
                    .done(function( msg ) {
                        alert( "Data Saved: " + msg );
                    });
            } else {
                $("[name='SubscrubeForm[email]']").css("color", "red");
            }
        }

        return false;
    });
}

function catalogHideBlocks(){
    $(".sortContainer .title").click(function(){
        $(this).parent().find(".content").toggle("normal", function(){
            if($(this).parent().find(".title").hasClass("unactive")){
                $(this).parent().find(".title").removeClass("unactive");
            } else {
                $(this).parent().find(".title").addClass("unactive");
            }
        });
    });
}

function selectParams(){
    $(".selectParams a").click(function(){
        var id = $(this).attr("data-id-param");
        $(this).parent().parent().parent().attr("data-param", id);
        $(this).parent().parent().find(".active").removeClass("active");
        $(this).addClass("active");
    });
}

function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function Cart(){
    $(".addToCart a").click(function(){
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            method: "POST",
            url: "index.php?r=catalog/addtocart",
            data: { idItem: $("[name='Product[id]']").val(),
                count : $("[name='Product[count]']").val(),
                param: $("#size").attr("data-param"),
                _csrf : csrfToken,
                crtss: getCookie('crtss')
            }
        })
            .done(function( msg ) {
                var items = jQuery.parseJSON(msg);
                $("#cart_items").text(items.Count);
                $("#cart_sum").text(items.Sum);
            });
        return false;
    });
}

function changeProfileForm(){
    $(".settingsProfile a.btnService").click(function(){
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            method: "POST",
            url: "index.php?r=service/changeprofileajax",
            data: { "changeform[first_name]": $("[name='first_name']").val(),
                    "changeform[second_name]": $("[name='second_name']").val(),
                    "changeform[last_name]": $("[name='last_name']").val(),
                    "changeform[mobile_phone]": $("[name='mobile_phone']").val(),
                    "changeform[city]": $("[name='city']").val(),
                    "changeform[street]": $("[name='street']").val(),
                    "changeform[zipcode]": $("[name='zipcode']").val(),
                    "changeform[house]": $("[name='house']").val(),
                    "changeform[stroenie]": $("[name='stroenie']").val(),
                    "changeform[korpus]": $("[name='korpus']").val(),
                    "changeform[podyezd]": $("[name='podyezd']").val(),
                    "changeform[floor]": $("[name='floor']").val(),
                    "changeform[apartment]": $("[name='apartment']").val(),
                    _csrf : csrfToken
            }
        })
            .done(function( msg ) {
                alert( "Data Saved: " + msg );
            });
    });
}

function manageCart(){
    $('.deleteActionCart').click(function(){
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $(this).parent().parent().remove();
        $.ajax({
            method: "POST",
            url: "index.php?r=catalog/deletefromcart",
            data: { idcart: $(this).data().idcart,
                _csrf : csrfToken,
            }
        })
            .complete(function( msg ) {
                refreshCart();
            });
        return false;
    });

    $(".inputCount").on("change paste keyup", function() {
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var input = $(this);
        $.ajax({
            method: "POST",
            url: "index.php?r=catalog/changecountcart",
            data: { idcart: $(this).data().idcart,
                count: $(this).val(),
                _csrf : csrfToken,
            }
        })
            .complete(function( msg ) {
                var items = jQuery.parseJSON(msg.responseText);
                if(items.Sum == null) items.Sum = 0;
                $("#cart_items").text(items.Count);
                $("#cart_sum").text(items.Sum);
                $(".total span").text(items.Sum);
                input.parent().parent().find('.allprice').text(items.ItemSum + " р.");
            });
    });

    $('.checkOrder').click(function(){
        $('.modal_order_data').show();
    });

    $('.finalOrder').click(function(){
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        var modal = $(this).parent().parent();
        $.ajax({
            method: "POST",
            url: "index.php?r=catalog/order",
            data: { nameClient: modal.find('[name=nameClient]').val(),
                phoneClient: modal.find('[name=phoneClient]').val(),
                _csrf : csrfToken,
            }
        })
            .complete(function( msg ) {
                modal.hide();
                $('.modal_order_thanks').show();
                $('.cartItem').remove();
                refreshCart();
            });
        return false;
    });

    $('.close').click(function(){
        $(this).parent().hide();
    });
}

function refreshCart(){
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $(this).parent().parent().remove();
    $.ajax({
        method: "POST",
        url: "index.php?r=catalog/refreshcart",
        data: {
            _csrf : csrfToken,
        }
    })
        .done(function( msg ) {
            var items = jQuery.parseJSON(msg);
            if(items.Sum == null) items.Sum = 0;
            $("#cart_items").text(items.Count);
            $("#cart_sum").text(items.Sum);
            $(".total span").text(items.Sum);
        });
}