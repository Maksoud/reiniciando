/**
 * Desenvolvido por:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

;
(function($) {
    $(document).ready(function($) {

        /**********************************************************************/
        
        RemoveTableRow = function (handler) 
        {
            //Identifica a tag
            var tr    = $(handler).closest('tr');

            //Exclui a linha com delay animado
            tr.fadeOut(350, function () {
                $(this).closest('tr').next().remove();
            });

            return false;
        };
        
        /**********************************************************************/
        
    });
})(jQuery);