/**
 * Desenvolvido por:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

//EVITA MULTIPLOS CADASTROS AO SER PRESSIONADO DIVERSAS VEZES O BOTÃO GRAVAR
function MultiClick() {
    try {

        var    submit = $('button[onclick="MultiClick()"]');
        const oldtext = submit[0].innerText;

        setTimeout(function(){

            //Muda o texto do botão
            //if (oldtext == "Gravar") { submit.html("Gravando..."); }
            //if (oldtext == "Save") { submit.html("Saving..."); }
            //if (oldtext == "Gerar Relatório") { submit.html("Gerando...") }
            //if (oldtext == "Report") { submit.html("Baking...") }

            //Muda de submit para button para evitar 
            //submit.attr('type', 'button');

        }, 50);

        setTimeout(function(){ 

            //Retorna o parâmetro de submit
            //submit.attr('type', 'submit');

            //Retorna o texto anterior
            //submit.html(oldtext);

        }, 4000);

    } catch (e) {
        console.log(e);
    }
};

/*
var submit = $('button[type="submit"]');

submit.on('click', 
    setTimeout(function(){ 
        submit.attr('type', 'button')
    }, 50),
    setTimeout(function(){ 
        submit.attr('type', 'submit')
    }, 2000)
);

function MultiClick() {
    setTimeout(function(){ 
        submit.attr('type', 'button')
    }, 50);
    setTimeout(function(){ 
        submit.attr('type', 'submit')
    }, 2000);
}

submit.on('click', MultiClick());

$('#modal_item').on('shown.bs.modal', function () {
    //Masks('#modal_item_body');
    MultiClick();
});

//Máscaras para o modal2
$('#modal_item2').on('shown.bs.modal', function () {
    //Masks('#modal_item_body2');
    MultiClick();
});

//Máscaras para o modal3
$('#modal_item3').on('shown.bs.modal', function () {
    //Masks('#modal_item_body3');
    MultiClick();
});

function MultiClick() {
    //OPÇÃO 1
    //$(this).attr('disabled', true);
    //setTimeout(function () {$('input[type="submit"]').removeAttr('disabled');}, 2000);

    //OPÇÃO 2
    //$(this).addClass('hidden');
    //setTimeout(function () {$('input[type="submit"]').removeClass('hidden');}, 2000);

    $(this).attr('id', 'submit');
    setTimeout(function () {$('#submit').attr('type', 'button');}, 50); //possibilita as validações de preenchimento
    setTimeout(function () {$('#submit').attr('type', 'submit');}, 2000);//impossibilita o clique múltiplo
};
*/

//** end code **//