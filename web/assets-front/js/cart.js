$(document).ready(function(){
    //console.log('chargement du fichier');

    $('#detailCart').on('click', '.btn-danger', function(event){
        event.preventDefault();
        //console.log(this);

        var $product = $(this).closest('.item-product');
        //console.log($(this))

        $.ajax({
            url: $(this).attr('href'),
            dataType: 'json'
        }).done(function(data, textStatus){
            //console.log(data);
            //console.log(textStatus);

            $product.fadeOut(700, function(){
                // Animation terminé
                $(this).remove();
            });

        });

    });


    $('#detailCart').on('click', '.moins', function(event){
        event.preventDefault();

        var qty =$('.form-control').attr('value');
        var newQty = qty-1;

        //console.log($newQty);
        if(newQty==0){
            $(this).closest('.item-product').find('.btn-danger').trigger('click');
        } else {

            $.ajax({
                url: $(this).attr('href'),
                dataType: 'json'
            }).done(function(data){

                var qty =$('.form-control').attr('value');
                qty--;
                console.log(data);

            });

        }

    });


    $('#detailCart').on('click', '.plus', function(event){
        event.preventDefault();

        //console.log($(this).closest('.item-product').find('.form-control').attr('value'));
        //console.log($(this).closest('.item-product').find('.price strong span').text());
        var that = $(this);

        $.ajax({
            url: $(this).attr('href'),
            dataType: 'json'
        }).done(function(data){

            var productSelect=that.closest('.item-product');

            var qty =productSelect.find('.form-control').attr('value');
            qty++;

            var priceUnit=productSelect.find('.price strong span').text();
            //console.log(priceUnit);
            var priceTotal=priceUnit*qty;
            //console.log(priceTotal);

            productSelect.find('.form-control').attr('value',qty);
            productSelect.find('.pricetotal strong span').text(priceTotal);

            productSelect.find('.text-right h5 strong span').text(priceTotal);
            productSelect.find('.text-right h3 strong span').text(priceTotal);
            //console.log($('.pricetotal strong span').text());



        });

    });

});