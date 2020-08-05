/**
 * Desenvolvido por:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

;
(function($){
	
    $(document).ready(function($){
        
        //MONEY, PHONE, DATE MASK
        var mask = {            
            money: function() {                
                var el = this
                ,exec = function(v) {
                    v = v.replace(/\D/g, '');
                    v = new String(Number(v));
                    var len = v.length;

                    if (len == 1){
                        v = v.replace(/(\d)/, '0,0$1');
                    }                   
                    else if (len == 2){
                        v = v.replace(/(\d)/, '0,$1');
                    }                   
                    else if (len > 2 && len <= 5){
                        v = v.replace(/(\d{2})$/, ',$1');
                    }
                    else if (len > 5){
                       v = v.replace(/(\d{2})$/, ',$1').replace(/\d(?=(?:\d{3})+(?:\D|$))/g, '$&.');
                    }
                    return v;
                };

                setTimeout(function(){
                    el.value = exec(el.value);
                },1);
            },
            phone: function(){
                var phone, element;
                element = $(this);
                phone = element.val().replace(/\D/g, '');
                var len = phone.length;
                
                if (len > 10) {
                    element.inputmask("(99) 99999-9999");
                } else {
                    element.inputmask("(99) 9999-9999#");
                }
            },
            date: function(){
                var date, element;
                element = $(this);
                date = element.val().replace(/\D/g, '');
                element.inputmask("99/99/9999");
            }
        };
        
        /**********************************************************************/
        
        //Máscara de telefone
        var SPMaskBehavior = function (val) {
            return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
          },
          spOptions = {
            onKeyPress: function(val, e, field, options) {
                field.mask(SPMaskBehavior.apply({}, arguments), options);
              }
          };
        //$('.sp_celphones').mask(SPMaskBehavior, spOptions);
        
        /**********************************************************************/
        
		//Máscaras para as buscas
		function Masks($modal)
        {
			$($modal + ' .datemask').mask('00/00/0000');
			$($modal + ' .phonemask').mask(SPMaskBehavior, spOptions);
			$($modal + ' .cepmask').mask('00000-000');
			$($modal + ' .ordermask').mask('00.00.00.00', {'translation': {0: {pattern: /[0-9]/}}});
			$($modal + ' .moneymask').mask('000.000.000.000,00', {reverse: true});
            $($modal + ' .valuemask').maskMoney({showSymbol: false, symbol: "R$ ", decimal: ",", thousands: ".", allowZero: true});
            $($modal + ' .fourdecimals').maskMoney({showSymbol: false, precision: 4, decimal: ",", thousands: ".", allowZero: true});
			
			//CPF/CNPJ
			var options =  {
				onKeyPress: function(cpfcnpj, e, field, options){
					var masks = ['000.000.000-00', '00.000.000/0000-00'];
					  mask = ($($modal + ' .tipocpfcnpj').val() == 'J') ? masks[1] : masks[0];
					$($modal + ' .cpfcnpjmask').mask(mask, options);
				}
			};
			
			if ($($modal + ' .tipocpfcnpj').val() == 'F') {
				$($modal + ' .cpfcnpjmask').mask('000.000.000-00', options);
			} else if ($($modal + ' .tipocpfcnpj').val() == 'J') {
				$($modal + ' .cpfcnpjmask').mask('00.000.000/0000-00', options);
			}
		}
		
		Masks('');
        
		//Máscaras para o modal
        $('#modal_item').on('shown.bs.modal', function () {
        	Masks('#modal_item_body');
        });
		
		//Máscaras para o modal2
		$('#modal_item2').on('shown.bs.modal', function () {
			Masks('#modal_item_body2');
        });
		
		//Máscaras para o modal3
		$('#modal_item3').on('shown.bs.modal', function () {
			Masks('#modal_item_body3');
        });
        
        /**********************************************************************/
		
		//Datas
		function DataInical($modal)
		{
			$($modal + ' #dtinicial').on('change', function(){
				var pieces = $($modal + ' #dtinicial').val().split('/');
				pieces.reverse();
				var reversed = pieces.join('/');

				$($modal + ' #dtfinal').datepicker('setStartDate', new Date(reversed));
				$($modal + ' #dtfinal').val("");
			});
		}
        
		DataInical('');
		
        //controle do campo de data, mostrar ano e depois o mes para selecionar *sem dia
		function Datepicker($modal)
		{
			$($modal + ' .datepicker').datepicker({
				orientation: 'top',
				format: "dd/mm/yyyy",
				language: "pt-BR",
				autoclose: true,
				todayHighlight: true,
				disableTouchKeyboard: true
			});
		}
		
		Datepicker('');
		
		//Datas para o modal
        $('#modal_item').on('shown.bs.modal', function () {
        	Datepicker('#modal_item_body');
        	DataInical('#modal_item_body');
        });
		
		//Datas para o modal2
		$('#modal_item2').on('shown.bs.modal', function () {
			Datepicker('#modal_item_body2');
        	DataInical('#modal_item_body2');
        });
		
		//Datas para o modal3
		$('#modal_item3').on('shown.bs.modal', function () {
			Datepicker('#modal_item_body3');
        	DataInical('#modal_item_body3');
        });
		
		/*
        $('.controldate').bind('focusout', function (){
            var today = new Date(),
                dd    = today.getDate(),
                mm    = today.getMonth() + 1, //January is 0!
                yyyy  = today.getFullYear();
                
            if(dd < 10) {
                dd = '0' + dd;
            }
            
            if(mm < 10) {
                mm = '0' + mm;
            }
            
            today = dd + '/' + mm + '/' + yyyy;
            //document.write(today);
        });
		*/
        
        /**********************************************************************/
		
        //** end code **//
    });
})(jQuery);