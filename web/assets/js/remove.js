
$(document).ready( function() {

    $(".btn-danger").on('click', function(event) {

        var rub = "";
        var rubrique=$('.rubrique');
        //alert(rubrique.val());

        switch(rubrique.val()){

            case 'troiswa_back_category' : rub='cette categorie'; break;
            case 'troiswa_back_product'   : rub='ce produit'  ; break;
            //default :  ''  ;

        }

        //$test=$('.table').children('td').html();
        //alert($test);

        var message='Etes-vous sûr de vouloir supprimer '+rub+" ?";

        var stop = confirm(message);

        if (stop == false) {
            event.preventDefault();
        }
    })

    $('#datetimepicker').datetimepicker();

});



