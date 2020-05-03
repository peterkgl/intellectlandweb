$("#select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".price").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".price").hide();
            }
        });
    }).change();
     $('input[type="radio"]').click(function(){
        var inputValue = $(this).attr("value");
        var targetBox = $("." + inputValue);
        $(".form").not(targetBox).hide();
        $(targetBox).show();
    });