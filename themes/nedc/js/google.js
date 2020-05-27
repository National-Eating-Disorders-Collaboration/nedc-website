(function($) {

    function postal_code($input) {
        var input = document.getElementById($input);
        var options = {
            types: ['(regions)']
        }
        var autocomplete = new google.maps.places.Autocomplete(input, options);

    google.maps.event.addListener(autocomplete, 'place_changed', 
        function() {
            var place = autocomplete.getPlace().address_components;
            
            var componentMap = {
                postal_code: 'postal_code',
                country: 'country',
                locality: 'locality',
                administrative_area_level_1 : 'administrative_area_level_1',
            };
    
            for(var i = 0; i < place.length; i++){
                var types = place[i].types; 
                
                for(var j = 0; j < types.length; j++){ 
                    var component_type = types[j];

                    switch (component_type) {
                        case 'postal_code':
                            var postal_code = place[i]['long_name'];
                        break;
                        case 'locality':
                            var city = place[i]['long_name'];
                        break;
                        case 'administrative_area_level_1':
                            var state = place[i]['short_name'];
                        break;
                        case 'country':
                            var country = place[i]['long_name'];
                        break;
                    }
                    if($input == 'Form_EventRegistrationForm_PostCode') {
                        $('#Form_EventRegistrationForm_State').val(state);
                        $('#Form_EventRegistrationForm_PostCode').val(postal_code);
                    }

                    if($input == 'Form_RegisterForm_Postcode') {
                        $('#Form_RegisterForm_Postcode').val(postal_code);
                        $('#Form_RegisterForm_Country').val(country);
                        $('#Form_RegisterForm_City').val(city);
                        $('#Form_RegisterForm_State').val(state);
                    }

                    if($input == 'Form_MemberUpdateForm_Postcode') {
                        $('#Form_MemberUpdateForm_Postcode').val(postal_code);
                        $('#Form_MemberUpdateForm_Country').val(country);
                        $('#Form_MemberUpdateForm_City').val(city);
                        $('#Form_MemberUpdateForm_State').val(state);
                    }
                }
            }
        });
    }

    $(document).ready(function() {
        function inputOnBlur(input) {
            $(input).on('blur', function() {
                // Clear inputs 
                if($(input).val() <= 0) {
                    var data = $('.js-postcode-autocomplete').find('input');
                    data.each(function(i, d) {
                        $(d).val('');
                    });
                }
            });
        }
        inputOnBlur('#Form_RegisterForm_Postcode');
    });

  //INIT
  google.maps.event.addDomListener(window, 'load', postal_code('Form_EventRegistrationForm_PostCode'));
  google.maps.event.addDomListener(window, 'load', postal_code('Form_RegisterForm_Postcode'));
  google.maps.event.addDomListener(window, 'load', postal_code('Form_MemberUpdateForm_Postcode'));

})(jQuery);