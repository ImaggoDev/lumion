function upgradeForm() {
    const form_wrapper = jQuery('section[data-upgrade-form]');
    const form = jQuery(form_wrapper).find('form');
    let wrapper = document.querySelector('[data-upgrade-form]');

    jQuery(form).submit(function( event ) {
        event.preventDefault();
        let response = wrapper.querySelector('[data-response]');
        response.innerHTML = '<div class="lds-dual-ring"></div>';

        let data = jQuery(form).serialize();
        jQuery.ajax({
            type: "post",
            url: my_ajax_object.ajax_url,
            data: {
                action: 'get_upgrade_info',
                form: data,
            },
            success: function(msg){
                console.log('success');
                response.innerHTML = msg;
            }
        })
    })
}


function seatsForm() {
    const form_wrapper = jQuery('section[data-seats-form]');
    console.log("-> form_wrapper", form_wrapper);
    const form = jQuery(form_wrapper).find('form');
    console.log("-> form", form);
    let wrapper = document.querySelector('[data-seats-form]');
    console.log("-> wrapper", wrapper);


    jQuery(form).submit(function( event ) {
        event.preventDefault();
        let response = wrapper.querySelector('[data-response]');
        response.innerHTML = '<div class="lds-dual-ring"></div>';


        let data = jQuery(form).serialize();
        jQuery.ajax({
            type: "post",
            url: my_ajax_object.ajax_url,
            data: {
                action: 'get_seats_info',
                form: data,
            },
            dataType: 'JSON',
            success: function(msg){
                console.log(msg['data']);
                if(msg['action'] == 'html') {
                    response.innerHTML = msg['data'];
                } else {
                    window.location.href = msg['data'];
                }
            }
        })
    })
}

jQuery(document).ready(function () {

    jQuery('.custom-form').each(function(){
        jQuery(this).removeClass('is-blocked');
    })

    upgradeForm();
    seatsForm();
})