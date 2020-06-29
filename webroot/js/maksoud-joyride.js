/**
 * Desenvolvido por:
 *     Renée Maksoud
 *     Cristian John
 *     Thomas Kanzig
 * 
 * All rights reserved - 2015-2019
 */

$(window).load(function () {
    $('#joyRideTipContent').joyride({
        autoStart: true,
        postStepCallback: function (index, tip) {
            if (index == 6) {
                $(this).joyride('set_li', false, 1);
            }
        },
        modal:  true,
        expose: true,
        template: {// HTML segments for tip layout
            link:         '<a href="#close" class="joyride-close-tip">&times;</a>',
            timer:        '<div class="joyride-timer-indicator-wrap"><span class="joyride-timer-indicator"></span></div>',
            tip:          '<div class="joyride-tip-guide"><span class="joyride-nub"></span></div>',
            wrapper:      '<div class="joyride-content-wrapper"></div>',
            button:       '<a href="#" class="small button joyride-next-tip bottom-10" id="joyride_button" style="float:right;"></a>',
            prev_button:  '<a href="#" class="small button joyride-prev-tip"></a>',
            modal:        '<div class="joyride-modal-bg"></div>',
            expose:       '<div class="joyride-expose-wrapper"></div>',
            expose_cover: '<div class="joyride-expose-cover"></div>'
        }
    });
    
    $('.joyride-next-tip').click(function () {
        if ($('input[name="dismiss"]').is(":checked")) {

            $.get("pages/dismiss_tutorial");

        }//if ($('input[name="dismiss"]').is(":checked"))
    });
});